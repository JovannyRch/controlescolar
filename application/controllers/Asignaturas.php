
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asignaturas extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('asignatura_model');
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('asignaturas_index');
		$this->load->view('footer');
	}
	
	public function gestion($id_asignatura){
		
		// Obtenemos toda la informacion acerca de la asignatura
		$datos = $this->asignatura_model->getDatos($id_asignatura);
		if($datos){
			$this->load->view('header');
			$this->load->view('asignatura_gestion',$datos);
			$this->load->view('footer');
		}else{
			$this->load->view('header');
			echo "<h1 class='text-center'>NO SE ENCONTRÓ LA MATERIA</h1>";
			$this->load->view('footer');
		}
		
	}

}
