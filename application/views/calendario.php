	<!DOCTYPE html>
	<html lang="es">

	<head>
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title>Gestión de Partidos</title>
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css"
	        rel="stylesheet">
	    <link href="<?php echo base_url('application/assets/css/sidebar.css'); ?>" rel="stylesheet">
	    <link href="<?php echo base_url('application/assets/css/calendario.css'); ?>" rel="stylesheet">
	    <style>

	    </style>
	</head>

	<body>
	    <div class="container-fluid">
	        <!-- Sidebar -->
	        <div class="row">
	            <?php $this->load->view('particiones/sidebar'); ?>
	        </div>
	        <div class="col-md-9 main-content mt-4">

	            <?php if ($this->session->userdata('rol') != 2): ?>
	            <div class="header-controls">
	                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
	                    <i class="bi bi-plus-circle"></i> Subir partido
	                </button>
	                <div class="d-flex">
	                    <button class="btn btn-outline-secondary">Todas las jornadas</button>
	                    <div class="dropdown">
	                        <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
	                            aria-expanded="false">
	                            Opciones
	                        </button>
	                        <ul class="dropdown-menu">
	                            <li><a class="dropdown-item" href="#">Eliminar jornada</a></li>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	            <?php endif; ?>


	            <!-- Toast Container -->
	            <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1050;">
	                <div class="toast" id="successToast" role="alert" aria-live="assertive" aria-atomic="true"
	                    data-bs-autohide="true" data-bs-delay="3000">
	                    <!-- Duración de 3 segundos -->
	                    <div class="toast-header" style="background-color: #28a745; color: white;">
	                        <strong>Éxito</strong>
	                    </div>
	                    <div class="toast-body">
	                        <?php echo $this->session->flashdata('success'); ?>
	                    </div>
	                </div>

	                <div class="toast" id="errorToast" role="alert" aria-live="assertive" aria-atomic="true"
	                    data-bs-autohide="true" data-bs-delay="3000">
	                    <!-- Duración de 3 segundos -->
	                    <div class="toast-header" style="background-color: #dc3545; color: white;">
	                        <strong>Error</strong>
	                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
	                    </div>
	                    <div class="toast-body">
	                        <?php echo $this->session->flashdata('error'); ?>
	                    </div>
	                </div>
	            </div>
	            <!-- Modal para subir partidos -->
	            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel"
	                aria-hidden="true">
	                <div class="modal-dialog">
	                    <div class="modal-content">
	                        <div class="modal-header">
	                            <h5 class="modal-title" id="uploadModalLabel">Subir Partidos</h5>
	                            <button type="button" class="btn-close" data-bs-dismiss="modal"
	                                aria-label="Close"></button>
	                        </div>
	                        <div class="modal-body">
	                            <?php if (isset($torneos) && !empty($torneos)): ?>
	                            <form action="<?php echo base_url('index.php/partidos/upload'); ?>" method="post"
	                                enctype="multipart/form-data">
	                                <div class="mb-3">
	                                    <label for="torneoSelect" class="form-label">Seleccionar Torneo</label>
	                                    <select name="id_torneo" class="form-select" id="torneoSelect" required>
	                                        <option value="" selected disabled>Seleccione un torneo</option>
	                                        <?php foreach ($torneos as $torneo): ?>
	                                        <option value="<?php echo $torneo->id_torneo; ?>">
	                                            <?php echo $torneo->nombre_torneo; ?>
	                                        </option>
	                                        <?php endforeach; ?>
	                                    </select>
	                                </div>
	                                <div class="mb-3">
	                                    <label for="file" class="form-label">Seleccionar archivo</label>
	                                    <input type="file" name="file" class="form-control" accept=".xls,.xlsx" id="file"
	                                        required>
	                                </div>
	                                <button type="submit" class="btn btn-success">
	                                    <i class="bi bi-upload"></i> Subir partidos
	                                </button>
	                            </form>
	                            <?php else: ?>
	                            <div class="alert alert-danger" role="alert">
	                                No se encontraron torneos disponibles.
	                            </div>
	                            <?php endif; ?>
	                        </div>
	                    </div>
	                </div>
	            </div>


	            <div class="jornada-navigation d-flex justify-content-between align-items-center my-3">
	                <a href="<?php echo site_url('partidos/cambiar_jornada/' . (isset($jornada->id_jornada) ? $jornada->id_jornada - 1 : 1)); ?>"
	                    class="btn btn-outline-primary btn-sm">&lt; Jornada Anterior</a>
	                <span>
	                    <?php if (isset($jornada)): ?>
	                    <?php echo $jornada->nombre_jornada; ?>
	                    (<?php echo date('d/m/Y', strtotime($jornada->fecha_inicio)); ?> -
	                    <?php echo date('d/m/Y', strtotime($jornada->fecha_fin)); ?>)
	                    <?php else: ?>
	                    Jornada no disponible
	                    <?php endif; ?>
	                </span>
	                <a href="<?php echo site_url('partidos/cambiar_jornada/' . (isset($jornada->id_jornada) ? $jornada->id_jornada + 1 : 1)); ?>"
	                    class="btn btn-outline-primary btn-sm">Jornada Siguiente &gt;</a>
	            </div>

	            <?php if (isset($error)): ?>
	            <div class="alert alert-danger" role="alert">
	                <?php echo $error; ?>
	            </div>
	            <?php else: ?>
	            <div class="jornada-header">
	                <?php if (isset($jornada) && isset($jornada->torneo)): ?>
	                <?php echo $jornada->nombre_jornada; ?> (Torneo: <?php echo $jornada->torneo->nombre_torneo; ?>)
	                (<?php echo date('d/m/Y', strtotime($jornada->fecha_inicio)); ?> -
	                <?php echo date('d/m/Y', strtotime($jornada->fecha_fin)); ?>)
	                <?php else: ?>
	                Jornada no disponible
	                <?php endif; ?>
	            </div>

	            <!-- Lista de partidos -->
	            <?php if (!empty($partidos)): ?>
	            <?php foreach ($partidos as $partido): ?>
	            <div class="match-row d-flex align-items-center">
	                <div class="col-3 match-info">
	                    <strong><?php echo date('d/m/Y H:i', strtotime($partido->fecha_partido)); ?></strong><br>
	                    <?php echo isset($partido->lugar_partido) ? $partido->lugar_partido : 'No especificado'; ?>
	                </div>
	                <div class="col-3 d-flex align-items-center justify-content-between">
	                    <span class="team-name"><?php echo $partido->local; ?></span>
	                </div>
	                <div class="col-2 text-center result position-relative">
	                    <div class="result-value d-flex justify-content-center align-items-center" style="height: 100%;">
	                        <?php 
								if (isset($partido->goles_local) && isset($partido->goles_visitante)) {
									echo $partido->goles_local . ' - ' . $partido->goles_visitante;
								} else {
									echo '0 - 0';
								}
								?>
	                    </div>
	                </div>
	                <div class="col-3 d-flex align-items-center justify-content-between">
	                    <span class="team-name"><?php echo $partido->visitante; ?></span>
	                    <span
	                        class=" badge <?php echo isset($partido->goles_local) && isset($partido->goles_visitante) ? ($partido->goles_local == 0 && $partido->goles_visitante == 0 ? 'bg-danger' : ($partido->estado == 'finalizado' ? 'bg-warning' : 'bg-success')) : 'bg-danger'; ?> ">
	                        <?php 
								if (isset($partido->goles_local) && isset($partido->goles_visitante)) {
									if ($partido->goles_local == 0 && $partido->goles_visitante == 0) {
										echo 'Partido no jugado';
									} else {
										echo ucfirst($partido->estado);
									}
								} else {
									echo 'Partido no jugado';
								}
								?>
	                    </span>
	                </div>
	                <div class="col-1 text-center actions">
	                    <?php if ($this->session->userdata('rol') != 2): ?>
	                    <?php if ($partido->estado != 'finalizado'): ?>
	                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
	                        data-partido-id="<?php echo $partido->id_partido; ?>"
	                        data-local="<?php echo $partido->local; ?>" data-visitante="<?php echo $partido->visitante; ?>"
	                        data-goles-local="<?php echo $partido->goles_local; ?>"
	                        data-goles-visitante="<?php echo $partido->goles_visitante; ?>"
	                        data-estado="<?php echo $partido->estado; ?>">
	                        <i class="bi bi-pencil"></i>
	                    </button>
	                    <?php else: ?>
	                    <button class="btn btn-success btn-sm" disabled>
	                        <i class="bi bi-pencil"></i>
	                    </button>
	                    <?php endif; ?>
	                    <?php endif; ?>
	                </div>
	            </div>

	            <?php endforeach; ?>
	            <?php else: ?>
	            <p>No hay partidos para esta jornada.</p>
	            <?php endif; ?>
	            <?php endif; ?>
	        </div>
	    </div>

	    <!-- Modal para editar resultados -->
	    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <form id="editarResultadoForm">
	                    <div class="modal-header">
	                        <h5 class="modal-title" id="editModalLabel">Editar Resultado del Partido</h5>
	                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	                    </div>
	                    <div class="modal-body">
	                        <input type="hidden" name="id_partido" id="partidoId">

	                        <div class="mb-3">
	                            <label for="equipoLocal" class="form-label">Equipo Local</label>
	                            <input type="text" class="form-control" id="equipoLocal" disabled>
	                        </div>

	                        <div class="mb-3">
	                            <label for="golesLocal" class="form-label">Goles Local</label>
	                            <input type="number" class="form-control" name="goles_local" id="golesLocal">
	                        </div>

	                        <div class="mb-3">
	                            <label for="equipoVisitante" class="form-label">Equipo Visitante</label>
	                            <input type="text" class="form-control" id="equipoVisitante" disabled>
	                        </div>

	                        <div class="mb-3">
	                            <label for="golesVisitante" class="form-label">Goles Visitante</label>
	                            <input type="number" class="form-control" name="goles_visitante" id="golesVisitante">
	                        </div>

	                        <div class="mb-3">
	                            <label for="estado" class="form-label">Estado del Partido</label>
	                            <select name="estado" class="form-select" id="estado">
	                                <option value="no jugado">No Jugado</option>
	                                <option value="en curso">En Curso</option>
	                                <option value="finalizado">Finalizado</option>
	                                <option value="empate">Empate</option>
	                            </select>
	                        </div>
	                    </div>
	                    <div class="modal-footer">
	                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
	                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </div>

	    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	    <script ript src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
	    <script ript src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
	    <script src="<?php echo base_url('application/assets/js/prevent.js'); ?>"></script>
	    <script>
	    document.addEventListener('DOMContentLoaded', function() {
	        var successMessage = "<?php echo $this->session->flashdata('success'); ?>";
	        var errorMessage = "<?php echo $this->session->flashdata('error'); ?>";

	        if (successMessage) {
	            var toastSuccess = new bootstrap.Toast(document.getElementById('successToast'));
	            toastSuccess.show();
	        }

	        if (errorMessage) {
	            var toastError = new bootstrap.Toast(document.getElementById('errorToast'));
	            toastError.show();
	        }
	    });
	    </script>

	</body>








	</html>