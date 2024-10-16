<?php
class Registro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');  
        $this->load->library('form_validation'); 
    }

   
    public function index() {
        $this->load->view('Registro');  
    }

    public function registrar() {
        $this->form_validation->set_rules('nombre_usuario', 'Nombre de usuario', 'required');
        $this->form_validation->set_rules('email', 'Correo electrónico', 'required|valid_email|is_unique[usuarios.email]');
        $this->form_validation->set_rules('contrasena', 'Contraseña', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('registro');
        } else {
            $datos_usuario = array(
                'nombre_usuario' => $this->input->post('nombre_usuario'),
                'email' => $this->input->post('email'),
                'contrasena' => password_hash($this->input->post('contrasena'), PASSWORD_BCRYPT),  
                'id_tipo_usuario' => 2  
            );
            if ($this->Usuario_model->registrar_usuario($datos_usuario)) {
                $this->session->set_flashdata('message', 'Usuario registrado con éxito');
                $this->session->set_flashdata('message_type', 'success');
                redirect('http://localhost/sofutbol/'); 
            } else {
                $this->session->set_flashdata('message', 'Error al registrar el usuario');
                $this->session->set_flashdata('message_type', 'danger');
                redirect('http://localhost/sofutbol/index.php/registro');
            }
        }
    }
}