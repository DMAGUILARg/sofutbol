<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->library('session');
        $this->load->library('form_validation'); 
    }

    public function login() {
        $this->load->view('login');
    }

	public function do_login() {
		$this->form_validation->set_rules('email', 'Correo electrónico', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[6]');
	
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('login');
		} else {
			$email = $this->input->post('email');
			$password = $this->input->post('password');
	
			$user = $this->Login_model->get_user_by_email($email);
	
			if ($user && password_verify($password, $user['contrasena'])) {
				$this->session->set_userdata('logged_in', TRUE);
				$this->session->set_userdata('user_id', $user['id_usuario']);
				$this->session->set_userdata('user_email', $user['email']);
				$this->session->set_userdata('nombre_usuario', $user['nombre_usuario']);
				$this->session->set_userdata('rol', $user['id_tipo_usuario']); 
	
			
				if ($user['id_tipo_usuario'] == 1) { 
					redirect('admin');
				} elseif ($user['id_tipo_usuario'] == 2) { 
					redirect('usuario');
				} else {
					redirect('perfil');
				}
			} else {
				$this->session->set_flashdata('message', 'Correo electrónico o contraseña incorrectos.');
				$this->session->set_flashdata('message_type', 'danger');
				
				redirect('http://localhost/sofutbol/');
			}
		}
	}
	

	public function logout() {
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_email');
		$this->session->unset_userdata('nombre_usuario');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Pragma: no-cache');
		
		
		redirect('http://localhost/sofutbol/');
	}
	
}