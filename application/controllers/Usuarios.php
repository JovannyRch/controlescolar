
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('usuarios_model');
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('usuarios');
		$this->load->view('footer');
		$this->load->model('usuarios_model');
	}

	

	public function registro(){
        $this->load->view('header');
		$this->load->view('usuario_registro');
		$this->load->view('footer');
	}
	
	public function editar($id){
        $datos['id'] = $id;
        
		if($this->session->userdata('tipo_usuario') == 1){
			$this->load->view('header');
			$this->load->view('usuarios_editar2',$datos);
			$this->load->view('footer');

		}

		if($this->session->userdata('tipo_usuario') == 2){
			$this->load->view('profesores/headerSideBar');
			$this->load->view('usuarios_editar',$datos);
			$this->load->view('footer');
		}

		if($this->session->userdata('tipo_usuario') == 4){
			$this->load->view('alumnos/header');
			$this->load->view('usuarios_editar',$datos);
			$this->load->view('footer');
		}


	}

	
	public function ver($id){
		$datos['id'] = $id;
		$usuario = $this->usuarios_model->get($id);
		$datos['id_tipo_usuario'] = $usuario['id_tipo_usuario'];
		
		


		if($this->session->userdata('tipo_usuario') == 1){
			$this->load->view('header');
			$this->load->view('usuarios_ver',$datos);
			$this->load->view('footer');
		}

		if($this->session->userdata('tipo_usuario') == 2){
			$this->load->view('profesores/headerSideBar');
			$this->load->view('usuarios_ver',$datos);
			$this->load->view('footer');
		}

		if($this->session->userdata('tipo_usuario') == 4){
			$this->load->view('alumnos/header');
			$this->load->view('usuarios_ver2',$datos);
			$this->load->view('footer');
		}
    }

}
