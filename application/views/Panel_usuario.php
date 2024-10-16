<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Usuario - Gestión de Equipos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="<?php echo base_url('application/assets/css/sidebar.css'); ?>" rel="stylesheet">

    <style>
    body {
        font-family: "Roboto", sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }

    .main-content {
        margin-left: 270px;
        padding: 20px;
    }

    .header {
        max-width: 1200px;
        padding: 10px;
        border-bottom: 1px solid #a1d884;
    }

    .banner {
        padding: 20px;
        margin-bottom: 20px;
        text-align: center;
        font-size: 2rem;
        font-weight: bold;
        color: #007bff;
        background-color: #e9ecef;
        border-radius: 8px;
    }

    .card {
        margin-bottom: 20px;
        border: 1px solid #007bff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        background-color: #fff;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #007bff;
    }

    .btn-green {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
    }

    .btn-green:hover {
        background-color: #218838;
        color: #fff;
    }

    footer {
        text-align: center;
        margin-top: 30px;
        color: #888;
    }

    .logout-btn {
        color: #dc3545;
        font-weight: bold;
        display: block;
        text-align: center;
        padding: 15px;
        border-top: 1px solid #e4e4e4;
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('particiones/sidebar'); ?>

            <div class="col-md-9 main-content">
                <div class="content mt-4">
                    <?php if (!$equipo): ?>
                    <div class="banner">
                        No hay equipo
                    </div>
                    <?php else: ?>
                    <div class="banner">
                        Equipo: <?= $equipo->nombre_equipo ?>
                    </div>

                    <!-- Botón para agregar jugadores solo si hay un equipo -->
                    <button type="button" class="btn btn-green mb-4" data-toggle="modal"
                        data-target="#agregarJugadoresModal">
                        <i class="fas fa-user-plus"></i> Agregar Jugadores
                    </button>
                    <?php endif; ?>

                    <!-- Botón para crear equipo solo si no hay uno -->
                    <?php if (!$equipo): ?>
                    <button type="button" class="btn btn-green mb-4" data-toggle="modal"
                        data-target="#crearEquipoModal">
                        <i class="fas fa-plus"></i> Crear Equipo
                    </button>
                    <?php endif; ?>


                    <div class="row">
                        <?php if (isset($jugadores) && !empty($jugadores)): ?>
                        <?php foreach ($jugadores as $jugador): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <i class="fas fa-user-circle fa-3x"></i>
                                    </div>
                                    <h5 class="card-title"><?= $jugador->nombre_jugador ?></h5>
                                    <p class="card-text">Número de Camisa: <?= $jugador->numero_jugador ?></p>
                                    <p class="card-text">Posición: <?= $jugador->tipo_jugador ?></p>
                                    <p class="card-text">Edad: <?= $jugador->edad ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p>No hay jugadores disponibles.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para crear equipo -->
        <div class="modal fade" id="crearEquipoModal" tabindex="-1" role="dialog"
            aria-labelledby="crearEquipoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearEquipoModalLabel">Crear Equipo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('index.php/user/crear_equipo') ?>" method="post">
                            <div class="form-group">
                                <label for="nombre_equipo">Nombre del Equipo</label>
                                <input type="text" class="form-control" id="nombre_equipo" name="nombre_equipo"
                                    required>
                            </div>
                            <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
                            <button type="submit" class="btn btn-green">Crear Equipo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para agregar jugadores -->
        <div class="modal fade" id="agregarJugadoresModal" tabindex="-1" role="dialog"
            aria-labelledby="agregarJugadoresModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="agregarJugadoresModalLabel">Agregar Jugadores</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('index.php/user/agregar_jugadores/' . $equipo->id_equipo) ?>"
                            method="post">
                            <div class="form-group">
                                <label for="cantidad_jugadores">¿Cuántos jugadores deseas agregar?</label>
                                <input type="number" class="form-control" id="cantidad_jugadores"
                                    name="cantidad_jugadores" min="1" required>
                            </div>
                            <div id="jugadores_container"></div>
                            <button type="submit" class="btn btn-green">Agregar Jugadores</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
        $(document).ready(function() {
            $('#cantidad_jugadores').on('input', function() {
                var cantidad = $(this).val();
                var container = $('#jugadores_container');
                container.empty();
                for (var i = 0; i < cantidad; i++) {
                    container.append(`
                            <div class="form-group">
                                <label for="nombre_jugador_${i}">Nombre del Jugador ${i + 1}</label>
                                <input type="text" class="form-control" id="nombre_jugador_${i}" name="nombre_jugador[]" required>
                            </div>
                            <div class="form-group">
                                <label for="edad_jugador_${i}">Edad del Jugador ${i + 1}</label>
                                <input type="number" class="form-control" id="edad_jugador_${i}" name="edad_jugador[]" min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="numero_jugador_${i}">Número de Camisa ${i + 1}</label>
                                <input type="number" class="form-control" id="numero_jugador_${i}" name="numero_jugador[]" required>
                            </div>
                            <div class="form-group">
                                <label for="tipo_jugador_${i}">Tipo de Jugador ${i + 1}</label>
                                <select class="form-control" id="tipo_jugador_${i}" name="tipo_jugador[]" required>
                                    <option value="delantero">Delantero</option>
                                    <option value="portero">Portero</option>
                                    <option value="centrocampista">Centrocampista</option>
                                    <option value="defensa">Defensa</option>
                                </select>
                            </div>
                        `);
                }
            });
        });
        </script>
</body>

</html>