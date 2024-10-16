<?php
class Notificaciones_model extends CI_Model {

    public function obtener_notificaciones_por_usuario($id_usuario) {
		log_message('debug', 'ID de usuario recibido: ' . $id_usuario);
		$this->db->where('id_usuario', $id_usuario);
		$query = $this->db->get('notificaciones');
		
		log_message('debug', 'Consulta ejecutada: ' . $this->db->last_query());
		log_message('debug', 'Resultados obtenidos: ' . json_encode($query->result()));
		
		return $query->result();
	}



	public function insertar_notificacion($data) {
		$this->db->insert('notificaciones', $data);
	}
	
}