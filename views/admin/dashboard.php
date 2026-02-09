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
                        <a class="nav-link text-white text-opacity-75 hover-white mb-2" href="#users-section">
                            <i class="bi bi-people me-2"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-opacity-75 hover-white mb-2" href="#carousel-section">
                            <i class="bi bi-images me-2"></i> Carrusel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-opacity-75 hover-white mb-2" href="<?php echo url('home'); ?>">
                            <i class="bi bi-house-door me-2"></i> Ir al Sitio
                        </a>
                    </li>
                </ul>
                <div class="mt-5 px-3">
                    <a href="<?php echo url('logout'); ?>" class="btn btn-outline-light w-100 btn-sm">
                        <i class="bi bi-box-arrow-left me-2"></i> Salir
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 bg-light">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-primary-blue">Panel de Administración</h1>
            </div>

            <div class="row g-4">
                <!-- Users Management Card -->
                <div class="col-12 col-xl-6" id="users-section">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-primary-blue">Usuarios</h5>
                            <button class="btn btn-warning text-white btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Añadir Usuario</button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 400px;">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light sticky-top">
                                        <tr>
                                            <th class="ps-3">Usuario</th>
                                            <th>Email</th>
                                            <th>Rol</th>
                                            <th class="text-end pe-3">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                                <form action="<?php echo url('admin/delete_user'); ?>" method="POST" onsubmit="return confirm('¿Eliminar usuario?');" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Management Card -->
                <div class="col-12 col-xl-6" id="carousel-section">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-primary-blue">Carrusel</h5>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCarouselModal">+ Añadir Imagen</button>
                        </div>
                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                            <?php foreach ($carouselItems as $item): ?>
                            <div class="d-flex align-items-center mb-3 bg-light p-2 rounded">
                                <div class="me-3" style="width: 80px; height: 50px; background-color: #ddd; border-radius: 4px; overflow: hidden;">
                                    <?php if(isset($item['file_type']) && $item['file_type'] === 'video'): ?>
                                        <video src="<?php echo htmlspecialchars($item['file_path']); ?>" class="w-100 h-100 object-fit-cover" muted></video>
                                    <?php elseif(strpos($item['file_path'] ?? '', 'http') === 0 || strpos($item['file_path'] ?? '', 'assets') === 0): ?>
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
                                    <form action="<?php echo url('admin/delete_carousel'); ?>" method="POST" onsubmit="return confirm('¿Eliminar item?');" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- QR Codes Management Card -->
                <div class="col-12 col-xl-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-primary-blue">Códigos QR</h5>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addQrModal">+ Añadir QR</button>
                        </div>
                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                            <?php if(empty($qrCodes)): ?>
                                <p class="text-muted text-center">No hay códigos QR configurados.</p>
                            <?php else: ?>
                                <?php foreach ($qrCodes as $qr): ?>
                                <div class="d-flex align-items-center mb-3 bg-light p-2 rounded">
                                    <div class="me-3" style="width: 50px; height: 50px; background-color: #fff; border-radius: 4px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                        <img src="<?php echo htmlspecialchars($qr['image_path']); ?>" class="img-fluid" style="max-height: 100%;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($qr['title']); ?></h6>
                                            <span class="badge bg-secondary"><?php echo htmlspecialchars($qr['category'] ?? 'Sedial'); ?></span>
                                        </div>
                                        <small class="text-muted"><?php echo htmlspecialchars($qr['subtitle']); ?></small>
                                    </div>
                                    <div class="ms-2">
                                        <form action="<?php echo url('admin/delete_qr'); ?>" method="POST" onsubmit="return confirm('¿Eliminar este QR?');" style="display:inline;">
                                            <input type="hidden" name="id" value="<?php echo $qr['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Content Editor -->
                <div class="col-12 col-xl-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-primary-blue">Editar Contenido (Nosotros)</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            $nosotros = null;
                            foreach ($contentPages as $page) {
                                if ($page['page_name'] === 'nosotros') {
                                    $nosotros = $page;
                                    break;
                                }
                            }
                            ?>
                            <form action="<?php echo url('admin/update_content'); ?>" method="POST">
                                <input type="hidden" name="page_name" value="nosotros">
                                <div class="mb-3">
                                    <label class="form-label">Título</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($nosotros['title'] ?? 'Nosotros'); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contenido</label>
                                    <textarea name="content" class="form-control" rows="5"><?php echo htmlspecialchars($nosotros['content'] ?? ''); ?></textarea>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modals -->

<!-- Add QR Modal -->
<div class="modal fade" id="addQrModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Código QR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo url('admin/add_qr'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Categoría (Contratista)</label>
                        <select name="category" class="form-select" required>
                            <option value="Sedial">Sedial</option>
                            <option value="SLA">SLA</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="title" class="form-control" placeholder="Ej: Contacto" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subtítulo</label>
                        <input type="text" name="subtitle" class="form-control" placeholder="Ej: +57 300 123 4567" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Imagen QR</label>
                        <input type="file" name="qr_image" class="form-control" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo url('admin/save_user'); ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="role" class="form-select">
                            <option value="user">Usuario</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Carousel Modal -->
<div class="modal fade" id="addCarouselModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Archivo al Carrusel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo url('admin/save_carousel'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo (Imagen o Video, Max 25MB)</label>
                        <input type="file" name="image" class="form-control" accept="image/*,video/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Orden</label>
                        <input type="number" name="display_order" class="form-control" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>
