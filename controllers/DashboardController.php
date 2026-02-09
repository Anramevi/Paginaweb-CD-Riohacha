<?php
class DashboardController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . url('login'));
            exit;
        }

        // Obtener mes y año de filtros o defaults
        $selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
        $selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
        
        // Validar rango
        if ($selectedMonth < 1 || $selectedMonth > 12) $selectedMonth = (int)date('m');
        if ($selectedYear < 2020 || $selectedYear > 2030) $selectedYear = (int)date('Y');

        // Calcular días en el mes
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
        
        // Obtener definiciones de KPIs
        $stmt = $this->pdo->query("SELECT * FROM kpi_definitions ORDER BY display_order ASC");
        $definitions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener valores para todo el mes seleccionado
        $startDate = sprintf('%04d-%02d-01', $selectedYear, $selectedMonth);
        $endDate = sprintf('%04d-%02d-%02d', $selectedYear, $selectedMonth, $daysInMonth);

        $stmt = $this->pdo->prepare("
            SELECT kpi_id, date_value, value 
            FROM kpi_values 
            WHERE date_value BETWEEN ? AND ?
        ");
        $stmt->execute([$startDate, $endDate]);
        $rawValues = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Organizar valores: [kpi_id][day_number] = value
        $monthlyData = [];
        foreach ($rawValues as $row) {
            $day = (int)date('j', strtotime($row['date_value']));
            $monthlyData[$row['kpi_id']][$day] = $row['value'];
        }

        // Calcular MTD para cada KPI
            $mtdData = [];
            foreach ($definitions as $def) {
                $kpiId = $def['id'];
                $values = $monthlyData[$kpiId] ?? [];
                
                if (empty($values)) {
                    $mtdData[$kpiId] = '-';
                    continue;
                }

                // Lógica de cálculo MTD
                $sum = 0;
                $count = 0;
                
                // Variables para cálculo independiente (X/Y)
                $sumX = 0;
                $sumY = 0;
                $countX = 0;
                $countY = 0;
                $isSplitFormat = false;

                foreach ($values as $val) {
                    if ($val === '' || $val === '-') continue;

                    // Soporte para "X/Y" (Cashless, Ausentismo)
                    if (strpos($val, '/') !== false) {
                        $parts = explode('/', $val);
                        if (count($parts) == 2) {
                            $isSplitFormat = true;
                            $valX = (float)str_replace([',', '%'], ['.', ''], trim($parts[0]));
                            $valY = (float)str_replace([',', '%'], ['.', ''], trim($parts[1]));
                            
                            $sumX += $valX;
                            $sumY += $valY;
                            $countX++;
                            // countY usually matches countX
                        }
                    } else {
                        $numVal = (float)str_replace([',', '%'], ['.', ''], $val);
                        $sum += $numVal;
                        $count++;
                    }
                }

                // Formatear resultado MTD
                if ($isSplitFormat && $countX > 0) {
                    // Promediar independientemente
                    $avgX = $sumX / $countX;
                    $avgY = $sumY / $countX; // Asumiendo mismo número de entradas
                    
                    // Formato output: "AvgX / AvgY"
                    // Redondear a 1 decimal o entero según magnitud? Usamos 1 decimal por defecto.
                    // Para Ausentismo (enteros) quizás 0 decimales? 
                    // El usuario pide "Promedio", así que decimales son válidos.
                    
                    $mtdData[$kpiId] = number_format($avgX, 1) . ' / ' . number_format($avgY, 1);
                } elseif ($count > 0) {
                    $avg = $sum / $count;
                    $mtdData[$kpiId] = number_format($avg, 1); 
                    // Añadir % si la unidad es %
                    if (strpos($def['unidad_medida'], '%') !== false) {
                        $mtdData[$kpiId] .= '%';
                    }
                } else {
                    $mtdData[$kpiId] = '-';
                }
            }

        view('dashboard/index', [
            'definitions' => $definitions,
            'monthlyData' => $monthlyData,
            'mtdData' => $mtdData,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'daysInMonth' => $daysInMonth
        ]);
    }

    public function update() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if ($input) {
            $kpiId = $input['kpi_id'] ?? null;
            $value = $input['value'] ?? null;
            $date = $input['date'] ?? date('Y-m-d');

            if ($kpiId && $value !== null) {
                // Validar formato Cashless si es necesario (simple validación de string por ahora)
                // Insertar o Actualizar
                $stmt = $this->pdo->prepare("
                    INSERT INTO kpi_values (kpi_id, date_value, value, updated_by) 
                    VALUES (?, ?, ?, ?) 
                    ON DUPLICATE KEY UPDATE value = VALUES(value), updated_by = VALUES(updated_by)
                ");
                
                try {
                    $stmt->execute([$kpiId, $date, $value, $_SESSION['user_id']]);
                    echo json_encode(['success' => true, 'message' => 'KPI actualizado correctamente']);
                } catch (PDOException $e) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Error al guardar: ' . $e->getMessage()]);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Datos incompletos']);
            }
        }
    }
}
?>