<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CD Riohacha - Gestión Logística</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1e3a8a;
            --secondary-blue: #3b82f6;
            --accent-gold: #f59e0b;
        }
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
        }
        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .btn-primary {
            background-color: var(--secondary-blue);
            border-color: var(--secondary-blue);
        }
        .btn-primary:hover {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        .text-primary-blue {
            color: var(--primary-blue);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo url('home'); ?>">
                <i class="bi bi-shield-check fs-2 text-primary me-2"></i>
                <div class="d-flex flex-column">
                    <span class="fw-bold lh-1 text-primary-blue">CD RIOHACHA</span>
                    <small class="text-muted" style="font-size: 0.7rem;">Gestión Logística</small>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="<?php echo url('home'); ?>">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="<?php echo url('dashboard'); ?>">Tableros</a>
                    </li>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold text-primary" href="<?php echo url('admin'); ?>">Administración</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex gap-2">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i>
                                <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo url('logout'); ?>">Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo url('login'); ?>" class="btn btn-primary px-4 rounded-pill">
                            <i class="bi bi-person-fill me-1"></i> Iniciar Sesión
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <div style="margin-top: 80px;"></div> <!-- Spacer for fixed navbar -->
