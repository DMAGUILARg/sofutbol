<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url('application/assets/css/registro.css'); ?>" rel="stylesheet">
    <title>Registro</title>
</head>

<body>
    <div class="home-icon">
        <a href="<?php echo base_url(); ?>" class="text-dark"><i class="bi bi-house-door"></i></a>
    </div>

    <div class="container">
        <div class="login-content">
            <h2>Registro de Usuario</h2>

            <?php if ($this->session->flashdata('message')): ?>
            <div class="alert alert-<?php echo $this->session->flashdata('message_type'); ?>" role="alert">
                <?php echo $this->session->flashdata('message'); ?>
            </div>
            <?php endif; ?>

            <form action="<?php echo base_url('index.php/registro/registrar'); ?>" method="POST" novalidate>
                <div class="mb-3">
                    <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                    <input type="text" class="form-control email" id="nombre_usuario" name="nombre_usuario"
                        value="<?php echo set_value('nombre_usuario'); ?>" required>
                    <div class="invalid-feedback">
                        <?php echo form_error('nombre_usuario'); ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control email" id="email" name="email"
                        value="<?php echo set_value('email'); ?>" required>
                    <div class="invalid-feedback">
                        <?php echo form_error('email'); ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" class="form-control password" id="contrasena" name="contrasena" required
                        minlength="6">
                    <div class="invalid-feedback">
                        <?php echo form_error('contrasena'); ?>
                    </div>
                </div>
                <button type="submit" class="btn"><i class="bi bi-door-open"></i> Registrarse</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>