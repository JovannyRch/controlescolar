
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	
    public function general(){
        $this->load->view('header2');
		$this->load->view('reportes/general');
		$this->load->view('footer');
	}
	
	public function materias(){
		$this->load->view('header2');
		$this->load->view('reportes/materias');
		$this->load->view('footer');
	}
}
