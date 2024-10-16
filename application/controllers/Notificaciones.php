<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificaciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Notificaciones_model');
        $this->load->library('session');
    }

    public function obtener_notificaciones() {
        $id_usuario = $this->session->userdata('user_id'); 
        $notificaciones = $this->Notificaciones_model->obtener_notificaciones_por_usuario($id_usuario);
        
        echo json_encode(['notificaciones' => $notificaciones]);
    }
}
