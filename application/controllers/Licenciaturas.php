
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Licenciaturas extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('cursos_index');
		$this->load->view('footer');
	}


	public function materias(){
		$this->load->view('header');
		$this->load->view('licenciaturas/materias');
		$this->load->view('footer');
	}
	

}
