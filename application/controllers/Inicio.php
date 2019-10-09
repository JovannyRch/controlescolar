
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
 
        // load Session Library
        $this->load->library('session');
         
        // load url helper
		$this->load->helper('url');
		
    }
	public function index()
	{
		//Vistas para los administrativos
		if($this->session->userdata('tipo_usuario') == 1){
			$this->load->view('header');
			$this->load->view('alumnos/inicio');
			$this->load->view('footer');
		}
		//Vistas para los alumnos
		if($this->session->userdata('tipo_usuario') == 4){
			$this->load->view('alumnos/header');
			$this->load->view('alumnos/inicio');
			$this->load->view('footer');
		}
		//Vistas para los profesores
		if($this->session->userdata('tipo_usuario') == 2){
			$this->load->view('profesores/headerSideBar');
			$this->load->view('alumnos/inicio');
			$this->load->view('footer');
		}
	}

}