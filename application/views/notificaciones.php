<div class="notification-bell">
    <i class="fas fa-bell"></i>
    <span class="badge" id="notification-badge">
        <?php echo (isset($notificaciones) && is_array($notificaciones)) ? count($notificaciones) : 0; ?>
    </span>

    <div class="dropdown-content" id="notification-dropdown">
        <ul class="notificacion-list">
            <?php if (!empty($notificaciones) && is_array($notificaciones)): ?>
            <?php foreach ($notificaciones as $notificacion): ?>
            <li>
                <p><?php echo htmlspecialchars($notificacion->mensaje, ENT_QUOTES, 'UTF-8'); ?></p>
                <span><?php echo date('d-m-Y H:i', strtotime($notificacion->fecha_envio)); ?></span>
            </li>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No tienes notificaciones.</p>
            <?php endif; ?>
        </ul>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url('application/assets/css/notificaciones.css'); ?>">
<script src="<?php echo base_url('application/assets/js/notificaciones.js'); ?>"></script>