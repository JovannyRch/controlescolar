
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('grupos_index');
		$this->load->view('footer');
	}
	
	public function reporte($id_grupo){
		$datos['id_grupo'] = $id_grupo;
		$this->load->view('header2');
		$this->load->view('grupos/reporte',$datos);
		$this->load->view('footer');
	}
	public function reporteMaterias($id_grupo){
		$datos['id_grupo'] = $id_grupo;
		$this->load->view('header2');
		$this->load->view('grupos/reporteMaterias',$datos);
		$this->load->view('footer');
	}

}
