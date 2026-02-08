<?php
class AdminController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        // Auth Check
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . url('login'));
            exit;
        }

        // Fetch Users
        $stmtUsers = $this->pdo->prepare("SELECT * FROM users ORDER BY created_at DESC LIMIT 5");
        $stmtUsers->execute();
        $users = $stmtUsers->fetchAll();

        // Fetch Carousel Items
        $stmtCarousel = $this->pdo->prepare("SELECT * FROM carousel_items ORDER BY display_order ASC");
        $stmtCarousel->execute();
        $carouselItems = $stmtCarousel->fetchAll();

        // If no carousel items, use mock for display
        if (empty($carouselItems)) {
            $carouselItems = [
                ['id' => 1, 'title' => 'Gestión Logística Eficiente', 'description' => 'Optimiza y controla...', 'file_path' => 'assets/img/slide1.jpg'],
                ['id' => 2, 'title' => 'Optimización Logística', 'description' => 'Mejora procesos...', 'file_path' => 'assets/img/slide2.jpg'],
                ['id' => 3, 'title' => 'Monitoreo Logístico', 'description' => 'Visualización en tiempo real...', 'file_path' => 'assets/img/slide3.jpg'],
            ];
        }

        // Fetch Content Sections
        $stmtContent = $this->pdo->prepare("SELECT * FROM content_pages");
        $stmtContent->execute();
        $contentPages = $stmtContent->fetchAll();

        view('admin/dashboard', [
            'users' => $users,
            'carouselItems' => $carouselItems,
            'contentPages' => $contentPages
        ]);
    }
}
?>