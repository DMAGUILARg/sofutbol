<?php

class Torneos extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
		$this->load->model('Torneo_model');
		$this->load->model('Equipo_model'); 
		if (!$this->session->userdata('logged_in')) {
            redirect('http://localhost/sofutbol/'); 
        }	
    }

    public function index() {
		
	
		$torneos = $this->Torneo_model->obtener_torneos_activos();
		$id_usuario = $this->session->userdata('user_id'); 
		$equipo = $this->Equipo_model->get_equipo_by_user($id_usuario); 
	
		$data['torneos'] = $torneos;
		$data['equipo'] = $equipo; 
	
		$this->load->view('torneos_usuario', $data);
	}
	
	public function aplicar_torneo() {
		$id_torneo = $this->input->post('id_torneo');
		$id_equipo = $this->input->post('id_equipo');

	
		if ($this->Torneo_model->actualizar_torneo($id_equipo, $id_torneo)) {
			$this->session->set_flashdata('success', 'Has aplicado al torneo exitosamente.');
		} else {
			$this->session->set_flashdata('error', 'No se pudo aplicar al torneo. Intenta de nuevo.');
		}
	
		redirect('http://localhost/sofutbol/index.php/torneos'); 
	}
	
}