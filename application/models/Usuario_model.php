<?php
class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();  
    }
    public function registrar_usuario($datos_usuario) {
        return $this->db->insert('usuarios', $datos_usuario); 
    }
    public function email_existe($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('usuarios');
        return $query->num_rows() > 0;  
    }

	public function obtener_entrenador_por_equipo($id_equipo) {
        $this->db->select('usuarios.nombre_usuario, usuarios.email, equipos.nombre_equipo');
        $this->db->from('usuarios');
        $this->db->join('equipos', 'equipos.id_usuario = usuarios.id_usuario');
        $this->db->where('equipos.id_equipo', $id_equipo);
        $query = $this->db->get();
        return $query->row();  
    }

	public function obtener_todos_usuarios() {
		$query = $this->db->get('usuarios'); 
		return $query->result();
	}
	
}