<?php
class Equipo_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insertar_equipo($data) {
        $this->db->insert('equipos', $data); 
        return $this->db->insert_id(); 
    }

	public function insertar_jugadores($jugadores) {
		$this->db->insert_batch('jugadores', $jugadores);
	}
	
	public function get_all_equipos() {
		$this->db->select('equipos.id_equipo, equipos.nombre_equipo, usuarios.nombre_usuario AS nombre_entrenador');
		$this->db->from('equipos');
		$this->db->join('usuarios', 'equipos.id_usuario = usuarios.id_usuario'); 
		$query = $this->db->get();
	
		return $query->result();
	}
	
    public function usuario_existe($id_usuario) {
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('usuarios');
        return $query->num_rows() > 0;
    }

    public function get_equipos() {
        $query = $this->db->get('equipos');
        return $query->result();  
    }

    
    public function get_equipo_by_user($id_usuario) {
        $this->db->where('id_usuario', $id_usuario);
        $query = $this->db->get('equipos');
        return $query->row();  
    }

	public function get_jugadores_by_equipo($id_equipo) {
		$this->db->select('jugadores.*, tipo_usuario.nombre_tipo_usuario'); 
		$this->db->from('jugadores');
		$this->db->join('tipo_usuario', 'jugadores.id_tipo_usuario = tipo_usuario.id_tipo_usuario', 'left');
		$this->db->where('jugadores.id_equipo', $id_equipo);
		$query = $this->db->get();
		
		return $query->result();
	}
	

	
}
