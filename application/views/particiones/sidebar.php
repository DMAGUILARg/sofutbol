<div class="col-md-3 sidebar">
    <div class="flex justify-content-center">
        <?php $this->load->view('notificaciones'); ?>
    </div>

    <div class="user-info">
        <img src="https://via.placeholder.com/80" alt="Usuario">
        <h5><?php echo $this->session->userdata('nombre_usuario'); ?></h5>
        <p><?php echo ($this->session->userdata('rol') == 1) ? 'Administrador' : 'Entrenador'; ?></p>
    </div>


    <?php if ($this->session->userdata('rol') == 1): ?>
    <a href="<?php echo base_url('index.php/admin'); ?>" class="active"><i class="fas fa-home"></i> Inicio Admin</a>
    <a href="<?php echo base_url('index.php/equipos'); ?>">
        <i class="fas fa-clipboard-list"></i> Listado de equipos
    </a>
    <?php else: ?>
    <a href="<?php echo base_url('index.php/usuario'); ?>" class=""><i class="fas fa-home"></i> Inicio
        Entrenador</a>
    <a href="<?php echo base_url('index.php/torneos'); ?>" class=""><i class="fas fa-home"></i>Torneos Activos</a>
    <?php endif; ?>

    <a href="<?php echo base_url('index.php/clasificaciones'); ?>"><i class="fas fa-futbol"></i> Clasificación</a>
    <a href="<?php echo base_url('index.php/partidos'); ?>"><i class="fas fa-calendar-alt"></i> Calendario</a>

    <a href="<?php echo base_url('index.php/auth/logout'); ?>" class="logout-btn"><i class="fas fa-sign-out-alt"></i>
        Cerrar Sesión
    </a>
</div>