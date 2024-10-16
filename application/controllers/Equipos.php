<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/PHPExcel/Classes/PHPExcel.php';


class Equipos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Equipo_model'); 
		if (!$this->session->userdata('logged_in')) {
            redirect('http://localhost/sofutbol/'); 
        }	
    }

    public function index() {
        $data['equipos'] = $this->Equipo_model->get_all_equipos(); 
        $this->load->view('listar_equipos', $data); 
    }

    public function exportar_equipos_excel() {
        $objPHPExcel = new PHPExcel(); 
        $sheet = $objPHPExcel->setActiveSheetIndex(0); 
       
        $sheet->setCellValue('A1', 'ID Equipo');
        $sheet->setCellValue('B1', 'Nombre Equipo');
        $sheet->setCellValue('C1', 'Entrenador');

    
        $equipos = $this->Equipo_model->get_all_equipos(); 

        $row = 2; 
        foreach ($equipos as $equipo) {
            $sheet->setCellValue('A' . $row, $equipo->id_equipo);
            $sheet->setCellValue('B' . $row, $equipo->nombre_equipo);
            $sheet->setCellValue('C' . $row, $equipo->nombre_entrenador); 
            $row++;
        }

      
        $filename = 'equipos_' . date('Y-m-d') . '.xlsx';

      
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        ob_end_clean(); 
        flush(); 

      
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}