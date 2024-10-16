<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Listado de Equipos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="<?php echo base_url('application/assets/css/sidebar.css'); ?>" rel="stylesheet">
    <style>
    body {
        font-family: "Roboto", sans-serif;
        background-image: url('https://images.unsplash.com/photo-1541580967-0d1c6d1e9075');
        background-size: cover;
        color: #333;
    }

    .main-content {
        margin-left: 270px;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
    }

    h1 {
        color: #28a745;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        margin-bottom: 20px;
    }

    .table {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .table th {
        background-color: #28a745;
        color: white;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-details {
        background-color: #28a745;
        border: none;
    }

    .btn-details:hover {
        background-color: #218838;
    }

    .btn-download {
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('particiones/sidebar'); ?>
            <div class="col-md-9 main-content">
                <h1>Listado de Equipos</h1>
                <a href="<?= base_url('index.php/equipos/exportar_equipos_excel') ?>"
                    class="btn btn-success btn-download">
                    <i class="fas fa-file-excel"></i> Descargar Excel
                </a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Equipo</th>
                            <th>Entrenador</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($equipos as $equipo): ?>
                        <tr>
                            <td><?= $equipo->id_equipo ?></td>
                            <td><?= $equipo->nombre_equipo ?></td>
                            <td><?= $equipo->nombre_entrenador ?></td>

                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>