<?php require 'views/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-primary text-white sidebar collapse" style="min-height: 100vh; background: linear-gradient(180deg, #1e3a8a 0%, #3b82f6 100%);">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <i class="bi bi-shield-lock fs-1"></i>
                    <h5 class="mt-2">Panel Admin</h5>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active text-white bg-white bg-opacity-10 rounded mb-2" href="#">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-opacity-75 hover-white mb-2" href="#">
                            <i class="bi bi-people me-2"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-opacity-75 hover-white mb-2" href="#">
                            <i class="bi bi-images me-2"></i> Carrusel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-opacity-75 hover-white mb-2" href="index.php">
                            <i class="bi bi-house-door me-2"></i> Ir al Sitio
                        </a>
                    </li>
                </ul>
                <div class="mt-5 px-3">
                    <a href="logout" class="btn btn-outline-light w-100 btn-sm">
                        <i class="bi bi-box-arrow-left me-2"></i> Salir
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 bg-light">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-primary-blue">Panel de Administración</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="input-group me-2">
                        <input type="text" class="form-control" placeholder="Buscar..." aria-label="Search">
                        <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Users Management Card -->
                <div class="col-12 col-xl-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-primary-blue">Usuarios</h5>
                            <button class="btn btn-warning text-white btn-sm fw-bold">+ Añadir Usuario</button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-3">Usuario</th>
                                            <th>Correo electrónico</th>
                                            <th>Rol</th>
                                            <th class="text-end pe-3">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($users)): ?>
                                            <!-- Mock Data -->
                                            <tr>
                                                <td class="ps-3"><div class="d-flex align-items-center"><i class="bi bi-person-circle fs-5 me-2 text-muted"></i> Alejandro Gómez</div></td>
                                                <td>alejandrogomez@gmail.com</td>
                                                <td><span class="badge bg-primary">Admin</span></td>
                                                <td class="text-end pe-3">
                                                    <button class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-3"><div class="d-flex align-items-center"><i class="bi bi-person-circle fs-5 me-2 text-muted"></i> Andrea Rios</div></td>
                                                <td>andrea.rios@hotmail.com</td>
                                                <td><span class="badge bg-secondary">User</span></td>
                                                <td class="text-end pe-3">
                                                    <button class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td class="ps-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-person-circle fs-5 me-2 text-muted"></i> 
                                                        <?php echo htmlspecialchars($user['full_name']); ?>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td>
                                                    <span class="badge <?php echo $user['role'] === 'admin' ? 'bg-primary' : 'bg-secondary'; ?>">
                                                        <?php echo ucfirst($user['role']); ?>
                                                    </span>
                                                </td>
                                                <td class="text-end pe-3">
                                                    <button class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></button>
                                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Management Card -->
                <div class="col-12 col-xl-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-primary-blue">Carrusel</h5>
                            <button class="btn btn-outline-primary btn-sm">+ Añadir Imagen o Video</button>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted mb-3">01 Images/videos</h6>
                            <?php foreach ($carouselItems as $item): ?>
                            <div class="d-flex align-items-center mb-3 bg-light p-2 rounded">
                                <div class="me-3" style="width: 80px; height: 50px; background-color: #ddd; border-radius: 4px; overflow: hidden;">
                                    <?php if(strpos($item['file_path'] ?? '', 'http') === 0): ?>
                                        <img src="<?php echo htmlspecialchars($item['file_path']); ?>" class="w-100 h-100 object-fit-cover">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="bi bi-image"></i></div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold text-truncate" style="max-width: 200px;"><?php echo htmlspecialchars($item['title']); ?></h6>
                                    <small class="text-muted text-truncate d-block" style="max-width: 200px;"><?php echo htmlspecialchars($item['description']); ?></small>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary me-1">Editar</button>
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Content Editor -->
                <div class="col-12 col-xl-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-primary-blue">Inicio - Editar página</h5>
                            <button class="btn btn-outline-primary btn-sm">+ Añadir Sección</button>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Editor de contenido</label>
                                <div class="border rounded p-2 mb-2 bg-light d-flex gap-2">
                                    <button class="btn btn-sm btn-light"><i class="bi bi-type-bold"></i></button>
                                    <button class="btn btn-sm btn-light"><i class="bi bi-type-italic"></i></button>
                                    <button class="btn btn-sm btn-light"><i class="bi bi-list-ul"></i></button>
                                    <button class="btn btn-sm btn-light"><i class="bi bi-link"></i></button>
                                    <button class="btn btn-sm btn-light"><i class="bi bi-image"></i></button>
                                </div>
                                <div class="border rounded p-3 bg-white" style="min-height: 150px;">
                                    <h4 class="fw-bold">Nosotros</h4>
                                    <p>Soluciones logísticas integrales para mejorar la eficiencia de tu operación. Monitorea, analiza y optimiza procesos clave para una gestión logística más ágil y efectiva.</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted small">
                                    <i class="bi bi-person-circle me-1"></i> Última edición por Andrea Rios
                                </div>
                                <div>
                                    <button class="btn btn-warning text-white fw-bold me-2">Guardar Cambios</button>
                                    <button class="btn btn-secondary">Vista Previa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Widgets -->
                <div class="col-12 col-xl-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0 fw-bold text-primary-blue">Widget Principales</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <span><i class="bi bi-justify-left me-2 text-primary"></i> Nosotros</span>
                                    <button class="btn btn-sm text-primary"><i class="bi bi-pencil-fill"></i></button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <span><i class="bi bi-qr-code me-2 text-primary"></i> Codigos QR</span>
                                    <button class="btn btn-sm text-primary"><i class="bi bi-pencil-fill"></i></button>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <span><i class="bi bi-list-stars me-2 text-primary"></i> Nuestros Pilares</span>
                                    <button class="btn btn-sm text-primary"><i class="bi bi-pencil-fill"></i></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>