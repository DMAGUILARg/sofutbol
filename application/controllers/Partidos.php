<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/PHPExcel/Classes/PHPExcel.php';

class Partidos extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if (!$this->session->userdata('logged_in')) {
            redirect('http://localhost/sofutbol/'); 
        }	
	}
    public function index($id_jornada = null) {
        $this->load->model('Torneo_model');  
		$this->load->model('Partido_model');
        
		$data['torneos'] = $this->Partido_model->obtener_torneos_activos();
        
        if (empty($data['torneos'])) {
            $data['error'] = "No se encontraron torneos.";
        }
        
    
        if ($id_jornada === null) {
            $this->db->select_min('id_jornada');
            $query = $this->db->get('jornadas');
            $row = $query->row();
            $id_jornada = $row ? $row->id_jornada : null;
        }

   
        $this->db->where('id_jornada', $id_jornada);
        $jornada = $this->db->get('jornadas')->row();

        if (!$jornada) {
            $data['error'] = 'La jornada seleccionada no existe.';
            $data['jornada'] = null;
            $data['partidos'] = [];
        } else {
            $data['partidos'] = $this->Partido_model->get_partidos_by_jornada($id_jornada);
            $data['jornada'] = $jornada;
        }

        $this->load->view('calendario', $data);
    }

    public function cambiar_jornada($id_jornada) {
        $this->index($id_jornada);  
    }

    public function upload() {
		$id_torneo = $this->input->post('id_torneo');
	
		
		if (empty($_FILES['file']['tmp_name'])) {
			$this->session->set_flashdata('error', 'No se ha subido ningún archivo.');
			redirect('partidos');
			return;
		}
	
		$this->load->library('excel');
	
		try {
			$file = $_FILES['file']['tmp_name'];
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
	
			
			$this->load->model('Partido_model');
			$equipos = $this->Partido_model->obtener_equipos_por_torneo($id_torneo);
			if (empty($equipos)) {
				throw new Exception('No se encontraron equipos para el torneo seleccionado.');
			}
	
			shuffle($equipos); 
			$this->generar_jornadas_aleatorias($id_torneo, $equipos);
	
			redirect('partidos');
		} catch (Exception $e) {
			$this->session->set_flashdata('error', $e->getMessage());
			redirect('partidos');
		}
	}
	
    
 
    private function generar_jornadas_aleatorias($id_torneo, $equipos) {
		$this->load->model('Partido_model');
		$this->load->model('Notificaciones_model');
		
		$torneo = $this->Partido_model->obtener_fechas_torneo($id_torneo);
		$fecha_inicio = strtotime($torneo->fecha_inicio);
		$fecha_fin = strtotime($torneo->fecha_fin);
	
		// Definir cuántas jornadas serán necesarias
		$numero_jornadas = ceil(count($equipos) / 2);
	
		// Distribuir las jornadas y fechas
		for ($i = 0; $i < $numero_jornadas; $i++) {
			$nombre_jornada = 'Jornada ' . ($i + 1);
			$fecha_jornada_inicio = date('Y-m-d', mt_rand($fecha_inicio, $fecha_fin));
			$fecha_jornada_fin = date('Y-m-d', mt_rand($fecha_jornada_inicio, $fecha_fin));
	
			// Crear la jornada en la base de datos
			$jornada_data = [
				'id_torneo' => $id_torneo,
				'nombre_jornada' => $nombre_jornada,
				'fecha_inicio' => $fecha_jornada_inicio,
				'fecha_fin' => $fecha_jornada_fin
			];
			$id_jornada = $this->Partido_model->insertar_jornada($jornada_data);
	
			// Crear partidos para la jornada
			for ($j = 0; $j < count($equipos); $j += 2) {
				if (isset($equipos[$j + 1])) {
					$partido_data = [
						'id_torneo' => $id_torneo,
						'id_equipo_local' => $equipos[$j]->id_equipo,
						'id_equipo_visitante' => $equipos[$j + 1]->id_equipo,
						'fecha_partido' => date('Y-m-d', mt_rand($fecha_inicio, $fecha_fin)),
						'hora_partido' => '15:00:00', 
						'id_jornada' => $id_jornada,
						'lugar_partido' => 'Estadio Principal'
					];
	
					// Insertar partido
					$this->Partido_model->insertar_partido($partido_data);
					$id_partido = $this->db->insert_id(); // Obtener el ID del partido insertado
	
					// Crear mensaje de notificación para el equipo local
					$mensaje_local = 'Tienes un partido programado contra ' . $equipos[$j + 1]->nombre_equipo . ' el ' . $partido_data['fecha_partido'] . ' en ' . $partido_data['lugar_partido'] . '.';
					
					// Insertar notificación para el equipo local
					$this->Notificaciones_model->insertar_notificacion([
						'id_usuario' => $equipos[$j]->id_usuario, // ID del entrenador del equipo local
						'id_partido' => $id_partido,
						'mensaje' => $mensaje_local
					]);
	
					
					$mensaje_visitante = 'Tienes un partido programado contra ' . $equipos[$j]->nombre_equipo . ' el ' . $partido_data['fecha_partido'] . ' en ' . $partido_data['lugar_partido'] . '.';
	
					// Insertar notificación para el equipo visitante
					$this->Notificaciones_model->insertar_notificacion([
						'id_usuario' => $equipos[$j + 1]->id_usuario, 
						'id_partido' => $id_partido,
						'mensaje' => $mensaje_visitante
					]);
				}
			}
		}
	}
	


	public function editar_resultado() {
		$id_partido = $this->input->post('id_partido');
		$goles_local = $this->input->post('goles_local');
		$goles_visitante = $this->input->post('goles_visitante');
		$estado = $this->input->post('estado');
		
		$data_partido = [
			'estado' => $estado
		];
	
		$data_resultado = [
			'goles_equipo_local' => $goles_local,
			'goles_equipo_visitante' => $goles_visitante
		];
	
		$this->load->model('Partido_model');
	
		$this->Partido_model->actualizar_partido($id_partido, $data_partido);
	
		$this->Partido_model->actualizar_resultado($id_partido, $data_resultado);
	
		if ($estado === 'finalizado') {
			$this->Partido_model->actualizar_clasificaciones($id_partido, $goles_local, $goles_visitante);
		}

		$this->session->set_flashdata('success', 'El partido se ha actualizado exitosamente.');
		$this->output->set_content_type('application/json')->set_output(json_encode(['success' => true]));
	}
	
	
	
	
	
}