<?php require 'views/layouts/header.php'; ?>

<!-- Hero Carousel -->
<div class="container mt-4">
    <div class="row">
        <!-- Carousel Section -->
        <div class="col-lg-8 mb-4">
            <div id="mainCarousel" class="carousel slide rounded-4 overflow-hidden shadow-sm" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php foreach ($carouselItems as $index => $item): ?>
                        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>"></button>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-inner">
                    <?php foreach ($carouselItems as $index => $item): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div style="height: 400px; background-color: #000;">
                                <img src="<?php echo htmlspecialchars($item['file_path']); ?>" class="d-block w-100 h-100" style="object-fit: cover; opacity: 0.7;" alt="<?php echo htmlspecialchars($item['title']); ?>">
                            </div>
                            <div class="carousel-caption d-none d-md-block text-start" style="bottom: 20%; left: 10%; right: 10%;">
                                <h2 class="display-5 fw-bold"><?php echo htmlspecialchars($item['title']); ?></h2>
                                <p class="fs-5"><?php echo htmlspecialchars($item['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>

        <!-- Login / Quick Access Card -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body p-4 d-flex flex-column justify-content-center">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <h3 class="fw-bold mb-3">Iniciar Sesión</h3>
                        <form action="<?php echo url('login'); ?>" method="POST">
                            <div class="mb-3">
                                <label class="form-label text-muted">Correo electrónico</label>
                                <input type="email" name="email" class="form-control form-control-lg bg-light border-0" placeholder="nombre@empresa.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Contraseña</label>
                                <input type="password" name="password" class="form-control form-control-lg bg-light border-0" placeholder="••••••••" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
                            </div>
                            <div class="text-center mt-3">
                                <a href="#" class="text-decoration-none small">Recuperar contraseña</a>
                            </div>
                            <div class="d-grid gap-2 mt-4">
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="bi bi-google me-2"></i> Ingresar con Google
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="bi bi-microsoft me-2"></i> Ingresar con Microsoft
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="text-center">
                            <h3 class="fw-bold mb-3">Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h3>
                            <p class="text-muted mb-4">Has iniciado sesión correctamente.</p>
                            <a href="<?php echo url('dashboard'); ?>" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="bi bi-speedometer2 me-2"></i> Ir al Tablero
                            </a>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <a href="<?php echo url('admin'); ?>" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="bi bi-gear me-2"></i> Panel Admin
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Sections Row -->
    <div class="row mb-4">
        <!-- Nosotros -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div>
                        <h4 class="fw-bold mb-3"><?php echo isset($nosotros['title']) ? htmlspecialchars($nosotros['title']) : 'Nosotros'; ?></h4>
                        <p class="text-muted">
                            <?php echo isset($nosotros['content']) ? htmlspecialchars($nosotros['content']) : 'Soluciones logísticas integrales para mejorar la eficiencia de tu operación.'; ?>
                        </p>
                        <button class="btn btn-primary px-4">Conocer más</button>
                    </div>
                    <div class="ms-3 d-none d-sm-block">
                        <i class="bi bi-truck fs-1 text-primary-blue opacity-50" style="font-size: 4rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tableros Call to Action -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold mb-3">TABLEROS</h4>
                        <p class="text-muted">Accede a tus indicadores clave de desempeño.</p>
                        <a href="<?php echo url('dashboard'); ?>" class="btn btn-primary px-4">Ver tableros</a>
                    </div>
                    <div class="ms-3">
                        <i class="bi bi-graph-up-arrow fs-1 text-primary-blue opacity-50" style="font-size: 4rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Codes Section -->
    <h4 class="fw-bold mb-3">Códigos QR</h4>
    <div class="row mb-5">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 d-flex justify-content-between align-items-center bg-white">
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-box-seam fs-3 text-primary me-2"></i>
                            <h5 class="fw-bold m-0 text-primary-blue">Sedial</h5>
                        </div>
                        <p class="mb-1 fw-bold">Contacto Sedial:</p>
                        <p class="mb-1 text-primary">+ 57 314 820 5463</p>
                        <p class="mb-0 text-primary">+ 57 311 830 3704</p>
                    </div>
                    <div class="bg-light p-2 rounded">
                        <!-- Placeholder QR -->
                        <i class="bi bi-qr-code fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 d-flex justify-content-between align-items-center bg-white">
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-shield-check fs-3 text-success me-2"></i>
                            <h5 class="fw-bold m-0 text-primary-blue">SLA</h5>
                        </div>
                        <p class="mb-1 fw-bold">Contacto SLA:</p>
                        <p class="mb-1 text-primary">+ 57 300 333 1427</p>
                        <p class="mb-0 text-primary">+ 57 351 722 8207</p>
                    </div>
                    <div class="bg-light p-2 rounded">
                        <!-- Placeholder QR -->
                        <i class="bi bi-qr-code fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pillars Section -->
    <h4 class="fw-bold mb-3">Nuestros Pilares</h4>
    <div class="row row-cols-2 row-cols-md-5 g-4 mb-5">
        <!-- Static Pillars for Demo if DB is empty, otherwise Loop -->
        <?php 
        $defaultPillars = [
            ['icon' => 'bi-truck', 'name' => 'Flota', 'bg' => 'bg-primary-subtle'],
            ['icon' => 'bi-building', 'name' => 'Warehouse', 'bg' => 'bg-primary-subtle'],
            ['icon' => 'bi-people', 'name' => 'People', 'bg' => 'bg-primary-subtle'],
            ['icon' => 'bi-shield-lock', 'name' => 'Seguridad', 'bg' => 'bg-primary-subtle'],
            ['icon' => 'bi-box', 'name' => 'Reparto', 'bg' => 'bg-primary-subtle'],
        ];
        ?>
        <?php foreach ($defaultPillars as $pillar): ?>
        <div class="col">
            <div class="card border-0 shadow-sm h-100 text-center py-4 rounded-4 hover-shadow transition">
                <div class="card-body">
                    <div class="rounded-circle <?php echo $pillar['bg']; ?> d-inline-flex p-3 mb-3 text-primary">
                        <i class="bi <?php echo $pillar['icon']; ?> fs-2"></i>
                    </div>
                    <h6 class="fw-bold text-primary-blue mb-0"><?php echo $pillar['name']; ?></h6>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>
