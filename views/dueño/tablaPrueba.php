                <?p/* if ($resultado_solicitudes && mysqli_num_rows($resultado_solicitudes) > 0):
                    <!-- Tabla de solicitudes -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th><i class="fas fa-hashtag"></i> ID</th>
                                    <th><i class="bi bi-person"></i> Cliente</th>
                                    <th><i class="fas fa-tag"></i> Promoción</th>
                                    <th><i class="bi bi-star-fill"></i> Categoría</th>
                                    <th><i class="bi bi-calendar3"></i> Fecha Solicitud</th>
                                    <th><i class="fas fa-traffic-light"></i> Estado</th>
                                    <th><i class="bi bi-gears"></i> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($solicitud = mysqli_fetch_assoc($resultado_solicitudes)): ?>
                                    <tr>
                                        <td>#<?= $solicitud['id_solicitud'] ?></td>
                                        <td>
                                            <span class="fw-bold"><?= htmlspecialchars($solicitud['textoPromo']) ?></span>
                                            <br>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3-alt"></i> 
                                                Válida: <?= date('d/m/Y', strtotime($solicitud['fechaDesdePromo'])) ?> - 
                                                <?= date('d/m/Y', strtotime($solicitud['fechaHastaPromo'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php
                                            $categoria = $solicitud['categoriaCliente'];
                                            $badge_class = '';
                                            $icon = '';
                                            switch($categoria) {
                                                case 'Premium':
                                                    $badge_class = 'bg-warning text-dark';
                                                    $icon = 'bi bi-gem';
                                                    break;
                                                case 'Medium':
                                                    $badge_class = 'bg-info';
                                                    $icon = 'bi bi-star-fill';
                                                    break;
                                                case 'Inicial':
                                                default:
                                                    $badge_class = 'bg-secondary';
                                                    $icon = 'bi bi-circle-fill';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?= $badge_class ?>">
                                                <i class="<?= $icon ?>"></i> <?= $categoria ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y H:i', strtotime($solicitud['fecha_solicitud'])) ?>
                                        </td>
                                        <td>
                                            <?php
                                            $estado = $solicitud['estado'];
                                            $estado_class = '';
                                            $estado_icon = '';
                                            switch($estado) {
                                                case 'pendiente':
                                                    $estado_class = 'bg-warning text-dark';
                                                    $estado_icon = 'bi bi-clock';
                                                    break;
                                                case 'aceptada':
                                                    $estado_class = 'bg-success';
                                                    $estado_icon = 'bi bi-check';
                                                    break;
                                                case 'rechazada':
                                                    $estado_class = 'bg-danger';
                                                    $estado_icon = 'bi bi-x';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?= $estado_class ?>">
                                                <i class="<?= $estado_icon ?>"></i> <?= ucfirst($estado) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if($estado == 'pendiente'): ?>
                                                <div class="btn-group" role="group">
                                                    <form method="POST" action="../../controllers/dueñoCtrl/gestionarSolicitudesController.php" style="display: inline;">
                                                        <input type="hidden" name="id_solicitud" value="<?= $solicitud['id_solicitud'] ?>">
                                                        <input type="hidden" name="accion" value="aceptar">
                                                        <button type="submit" class="btn btn-success btn-sm" 
                                                                onclick="return confirm('¿Aceptar esta solicitud de descuento?')">
                                                            <i class="bi bi-check"></i> Aceptar
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="../../controllers/dueñoCtrl/gestionarSolicitudesController.php" style="display: inline;">
                                                        <input type="hidden" name="id_solicitud" value="<?= $solicitud['id_solicitud'] ?>">
                                                        <input type="hidden" name="accion" value="rechazar">
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('¿Rechazar esta solicitud de descuento?')">
                                                            <i class="bi bi-x"></i> Rechazar
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    <i class="bi bi-check-circle"></i> Procesada
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                <?php else: ?>
                    <!-- Sin solicitudes -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-inbox fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted">No hay solicitudes de descuentos</h4>
                        <p class="text-muted">
                            Aún no tienes solicitudes de descuentos para tu local.<br>
                            Las solicitudes aparecerán aquí cuando los clientes soliciten usar tus promociones.
                        </p>
                        <a href="../dueño/mis_promos.php" class="btn btn-primary">
                            <i class="bi bi-plus"></i> Ver mis promociones
                        </a>
                    </div>
                <?php endif; */?>