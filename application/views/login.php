<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url('application/assets/css/login.css'); ?>" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <div class="home-icon">
        <a href="<?php echo base_url(); ?>" class="text-dark"><i class="bi bi-house-door"></i></a>
    </div>
    <div class="container">

        <div class="login-content">
            <?php if ($this->session->flashdata('message')): ?>
            <?php
                $message_type = $this->session->flashdata('message_type');
                $background_color = ($message_type === 'success') ? '#0c9b20' : '#dc3545';
                ?>
            <div aria-live="polite" aria-atomic="true" class="position-relative">
                <div id="toastMessage"
                    class="toast align-items-center text-white border-0 position-fixed top-0 start-50 translate-middle-x mt-3 fade show"
                    role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000"
                    style="background-color: <?php echo $background_color; ?>;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?php if ($message_type === 'success'): ?>
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?php elseif ($message_type === 'danger'): ?>
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <?php endif; ?>
                            <?php echo $this->session->flashdata('message'); ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <form id="loginForm" action="<?php echo base_url('index.php/auth/do_login'); ?>" method="POST" novalidate>
                <h1 class="title">Bienvenido</h1>
                <div class="login">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control email" id="exampleInputEmail1" name="email"
                            aria-describedby="emailHelp" value="<?php echo set_value('email'); ?>" required>
                        <div class="invalid-feedback">
                            <?php echo form_error('email'); ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                        <input type="password" class="form-control password" name="password" id="exampleInputPassword1"
                            required minlength="6">
                        <div class="invalid-feedback">
                            <?php echo form_error('password'); ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn mt-6 mb-5"><i class="bi bi-door-open"></i> Ingresar</button>
                <div class="text-end">
                    <a class="link-gray" href="<?php echo base_url('index.php/registro'); ?>">Regístrese Aquí</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var toastEl = document.getElementById('toastMessage');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>