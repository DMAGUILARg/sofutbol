<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clasificaciones - Gestión de Equipos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="<?php echo base_url('application/assets/css/sidebar.css'); ?>" rel="stylesheet">
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #F4F4F4;
        color: #333;
    }

    .main-content {
        margin-left: 270px;
        padding: 20px;
    }

    .header {
        background-color: #FFD701;
        color: #000;
        padding: 10px;
        border-bottom: 1px solid #A1D884;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .table {
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table thead th {
        background-color: #2B8A3E;
        color: #FFFFFF;
        text-align: center;
    }

    .table td,
    .table th {
        vertical-align: middle;
        text-align: center;
    }

    .table tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .table tbody tr:hover {
        background-color: #e8f5e9;
    }

    .table td:first-child {
        font-weight: bold;
    }

    .team-flag {
        width: 30px;
        height: 20px;
        margin-right: 5px;
    }

    .team-name {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .team-name span {
        margin-left: 5px;
    }

    footer {
        text-align: center;
        margin-top: 30px;
        color: #888;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('particiones/sidebar'); ?>
            <div class="col-md-9 main-content">
                <div class="header">
                    <h2>Clasificaciones</h2>
                </div>

                <div class="mt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Posición</th>
                                    <th>Equipo</th>
                                    <th>PJ</th>
                                    <th>GF</th>
                                    <th>GC</th>
                                    <th>Puntos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clasificaciones as $index => $clasificacion): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td class="team-name">

                                        <span><?php echo $clasificacion['nombre_equipo']; ?></span>
                                    </td>
                                    <td><?php echo $clasificacion['partidos_jugados']; ?></td>
                                    <td><?php echo $clasificacion['goles_favor']; ?></td>
                                    <td><?php echo $clasificacion['goles_contra']; ?></td>
                                    <td><?php echo $clasificacion['puntos']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
