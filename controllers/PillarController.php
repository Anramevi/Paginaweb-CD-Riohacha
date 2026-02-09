<?php
class PillarController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $name = $_GET['name'] ?? null;
        if (!$name) {
            header("Location: " . url('home'));
            exit;
        }

        // Static definition for now as requested
        $pillars = [
            'flota' => [
                'title' => 'Gestión de Flota',
                'description' => 'Aquí encontrarás toda la información relacionada con el monitoreo, mantenimiento y gestión de nuestra flota de transporte. Esta sección está destinada a centralizar los indicadores y herramientas para optimizar el uso de nuestros vehículos.'
            ],
            'almacen' => [
                'title' => 'Almacén (Warehouse)',
                'description' => 'Gestión integral del almacenamiento, inventarios y procesos logísticos dentro del centro de distribución. Monitorea entradas, salidas y la organización eficiente de los productos.'
            ],
            'people' => [
                'title' => 'Talento Humano (People)',
                'description' => 'Espacio dedicado a la gestión de nuestro equipo. Aquí se visualizarán indicadores de desempeño, capacitación, seguridad y bienestar de nuestros colaboradores.'
            ],
            'seguridad' => [
                'title' => 'Seguridad Operativa',
                'description' => 'Protocolos, reportes y métricas de seguridad para garantizar una operación libre de riesgos. La seguridad es nuestra prioridad número uno.'
            ],
            'reparto' => [
                'title' => 'Distribución y Reparto',
                'description' => 'Control y seguimiento de las entregas a nuestros clientes. Analiza la eficiencia de rutas, tiempos de entrega y satisfacción del cliente final.'
            ],
        ];

        $pillar = $pillars[$name] ?? null;

        if (!$pillar) {
            $pillar = [
                'title' => ucfirst($name), 
                'description' => 'Contenido estándar de prueba. Esta página está en construcción.'
            ];
        }

        view('pillar/index', ['pillar' => $pillar]);
    }
}
?>
