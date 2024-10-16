<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Torneo_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtener_torneos() {
        $query = $this->db->get('torneos'); 
        return $query->result_array();
    }

    public function crear_torneo($data) {
        return $this->db->insert('torneos', $data);
    }

	public function actualizar_estado($id_torneo, $id_estado) {
		$data = [
			'id_estado' => $id_estado
		];
		$this->db->where('id_torneo', $id_torneo);
		return $this->db->update('torneos', $data);
	}

	public function obtener_torneos_activos() {
		$this->db->where('id_estado', 1); 
		$query = $this->db->get('torneos');
		return $query->result();
	}

	public function actualizar_torneo($id_equipo, $id_torneo) {
        $data = [
            'id_torneo' => $id_torneo
        ];
        $this->db->where('id_equipo', $id_equipo);
        return $this->db->update('equipos', $data);
    }
	
}
