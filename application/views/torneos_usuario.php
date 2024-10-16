<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torneos Activos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="<?php echo base_url('application/assets/css/admin.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('application/assets/css/sidebar.css'); ?>" rel="stylesheet">
</head>

<body>
    <div class="constainer fluid">
        <div class="row">
            <?php $this->load->view('particiones/sidebar'); ?>

            <div class="col-md-9 main-content">
                <h2>Torneos Activos</h2>

                <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <?php endif; ?>

                <div class="row">
                    <?php foreach ($torneos as $torneo): ?>
                    <div class="col-md-4 ">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $torneo->nombre_torneo; ?></h5>
                                <p class="card-text">Descripción: <?php echo $torneo->descripcion; ?></p>
                                <p class="card-text">Fecha Inicio: <?php echo $torneo->fecha_inicio; ?></p>
                                <p class="card-text">Fecha Fin: <?php echo $torneo->fecha_fin; ?></p>

                                <?php if (isset($equipo)): ?>
                                <form action="<?php echo base_url('index.php/torneos/aplicar_torneo'); ?>"
                                    method="post">
                                    <input type="hidden" name="id_torneo" value="<?php echo $torneo->id_torneo; ?>">
                                    <input type="hidden" name="id_equipo" value="<?php echo $equipo->id_equipo; ?>">
                                    <!-- Aquí podría dar error si $equipo es null -->
                                    <button type="submit" class="btn btn-success">Aplicar al Torneo</button>
                                </form>
                                <?php else: ?>
                                <p>No tienes un equipo registrado para aplicar al torneo.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Mostrar toast si hay un mensaje
    var toastElList = [].slice.call(document.querySelectorAll('.toast'))
    toastElList.forEach(function(toastEl) {
        var toast = new bootstrap.Toast(toastEl)
        toast.show()
    });
    </script>
</body>



</html>