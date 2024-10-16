<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Equipo_model');
        $this->load->library('session');
		if (!$this->session->userdata('logged_in')) {
            redirect('http://localhost/sofutbol/'); 
        }	
	}
    

	public function usuario() {
		$id_usuario = $this->session->userdata('user_id'); 
		$data['equipo'] = $this->Equipo_model->get_equipo_by_user($id_usuario);
	
		if ($data['equipo']) {
			$data['jugadores'] = $this->Equipo_model->get_jugadores_by_equipo($data['equipo']->id_equipo);
		} else {
			$data['jugadores'] = []; 
		}
	
		$data['id_usuario'] = $id_usuario; 
		$this->load->view('Panel_usuario', $data);
	}
	

    public function crear_equipo() {
        $nombre_equipo = $this->input->post('nombre_equipo');
        $id_usuario = $this->session->userdata('user_id'); 

        if (!$this->Equipo_model->usuario_existe($id_usuario)) {
            $this->session->set_flashdata('error', 'El usuario no existe.');
            redirect('user/usuario');
            return;
        }

        $data = array(
            'nombre_equipo' => $nombre_equipo,
            'id_usuario' => $id_usuario
        );

        $id_equipo = $this->Equipo_model->insertar_equipo($data);
        $this->session->set_flashdata('success', 'El equipo se creó con éxito.');
        
        redirect('user/usuario');
    }

	public function agregar_jugadores($id_equipo) {
		if ($this->input->post()) {
			$cantidad_jugadores = $this->input->post('cantidad_jugadores');
			$jugadores = [];
	
			for ($i = 0; $i < $cantidad_jugadores; $i++) {
				$jugadores[] = [
					'nombre_jugador' => $this->input->post('nombre_jugador')[$i],
					'edad' => $this->input->post('edad_jugador')[$i],
					'numero_jugador' => $this->input->post('numero_jugador')[$i],
					'tipo_jugador' => $this->input->post('tipo_jugador')[$i],
					'id_tipo_usuario' => 3 ,
					'id_equipo' => $id_equipo
				];
			}
	
			
			$this->Equipo_model->insertar_jugadores($jugadores);
			$this->session->set_flashdata('success', 'Jugadores agregados con éxito.');
			redirect('user/usuario');
		} else {
			$data['equipo'] = $this->Equipo_model->get_equipo($id_equipo);
			$this->load->view('Agregar_jugadores', $data);
		}
	}
	
}
