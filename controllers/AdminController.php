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
        $stmtUsers = $this->pdo->prepare("SELECT * FROM users ORDER BY created_at DESC");
        $stmtUsers->execute();
        $users = $stmtUsers->fetchAll();

        // Fetch Carousel Items
        $stmtCarousel = $this->pdo->prepare("SELECT * FROM carousel_items ORDER BY display_order ASC");
        $stmtCarousel->execute();
        $carouselItems = $stmtCarousel->fetchAll();

        // Fetch Content Sections
        $stmtContent = $this->pdo->prepare("SELECT * FROM content_pages");
        $stmtContent->execute();
        $contentPages = $stmtContent->fetchAll();

        // Fetch QR Codes
        $stmtQR = $this->pdo->prepare("SELECT * FROM qr_codes ORDER BY category, id DESC");
        $stmtQR->execute();
        $qrCodes = $stmtQR->fetchAll();

        view('admin/dashboard', [
            'users' => $users,
            'carouselItems' => $carouselItems,
            'contentPages' => $contentPages,
            'qrCodes' => $qrCodes
        ]);
    }

    // --- User Management ---
    public function saveUser() {
        $this->checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $password = $_POST['password'] ?? '';

            if ($id) {
                // Update
                $sql = "UPDATE users SET full_name = ?, email = ?, role = ? WHERE id = ?";
                $params = [$full_name, $email, $role, $id];
                
                if (!empty($password)) {
                    $sql = "UPDATE users SET full_name = ?, email = ?, role = ?, password_hash = ? WHERE id = ?";
                    $params = [$full_name, $email, $role, password_hash($password, PASSWORD_DEFAULT), $id];
                }
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($params);
            } else {
                // Create
                if (empty($password)) {
                    // Error: Password required for new user
                    header("Location: " . url('admin?error=password_required'));
                    exit;
                }
                $stmt = $this->pdo->prepare("INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$full_name, $email, password_hash($password, PASSWORD_DEFAULT), $role]);
            }
        }
        header("Location: " . url('admin'));
        exit;
    }

    public function deleteUser() {
        $this->checkAdmin();
        if (isset($_POST['id'])) {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$_POST['id']]);
        }
        header("Location: " . url('admin'));
        exit;
    }

    // --- Carousel Management ---
    public function saveCarousel() {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $title = $_POST['title'];
            $description = $_POST['description'];
            $display_order = $_POST['display_order'] ?? 0;
            
            $filePath = null;
            $fileType = 'image';

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Max size check: 25MB (25 * 1024 * 1024 bytes)
                if ($_FILES['image']['size'] > 25 * 1024 * 1024) {
                    header("Location: " . url('admin?error=file_too_large'));
                    exit;
                }

                $uploadDir = 'assets/img/carousel/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                
                // Determine file type
                $mimeType = mime_content_type($_FILES['image']['tmp_name']);
                if (strpos($mimeType, 'video') === 0) {
                    $fileType = 'video';
                }

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                    $filePath = $uploadDir . $fileName;
                }
            }

            if ($id) {
                // Update
                if ($filePath) {
                    // Delete old file
                    $stmt = $this->pdo->prepare("SELECT file_path FROM carousel_items WHERE id = ?");
                    $stmt->execute([$id]);
                    $oldItem = $stmt->fetch();
                    if ($oldItem && file_exists($oldItem['file_path'])) {
                        unlink($oldItem['file_path']);
                    }

                    $stmt = $this->pdo->prepare("UPDATE carousel_items SET title = ?, description = ?, display_order = ?, file_path = ?, file_type = ? WHERE id = ?");
                    $stmt->execute([$title, $description, $display_order, $filePath, $fileType, $id]);
                } else {
                    $stmt = $this->pdo->prepare("UPDATE carousel_items SET title = ?, description = ?, display_order = ? WHERE id = ?");
                    $stmt->execute([$title, $description, $display_order, $id]);
                }
            } else {
                // Create
                if (!$filePath) {
                    header("Location: " . url('admin?error=image_required'));
                    exit;
                }
                $stmt = $this->pdo->prepare("INSERT INTO carousel_items (title, description, display_order, file_path, file_type, uploaded_by) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $description, $display_order, $filePath, $fileType, $_SESSION['user_id']]);
            }
        }
        header("Location: " . url('admin'));
        exit;
    }

    public function deleteCarousel() {
        $this->checkAdmin();
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $stmt = $this->pdo->prepare("SELECT file_path FROM carousel_items WHERE id = ?");
            $stmt->execute([$id]);
            $item = $stmt->fetch();
            
            if ($item && file_exists($item['file_path'])) {
                unlink($item['file_path']);
            }
            
            $stmt = $this->pdo->prepare("DELETE FROM carousel_items WHERE id = ?");
            $stmt->execute([$id]);
        }
        header("Location: " . url('admin'));
        exit;
    }

    // --- Content Management ---
    public function updateContent() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $page_name = $_POST['page_name'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            
            $stmt = $this->pdo->prepare("UPDATE content_pages SET title = ?, content = ?, last_edited_by = ? WHERE page_name = ?");
            $stmt->execute([$title, $content, $_SESSION['user_id'], $page_name]);
        }
        header("Location: " . url('admin'));
        exit;
    }

    // --- QR Management ---
    public function addQr() {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $subtitle = $_POST['subtitle'] ?? '';
            $category = $_POST['category'] ?? 'Sedial';
            
            // Handle File Upload
            if (isset($_FILES['qr_image']) && $_FILES['qr_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/img/qr/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['qr_image']['name']);
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['qr_image']['tmp_name'], $targetPath)) {
                    $stmt = $this->pdo->prepare("INSERT INTO qr_codes (title, subtitle, image_path, category, uploaded_by) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$title, $subtitle, $targetPath, $category, $_SESSION['user_id']]);
                }
            }
        }
        
        header("Location: " . url('admin'));
        exit;
    }

    public function deleteQr() {
        $this->checkAdmin();

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            // Get file path to delete file
            $stmt = $this->pdo->prepare("SELECT image_path FROM qr_codes WHERE id = ?");
            $stmt->execute([$id]);
            $qr = $stmt->fetch();
            
            if ($qr && file_exists($qr['image_path'])) {
                unlink($qr['image_path']);
            }
            
            $stmt = $this->pdo->prepare("DELETE FROM qr_codes WHERE id = ?");
            $stmt->execute([$id]);
        }
        
        header("Location: " . url('admin'));
        exit;
    }

    private function checkAdmin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . url('login'));
            exit;
        }
    }
}
?>
