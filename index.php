<?php
session_start();

// Load Database Config
require_once 'config/db.php';

// Dynamic Base Path Detection
$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = str_replace('/index.php', '', $scriptName);
$request = $_SERVER['REQUEST_URI'];
$path = str_replace($basePath, '', $request);
$path = strtok($path, '?');

// If path is empty, default to /
if (empty($path)) {
    $path = '/';
}

// Helper function for URL generation
function url($path = '') {
    global $basePath;
    return $basePath . '/' . ltrim($path, '/');
}

// Helper function to view rendering
function view($view, $data = []) {
    extract($data);
    $viewFile = "views/{$view}.php";
    if (file_exists($viewFile)) {
        require_once $viewFile;
    } else {
        echo "View not found: {$viewFile}";
    }
}

// Router Logic
switch ($path) {
    case '/':
    case '/index.php':
    case '/home':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController($pdo);
        $controller->index();
        break;
        
    case '/login':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        break;
        
    case '/logout':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController($pdo);
        $controller->logout();
        break;

    case '/dashboard':
        require 'controllers/DashboardController.php';
        $controller = new DashboardController($pdo);
        $controller->index();
        break;
        
    case '/admin':
    case '/admin/dashboard':
        require 'controllers/AdminController.php';
        $controller = new AdminController($pdo);
        $controller->index();
        break;
        
    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
?>