<?php require 'views/layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <a href="<?php echo url('home'); ?>" class="btn btn-outline-primary mb-4 rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i> Volver al Inicio
            </a>
            
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white p-5 text-center" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                    <h1 class="display-4 fw-bold mb-0"><?php echo htmlspecialchars($pillar['title']); ?></h1>
                </div>
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="text-primary-blue mb-4">Información General</h3>
                            <p class="lead text-muted">
                                <?php echo nl2br(htmlspecialchars($pillar['description'])); ?>
                            </p>
                            <p class="text-muted">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="bi bi-bar-chart-line-fill text-primary opacity-25" style="font-size: 8rem;"></i>
                        </div>
                    </div>
                    
                    <hr class="my-5">
                    
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="p-4 bg-light rounded-4 h-100 text-center">
                                <i class="bi bi-gear fs-1 text-primary mb-3"></i>
                                <h5 class="fw-bold">Configuración</h5>
                                <p class="small text-muted mb-0">Ajustes específicos para este pilar.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 bg-light rounded-4 h-100 text-center">
                                <i class="bi bi-graph-up fs-1 text-primary mb-3"></i>
                                <h5 class="fw-bold">Indicadores</h5>
                                <p class="small text-muted mb-0">Visualiza el rendimiento en tiempo real.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 bg-light rounded-4 h-100 text-center">
                                <i class="bi bi-file-earmark-text fs-1 text-primary mb-3"></i>
                                <h5 class="fw-bold">Reportes</h5>
                                <p class="small text-muted mb-0">Genera y descarga informes detallados.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>
