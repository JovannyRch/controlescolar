
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscripciones extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function alumno($id_alumno)
	{
		$datos['id'] = $id_alumno;
		$this->load->view('header');
		$this->load->view('inscripciones_index',$datos);
		$this->load->view('footer');
    }

}
