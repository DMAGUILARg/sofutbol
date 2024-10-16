<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Torneo_model');
		$this->load->model('Notificaciones_model');
		$this->load->model('Usuario_model');
		if (!$this->session->userdata('logged_in')) {
            redirect('http://localhost/sofutbol/'); 
        }

    }

    public function index() {
        $data['torneos'] = $this->Torneo_model->obtener_torneos();
		$this->load->model('Estados_model'); 
        $data['estados'] = $this->Estados_model->obtener_estados();
        $this->load->view('Panel_admin', $data);
		
    }

    public function guardar() {
		
		$data = [
			'nombre_torneo' => $this->input->post('nombre_torneo'),
			'fecha_inicio' => $this->input->post('fecha_inicio'),
			'fecha_fin' => $this->input->post('fecha_fin'),
			'descripcion' => $this->input->post('descripcion'),
			'id_estado' => $this->input->post('id_estado_torneo')
		];
	
		
		$this->Torneo_model->crear_torneo($data);
		$mensaje = "Se ha creado un nuevo torneo: " . $data['nombre_torneo'];
		$usuarios = $this->Usuario_model->obtener_todos_usuarios(); 
	

		foreach ($usuarios as $usuario) {
			$notificacion_data = [
				'id_usuario' => $usuario->id_usuario, 
				'mensaje' => $mensaje,
				'fecha_envio' => date('Y-m-d H:i:s') 
			];
			$this->Notificaciones_model->insertar_notificacion($notificacion_data); 
		}
	
		$this->session->set_flashdata('success', 'Torneo creado con éxito.');
		redirect('http://localhost/sofutbol/index.php/admin'); 
	}
	
	
	public function cambiar_estado() {
		$id_torneo = $this->input->post('id_torneo');
		$id_estado = $this->input->post('id_estado');
	
		$this->Torneo_model->actualizar_estado($id_torneo, $id_estado);

		$this->session->set_flashdata('success', 'Estado del torneo actualizado con éxito.');
		redirect('admin');
	}
	
}