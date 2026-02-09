<?php require 'views/layouts/header.php'; ?>

<div class="container-fluid px-4 mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary-blue mb-0">TABLERO DIARIO LOGÍSTICA</h2>
            <p class="text-muted">Monitoreo de indicadores clave de desempeño</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <i class="bi bi-funnel"></i> Agregar Filtro
            </button>
            <button class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-download"></i> Descargar
            </button>
            <button class="btn btn-outline-secondary">
                <i class="bi bi-gear"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-arrow-clockwise"></i> Actualizar
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Actualizar ahora</a></li>
                </ul>
            </div>
        </div>
    </div>

    <?php
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];
    ?>

    <!-- KPI Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-light border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <i class="bi bi-table me-2 text-primary"></i>
                <h6 class="mb-0 fw-bold">TABLERO LOGÍSTICA - <?php echo $meses[$selectedMonth] . ' ' . $selectedYear; ?></h6>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <!-- Filtros de Fecha -->
                <form method="GET" action="<?php echo url('dashboard'); ?>" class="d-flex gap-2">
                    <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                        <?php foreach($meses as $num => $nombre): ?>
                            <option value="<?php echo $num; ?>" <?php echo $num == $selectedMonth ? 'selected' : ''; ?>>
                                <?php echo $nombre; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                        <?php for($y=2024; $y<=2030; $y++): ?>
                            <option value="<?php echo $y; ?>" <?php echo $y == $selectedYear ? 'selected' : ''; ?>>
                                <?php echo $y; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </form>

                <?php if(isset($_SESSION['user_id'])): ?>
                <div>
                    <span class="badge bg-success text-white">Edición Habilitada</span>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0 text-center table-sm" style="font-size: 0.8rem; min-width: 1800px;">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="bg-danger text-white position-sticky start-0" style="z-index: 10;">KPI Impactado</th>
                        <th class="bg-danger text-white position-sticky" style="left: 100px; z-index: 10;">Indicador</th>
                        <th class="bg-danger text-white">UM</th>
                        <th class="bg-danger text-white">Meta</th>
                        <th class="bg-danger text-white">Disparador</th>
                        <th class="bg-danger text-white fw-bold">MTD</th>
                        <?php for($d=1; $d<=$daysInMonth; $d++): ?>
                            <th class="bg-primary text-white" style="min-width: 40px;"><?php echo $d; ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    function evaluateKpiStatus($value, $meta, $disparador) {
                        if ($value === '-' || $value === '') return 'text-dark';
                        
                        // Determinar si hay formato dividido (X/Y)
                        $valParts = [];
                        if (strpos($value, '/') !== false) {
                            $parts = explode('/', $value);
                            if (count($parts) == 2) {
                                $valParts = [
                                    'x' => (float)str_replace([',', '%'], ['.', ''], trim($parts[0])),
                                    'y' => (float)str_replace([',', '%'], ['.', ''], trim($parts[1]))
                                ];
                            }
                        }
                        
                        if (empty($valParts)) {
                            // Valor simple
                            $valParts = ['x' => (float)str_replace([',', '%'], ['.', ''], $value)];
                        }

                        // Parse Trigger Condition (Disparador)
                        $isTriggered = false;
                        if ($disparador) {
                            $trigParts = [];
                            if (strpos($disparador, '/') !== false) {
                                $tParts = explode('/', $disparador);
                                if (count($tParts) == 2) {
                                    $trigParts = ['x' => trim($tParts[0]), 'y' => trim($tParts[1])];
                                }
                            }
                            if (empty($trigParts)) $trigParts = ['x' => $disparador];

                            // Check Trigger
                            foreach ($valParts as $key => $v) {
                                $cond = isset($trigParts[$key]) ? $trigParts[$key] : (isset($trigParts['x']) && count($trigParts)==1 ? $trigParts['x'] : '');
                                if ($cond === '' || $cond === null) continue;

                                $op = trim(preg_replace('/[0-9\.\-]+/', '', $cond));
                                $target = (float)str_replace($op, '', $cond);
                                
                                if ($op == '<=') { if ($v <= $target) $isTriggered = true; }
                                elseif ($op == '>=') { if ($v >= $target) $isTriggered = true; }
                                elseif ($op == '<') { if ($v < $target) $isTriggered = true; }
                                elseif ($op == '>') { if ($v > $target) $isTriggered = true; }
                                elseif ($op == '=') { if ($v == $target) $isTriggered = true; }
                                elseif ($op == '') { if ($v == $target) $isTriggered = true; }
                            }
                        }

                        if ($isTriggered) return 'text-danger fw-bold trigger-alert'; // Incumple totalmente + Recuadro Azul

                        // Parse Goal Condition (Meta)
                        $isGoalMet = true;
                        if ($meta) {
                             $metaParts = [];
                             if (strpos($meta, '/') !== false) {
                                 $mParts = explode('/', $meta);
                                 if (count($mParts) == 2) {
                                     $metaParts = ['x' => trim($mParts[0]), 'y' => trim($mParts[1])];
                                 }
                             }
                             if (empty($metaParts)) $metaParts = ['x' => $meta];

                             foreach ($valParts as $key => $v) {
                                $cond = isset($metaParts[$key]) ? $metaParts[$key] : (isset($metaParts['x']) && count($metaParts)==1 ? $metaParts['x'] : '');
                                if ($cond === '' || $cond === null) continue;

                                $op = trim(preg_replace('/[0-9\.\-]+/', '', $cond));
                                $target = (float)str_replace($op, '', $cond);
                                
                                $met = false;
                                if ($op == '<=') { if ($v <= $target) $met = true; }
                                elseif ($op == '>=') { if ($v >= $target) $met = true; }
                                elseif ($op == '<') { if ($v < $target) $met = true; }
                                elseif ($op == '>') { if ($v > $target) $met = true; }
                                elseif ($op == '=') { if ($v == $target) $met = true; }
                                elseif ($op == '') { if ($v == $target) $met = true; } // Implicit equality

                                if (!$met) $isGoalMet = false;
                             }
                        }

                        if (!$isGoalMet) return 'text-danger fw-bold'; // No cumple meta (Rojo)

                        return 'text-success fw-bold'; // Cumple meta (Verde)
                    }
                    ?>
                    
                    <?php foreach ($definitions as $def): ?>
                    <tr>
                        <td class="fw-bold text-start ps-2 position-sticky start-0 bg-white" style="z-index: 5;"><?php echo htmlspecialchars($def['kpi_impactado']); ?></td>
                        <td class="text-start ps-2 position-sticky bg-white" style="left: 100px; z-index: 5; white-space: nowrap; max-width: 150px; overflow: hidden; text-overflow: ellipsis;" title="<?php echo htmlspecialchars($def['indicador']); ?>">
                            <?php echo htmlspecialchars($def['indicador']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($def['unidad_medida']); ?></td>
                        <td class="small text-muted"><?php echo htmlspecialchars($def['meta']); ?></td>
                        <td class="small text-danger fw-bold"><?php echo htmlspecialchars($def['disparador']); ?></td>
                        
                        <?php 
                        // MTD Coloring
                        $metaVal = $def['meta'] ?? 0;
                        $dispVal = $def['disparador'] ?? 0;
                        $mtdClass = evaluateKpiStatus($mtdData[$def['id']], $metaVal, $dispVal);
                        // Adjust bg-danger to text-danger for MTD if preferred, or keep background
                        // Requirement: "resaltado" -> background is better visibility
                        ?>
                        <td class="<?php echo $mtdClass; ?>"><?php echo $mtdData[$def['id']]; ?></td>
                        
                        <?php for($d=1; $d<=$daysInMonth; $d++): ?>
                            <?php 
                                $val = $monthlyData[$def['id']][$d] ?? ''; 
                                $cellId = "cell-{$def['id']}-{$d}";
                                $currentDate = sprintf('%04d-%02d-%02d', $selectedYear, $selectedMonth, $d);
                                $isEditable = isset($_SESSION['user_id']);
                                
                                $cellClass = evaluateKpiStatus($val, $metaVal, $dispVal);
                            ?>
                            <td 
                                id="<?php echo $cellId; ?>"
                                class="<?php echo $isEditable ? 'cursor-pointer' : ''; ?> <?php echo $cellClass; ?>"
                                <?php if($isEditable): ?>
                                onclick="editKpi(<?php echo $def['id']; ?>, '<?php echo htmlspecialchars($val); ?>', '<?php echo htmlspecialchars($def['indicador']); ?>', '<?php echo $currentDate; ?>', '<?php echo $d; ?>')"
                                <?php endif; ?>
                            >
                                <?php if($val !== ''): ?>
                                    <span class="d-block w-100 h-100 py-1"><?php echo htmlspecialchars($val); ?></span>
                                <?php else: ?>
                                    <span class="text-muted opacity-25">-</span>
                                <?php endif; ?>
                            </td>
                        <?php endfor; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editKpiModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title fs-6 fw-bold" id="modalDateDisplay">Fecha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editKpiForm" onsubmit="event.preventDefault(); saveKpi();">
                        <input type="hidden" name="kpi_id" id="kpiId">
                        <input type="hidden" name="date" id="kpiDate">
                        <input type="hidden" id="dayNumber">
                        
                        <div class="mb-3">
                            <label class="form-label small text-muted">Indicador</label>
                            <input type="text" class="form-control form-control-sm bg-light" id="kpiIndicator" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Valor</label>
                            <input type="text" class="form-control" name="value" id="kpiValue" placeholder="Ingrese valor...">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    let editModal;
    
    document.addEventListener('DOMContentLoaded', function() {
        editModal = new bootstrap.Modal(document.getElementById('editKpiModal'));
        const editModalEl = document.getElementById('editKpiModal');

        // Focus input on modal open
        editModalEl.addEventListener('shown.bs.modal', () => {
            document.getElementById('kpiValue').focus();
        });
    });

    function editKpi(id, currentValue, indicatorName, dateStr, dayNum) {
        if (!editModal) return;
        
        document.getElementById('kpiId').value = id;
        document.getElementById('kpiValue').value = currentValue;
        document.getElementById('kpiIndicator').value = indicatorName;
        document.getElementById('kpiDate').value = dateStr;
        document.getElementById('dayNumber').value = dayNum;
        document.getElementById('modalDateDisplay').textContent = dateStr;
        editModal.show();
    }

    function saveKpi() {
        const form = document.getElementById('editKpiForm');
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => data[key] = value);

        fetch('<?php echo url("dashboard/update"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); 
            } else {
                alert('Error: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al guardar. Verifique la consola.');
        });
    }
    </script>

    <!-- Status Legend -->
    <div class="d-flex justify-content-center gap-4 mb-5">
        <div class="d-flex align-items-center bg-white px-4 py-2 rounded-pill shadow-sm border">
            <i class="bi bi-check-square-fill text-success me-2 fs-5"></i>
            <span class="fw-bold">Meta cumplida</span>
        </div>
        <div class="d-flex align-items-center bg-white px-4 py-2 rounded-pill shadow-sm border">
            <i class="bi bi-exclamation-square-fill text-danger me-2 fs-5"></i>
            <span class="fw-bold">Meta fallida</span>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>