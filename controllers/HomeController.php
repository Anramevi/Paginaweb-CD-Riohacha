<?php
class HomeController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        // Fetch active carousel items
        $stmt = $this->pdo->prepare("SELECT * FROM carousel_items WHERE is_active = 1 ORDER BY display_order ASC");
        $stmt->execute();
        $carouselItems = $stmt->fetchAll();

        // If no carousel items, create default mock data
        if (empty($carouselItems)) {
            $carouselItems = [
                [
                    'file_path' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                    'title' => 'Gestión Logística Eficiente',
                    'description' => 'Optimiza y controla toda tu operación logística desde un solo lugar.'
                ],
                [
                    'file_path' => 'https://images.unsplash.com/photo-1580674684081-7617fbf3d745?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                    'title' => 'Monitoreo en Tiempo Real',
                    'description' => 'Visualiza tus KPIs y toma decisiones basadas en datos.'
                ],
                [
                    'file_path' => 'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
                    'title' => 'Distribución Segura',
                    'description' => 'Garantizamos la seguridad y eficiencia en cada entrega.'
                ]
            ];
        }

        // Fetch "Nosotros" content
        $stmt = $this->pdo->prepare("SELECT * FROM content_pages WHERE page_name = 'nosotros'");
        $stmt->execute();
        $nosotros = $stmt->fetch();

        // Fetch Pillars
        $stmt = $this->pdo->prepare("SELECT * FROM pillar_info");
        $stmt->execute();
        $pillars = $stmt->fetchAll();

        // Fetch QR Codes
        $stmt = $this->pdo->prepare("SELECT * FROM qr_codes ORDER BY id DESC");
        $stmt->execute();
        $qrCodes = $stmt->fetchAll();

        view('home/index', [
            'carouselItems' => $carouselItems,
            'nosotros' => $nosotros,
            'pillars' => $pillars,
            'qrCodes' => $qrCodes
        ]);
    }
}
?>