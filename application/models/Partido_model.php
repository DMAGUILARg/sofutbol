<?php

class Partido_model extends CI_Model {

    public function get_partidos_by_jornada($id_jornada) {
        $this->db->select('partidos.*, 
                           equipo_local.nombre_equipo AS local, 
                           equipo_visitante.nombre_equipo AS visitante,
                           resultados.goles_equipo_local AS goles_local, 
                           resultados.goles_equipo_visitante AS goles_visitante,
                           partidos.lugar_partido'); 
        $this->db->from('partidos');
        $this->db->join('equipos AS equipo_local', 'partidos.id_equipo_local = equipo_local.id_equipo');
        $this->db->join('equipos AS equipo_visitante', 'partidos.id_equipo_visitante = equipo_visitante.id_equipo');
        $this->db->join('resultados', 'partidos.id_partido = resultados.id_partido', 'left');  
        $this->db->where('partidos.id_jornada', $id_jornada); 
        
        $query = $this->db->get();

        if (!$query) {
            log_message('error', 'Error en la consulta: ' . $this->db->last_query());
            return [];  
        }
        return $query->result();
    }

	public function insertar_partido($data) {
        return $this->db->insert('partidos', $data);
    }

   
    public function insertar_jornada($data) {
        $this->db->insert('jornadas', $data);
        return $this->db->insert_id(); 
    }

   
    public function obtener_equipos_por_torneo($id_torneo) {
        $this->db->where('id_torneo', $id_torneo);
        $query = $this->db->get('equipos');
        return $query->result(); 
    }

   
    public function obtener_torneo($id_torneo) {
        $this->db->where('id_torneo', $id_torneo);
        $query = $this->db->get('torneos');
        return $query->row(); 
    }


    public function obtener_fechas_torneo($id_torneo) {
        $this->db->select('fecha_inicio, fecha_fin');
        $this->db->where('id_torneo', $id_torneo);
        $query = $this->db->get('torneos');
        return $query->row();
    }

	public function obtener_torneos_activos() {
		$this->db->where('id_estado', 1); 
		$query = $this->db->get('torneos');
		return $query->result(); 
	}

	public function actualizar_partido($id_partido, $data_partido) {
        $this->db->where('id_partido', $id_partido);
        $this->db->update('partidos', $data_partido);
    }

    
    public function actualizar_resultado($id_partido, $data_resultado) {
		$query = $this->db->get_where('resultados', ['id_partido' => $id_partido]);
	
		if ($query->num_rows() > 0) {
		
			$this->db->where('id_partido', $id_partido);
			$this->db->update('resultados', $data_resultado);
		} else {
		
			$data_resultado['id_partido'] = $id_partido; 
			$this->db->insert('resultados', $data_resultado);
		}
	}
	

  
	public function actualizar_clasificaciones($id_partido, $goles_local, $goles_visitante) {
		$this->db->select('id_equipo_local, id_equipo_visitante');
		$this->db->from('partidos');
		$this->db->where('id_partido', $id_partido);
		$partido = $this->db->get()->row();
	
		if (!$partido) {
			log_message('error', 'No se encontró el partido con id_partido: ' . $id_partido);
			return false; 
		}
	
		$equipo_local = $partido->id_equipo_local;
		$equipo_visitante = $partido->id_equipo_visitante;
	
		if ($goles_local > $goles_visitante) {
			$resultado_local = 'ganado';
			$resultado_visitante = 'perdido';
		} elseif ($goles_local < $goles_visitante) {
			$resultado_local = 'perdido';
			$resultado_visitante = 'ganado';
		} else {
			$resultado_local = 'empatado';
			$resultado_visitante = 'empatado';
		}
	
		$this->actualizar_estadisticas_equipo($equipo_local, $goles_local, $goles_visitante, $resultado_local);
		$this->actualizar_estadisticas_equipo($equipo_visitante, $goles_visitante, $goles_local, $resultado_visitante);
	}
	
	public function actualizar_estadisticas_equipo($id_equipo, $goles_favor, $goles_contra, $resultado) {
		$equipo = $this->db->get_where('clasificaciones', ['id_equipo' => $id_equipo])->row();
	
		if (!$equipo) {
			$data = [
				'id_equipo' => $id_equipo,
				'goles_favor' => $goles_favor,
				'goles_contra' => $goles_contra,
				'partidos_jugados' => 1,
				'partidos_ganados' => ($resultado === 'ganado') ? 1 : 0,
				'partidos_empatados' => ($resultado === 'empatado') ? 1 : 0,
				'partidos_perdidos' => ($resultado === 'perdido') ? 1 : 0,
				'puntos' => ($resultado === 'ganado') ? 3 : ($resultado === 'empatado' ? 1 : 0),
			];
			
			$this->db->insert('clasificaciones', $data);
		} else {
			$goles_favor_total = $equipo->goles_favor + $goles_favor;
			$goles_contra_total = $equipo->goles_contra + $goles_contra;
	
			$data = [
				'goles_favor' => $goles_favor_total,
				'goles_contra' => $goles_contra_total,
				'partidos_jugados' => $equipo->partidos_jugados + 1,
			];
	
			if ($resultado === 'ganado') {
				$data['partidos_ganados'] = $equipo->partidos_ganados + 1;
				$data['puntos'] = $equipo->puntos + 3;
			} elseif ($resultado === 'empatado') {
				$data['partidos_empatados'] = $equipo->partidos_empatados + 1;
				$data['puntos'] = $equipo->puntos + 1;
			} elseif ($resultado === 'perdido') {
				$data['partidos_perdidos'] = $equipo->partidos_perdidos + 1;
			}
			$this->db->where('id_equipo', $id_equipo);
			$this->db->update('clasificaciones', $data);
		}
	}
	
	

	
	
}
	
	




?>
