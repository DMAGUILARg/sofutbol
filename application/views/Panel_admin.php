<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Administrador - Gestión de Torneos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="<?php echo base_url('application/assets/css/admin.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('application/assets/css/sidebar.css'); ?>" rel="stylesheet">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Barra lateral -->
            <?php $this->load->view('particiones/sidebar'); ?>

            <!-- Contenido principal -->
            <div class="col-md-9 main-content">
                <div class="content mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Torneos Activos</h2>
                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#crearTorneoModal">
                            Crear Torneo
                        </button>
                    </div>

                    <!-- Tarjetas de torneos -->
                    <div class="row">
                        <?php foreach ($torneos as $torneo): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img src="https://via.placeholder.com/350x150"
                                    alt="<?php echo $torneo['nombre_torneo']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $torneo['nombre_torneo']; ?></h5>
                                    <p class="card-text">Fecha: <?php echo $torneo['fecha_inicio']; ?> -
                                        <?php echo $torneo['fecha_fin']; ?></p>
                                    <span
                                        class="badge badge-<?php echo $torneo['id_estado'] == 1 ? 'success' : ($torneo['id_estado'] == 2 ? 'warning' : 'secondary'); ?>">
                                        <?php echo $torneo['id_estado'] == 1 ? 'Activo' : ($torneo['id_estado'] == 2 ? 'Pendiente' : 'Finalizado'); ?>
                                    </span>

                                    <!-- Select para cambiar el estado -->
                                    <form action="<?php echo base_url('index.php/admin/cambiar_estado'); ?>"
                                        method="post">
                                        <input type="hidden" name="id_torneo"
                                            value="<?php echo $torneo['id_torneo']; ?>">
                                        <select name="id_estado" class="form-control mt-2"
                                            onchange="this.form.submit()">
                                            <option value="">Cambiar Estado</option>
                                            <?php foreach ($estados as $estado): ?>
                                            <option value="<?php echo $estado['id_estado']; ?>"
                                                <?php echo ($estado['id_estado'] == $torneo['id_estado']) ? 'selected' : ''; ?>>
                                                <?php echo $estado['nombre_estado']; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>


                    <!-- Toast para mensaje de éxito -->
                    <div class="toast" id="successToast"
                        style="position: fixed; top: 20px; right: 50%; transform: translateX(50%);" role="alert"
                        aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-success text-white">
                            <strong class="mr-auto">Éxito</strong>
                            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="toast-body">
                            <?php if ($this->session->flashdata('success')): ?>
                            <?php echo $this->session->flashdata('success'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para crear torneo -->
    <div class="modal fade" id="crearTorneoModal" tabindex="-1" aria-labelledby="crearTorneoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearTorneoModalLabel">Crear Nuevo Torneo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url('index.php/admin/guardar'); ?>" method="post">
                        <div class="form-group">
                            <label for="nombre_torneo">Nombre del Torneo</label>
                            <input type="text" class="form-control" id="nombre_torneo" name="nombre_torneo" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="id_estado_torneo">Estado del Torneo</label>
                            <select class="form-control" id="id_estado_torneo" name="id_estado_torneo" required>
                                <option value="">Seleccione un estado</option>
                                <?php foreach ($estados as $estado): ?>
                                <option value="<?php echo $estado['id_estado']; ?>">
                                    <?php echo $estado['nombre_estado']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Torneo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {

        if ($('#successToast .toast-body').text().trim()) {
            $('#successToast').toast({
                delay: 3000
            });
            $('#successToast').toast('show');
        }
    });
    </script>
</body>

</html>