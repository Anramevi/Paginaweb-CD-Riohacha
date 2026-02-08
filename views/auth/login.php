<?php require 'views/layouts/header.php'; ?>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card border-0 shadow-lg rounded-4" style="max-width: 400px; width: 100%;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-shield-check text-primary" style="font-size: 3rem;"></i>
                <h3 class="fw-bold mt-2">Iniciar Sesión</h3>
                <p class="text-muted">Bienvenido de nuevo</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo url('login'); ?>" method="POST">
                <div class="mb-3">
                    <label class="form-label text-muted">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control bg-light border-0" placeholder="nombre@empresa.com" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label text-muted">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control bg-light border-0" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">Ingresar</button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="index.php" class="text-decoration-none text-muted">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>