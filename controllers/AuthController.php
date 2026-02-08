<?php
class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function showLogin() {
        if (isset($_SESSION['user_id'])) {
            header("Location: " . url('dashboard'));
            exit;
        }
        view('auth/login');
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $error = "Por favor ingrese correo y contraseña.";
            view('auth/login', ['error' => $error]);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                if (!$user['is_active']) {
                    $error = "Su cuenta está desactivada. Contacte al administrador.";
                    view('auth/login', ['error' => $error]);
                    return;
                }

                // Set Session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];

                // Update Last Login
                $updateStmt = $this->pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
                $updateStmt->execute(['id' => $user['id']]);

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header("Location: " . url('admin'));
                } else {
                    header("Location: " . url('dashboard'));
                }
                exit;
            } else {
                $error = "Credenciales incorrectas.";
                view('auth/login', ['error' => $error]);
            }
        } catch (PDOException $e) {
            $error = "Error de base de datos: " . $e->getMessage();
            view('auth/login', ['error' => $error]);
        }
    }

    public function logout() {
        session_destroy();
        header("Location: " . url('home'));
        exit;
    }
}
?>