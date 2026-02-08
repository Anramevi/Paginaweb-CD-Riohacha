<?php require 'views/layouts/header.php'; ?>

<div class="container-fluid px-4 mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary-blue mb-0">TABLERO DIARIO LOGÍSTICA</h2>
            <p class="text-muted">Monitoreo de indicadores clave de desempeño</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <i class="bi bi-funnel"></i> Agregar Filtro
            </button>
            <button class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-download"></i> Descargar
            </button>
            <button class="btn btn-outline-secondary">
                <i class="bi bi-gear"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-arrow-clockwise"></i> Actualizar
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Actualizar ahora</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- KPI Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-light border-0 py-3">
            <div class="d-flex align-items-center">
                <i class="bi bi-table me-2 text-primary"></i>
                <h6 class="mb-0 fw-bold">TABLERO LOGÍSTICA</h6>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0 text-center" style="font-size: 0.9rem;">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="bg-primary-subtle text-dark" style="width: 50px;"><i class="bi bi-list"></i></th>
                        <th class="bg-danger text-white">KPI Impactado</th>
                        <th class="bg-danger text-white">PI</th>
                        <th class="bg-danger text-white">UM</th>
                        <th class="bg-danger text-white">Disparador</th>
                        <th class="bg-danger text-white">MTD</th>
                        <th class="bg-primary text-white">Lun</th>
                        <th class="bg-primary text-white">Mar</th>
                        <th class="bg-primary text-white">Mié</th>
                        <th class="bg-primary text-white">Jue</th>
                        <th class="bg-primary text-white">Vie</th>
                        <th class="bg-primary text-white">Sab</th>
                        <th class="bg-primary text-white">Dom</th>
                        <th class="bg-primary text-white">Lun</th>
                        <th class="bg-primary text-white">Mar</th>
                        <th class="bg-primary text-white">14</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kpis as $kpi): ?>
                    <tr>
                        <td>
                            <?php 
                            $icon = 'bi-square';
                            $color = 'text-secondary';
                            if ($kpi['status'] === 'danger') { $icon = 'bi-exclamation-circle-fill'; $color = 'text-danger'; }
                            if ($kpi['status'] === 'primary') { $icon = 'bi-check-circle-fill'; $color = 'text-primary'; }
                            if ($kpi['status'] === 'warning') { $icon = 'bi-check-circle-fill'; $color = 'text-warning'; }
                            ?>
                            <i class="bi <?php echo $icon . ' ' . $color; ?>"></i>
                        </td>
                        <td class="fw-bold text-start ps-3"><?php echo htmlspecialchars($kpi['kpi_name']); ?></td>
                        <td class="text-start ps-3"><?php echo htmlspecialchars($kpi['indicator']); ?></td>
                        <td><?php echo htmlspecialchars($kpi['unit']); ?></td>
                        <td class="text-primary"><?php echo htmlspecialchars($kpi['trigger']); ?></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($kpi['mtd']); ?></td>
                        <?php foreach ($kpi['daily'] as $val): ?>
                            <?php 
                            // Simple logic to color code values
                            $valClean = (float)str_replace(',', '.', $val);
                            $class = 'text-dark';
                            if ($valClean > 0 && $valClean < 2) $class = 'text-danger fw-bold';
                            if ($valClean >= 80) $class = 'text-success fw-bold';
                            ?>
                            <td class="<?php echo $class; ?>"><?php echo htmlspecialchars($val); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Status Legend -->
    <div class="d-flex justify-content-center gap-4 mb-5">
        <div class="d-flex align-items-center bg-white px-4 py-2 rounded-pill shadow-sm border">
            <i class="bi bi-check-square-fill text-success me-2 fs-5"></i>
            <span class="fw-bold">Meta cumplida</span>
        </div>
        <div class="d-flex align-items-center bg-white px-4 py-2 rounded-pill shadow-sm border">
            <i class="bi bi-exclamation-square-fill text-danger me-2 fs-5"></i>
            <span class="fw-bold">Meta fallida</span>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>