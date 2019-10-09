
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profesores extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('usuarios_model');
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('profesor_index');
		$this->load->view('footer');
    }
    
    public function registro(){
        $this->load->view('header');
		$this->load->view('profesor_nuevo');
		$this->load->view('footer');
    }

    public function ver($id){
      	
		$datos['id'] = $id;
		$usuario = $this->usuarios_model->get($id);
		$datos['id_tipo_usuario'] = $usuario['id_tipo_usuario'];
		
		$this->load->view('profesores/headerSideBar');
		$this->load->view('usuarios_ver',$datos);
		$this->load->view('footer');
	}

	public function editar($id){
		$datos['id'] = $id;
        $this->load->view('profesores/headerSideBar');
		$this->load->view('usuarios_editar',$datos);
		$this->load->view('footer');
	}


	public function materias(){
		$datos['id_profesor'] = $this->session->userdata('id_usuario');
        $this->load->view('profesores/headerSideBar');
		$this->load->view('profesores/materias',$datos);
		$this->load->view('footer');
	}

	public function grupo($id_asignatura,$id_grupo){
		$datos = array(
			'id_profesor' => $this->session->userdata('id_usuario'),
			'id_asignatura' => $id_asignatura,
			'id_grupo' => $id_grupo
		);
		$this->load->view('profesores/headerSideBar');
		$this->load->view('profesores/grupo',$datos);
		$this->load->view('footer');
	}

	public function rMaterias($id_profesor)
	{
		if($this->session->userdata('tipo_usuario') == 1){
			$datos['id_profesor'] = $id_profesor;
			$this->load->view('header2');
			$this->load->view('profesores/rMatrias',$datos);
			$this->load->view('footer');
		}
	}

}
