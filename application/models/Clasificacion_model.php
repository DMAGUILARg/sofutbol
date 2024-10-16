<?php
class Clasificacion_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getClasificaciones() {
        $this->db->select('e.nombre_equipo, c.partidos_jugados, c.partidos_ganados, c.partidos_perdidos, c.goles_favor, c.goles_contra, c.puntos');
        $this->db->from('clasificaciones c');
        $this->db->join('equipos e', 'c.id_equipo = e.id_equipo');
        $this->db->order_by('c.puntos', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}