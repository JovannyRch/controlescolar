
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensajes extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		if($this->session->userdata('tipo_usuario') == 1){
			$this->load->view('header');
			$this->load->view('mensajes_index');
			$this->load->view('footer');
		}

		if($this->session->userdata('tipo_usuario') == 2){
			$this->load->view('profesores/headerSideBar');
			$this->load->view('mensajes_index');
			$this->load->view('footer');
		}

		if($this->session->userdata('tipo_usuario') == 4){
			$this->load->view('alumnos/header');
			$this->load->view('mensajes_index');
			$this->load->view('alumnos/footer');
		}
		
    }

}
