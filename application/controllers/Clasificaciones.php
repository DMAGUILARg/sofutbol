<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clasificaciones extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Clasificacion_model'); 
		if (!$this->session->userdata('logged_in')) {
            redirect('http://localhost/sofutbol/'); 
        }	
    }

    public function index() {
		$this->load->model('Clasificacion_model');
		$clasificaciones = $this->Clasificacion_model->getClasificaciones();
		
		usort($clasificaciones, function($a, $b) {
			if ($a['puntos'] == $b['puntos']) {
				return 0;
			}
			return ($a['puntos'] < $b['puntos']) ? 1 : -1;
		});
	
		$data['clasificaciones'] = $clasificaciones;
		$this->load->view('clasificaciones', $data);
	}
	
}