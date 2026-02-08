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

        // Mock Data for KPI Dashboard if DB is empty
        // In a real app, you would query the 'kpi_data' table
        $kpis = [
            [
                'kpi_name' => 'TRI',
                'indicator' => '% Cashless',
                'unit' => '%',
                'trigger' => '<= 88 / = 97',
                'mtd' => '1/99',
                'daily' => ['1/99', '1/99', '1/99', '1/100', '1/09', '1/100', '0/100', '110', '110', '14'],
                'status' => 'danger' // Icon type
            ],
            [
                'kpi_name' => 'OTIF',
                'indicator' => '% RESUSAL',
                'unit' => '%',
                'trigger' => '<= 1,6',
                'mtd' => '1,99',
                'daily' => ['1,84', '1,6', '2,47', '1,77', '0,91', '1,56', '0,91', '1,84', '1,221', ''],
                'status' => 'primary'
            ],
            [
                'kpi_name' => 'OTIF',
                'indicator' => 'EF. Cargue',
                'unit' => '%',
                'trigger' => '= 90',
                'mtd' => '95,4',
                'daily' => ['100', '100', '8.1', '85', '1', '85', '0', '91', '86', ''],
                'status' => 'danger'
            ],
            [
                'kpi_name' => 'NPS',
                'indicator' => 'Entrega en rango',
                'unit' => '%',
                'trigger' => '= 87',
                'mtd' => '86,1',
                'daily' => ['87,7', '78,9', '87,3', '87,3', '81,3', '81,3', '81,3', '87,1', '88,1', ''],
                'status' => 'warning'
            ],
            [
                'kpi_name' => 'ONTIME',
                'indicator' => 'Salida antes de 7',
                'unit' => '%',
                'trigger' => '= 95',
                'mtd' => '> 95',
                'daily' => ['6', '18', '6,1', '5,2', '5,6', '5,6', '52,3', '52,3', '56', ''],
                'status' => 'secondary'
            ]
        ];

        view('dashboard/index', ['kpis' => $kpis]);
    }
}
?>