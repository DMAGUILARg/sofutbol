<?php

class Estados_model extends CI_Model {
	public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function obtener_estados() {
        $query = $this->db->get('estado');
        return $query->result_array();
    }
}