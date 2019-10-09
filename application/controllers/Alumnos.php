<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumnos extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model("alumnos_model");
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('alumnos_index');
		$this->load->view('footer');
    }
    
    public function registro(){
        $this->load->view('header');
		$this->load->view('alumnos_nuevo');
		$this->load->view('footer');
    }

    public function ver($id){
        $datos['id'] = $id;
        $this->load->view('header');
		$this->load->view('alumnos_mostrar',$datos);
		$this->load->view('footer');
    }
	public function trayectoria(){
		$this->load->view('alumnos/header');
		$this->load->view('alumnos/trayectoria');
		$this->load->view('footer');
	}

	public function cursos(){
		$id_alumno = $this->session->userdata('id_usuario');
		$datos = $this->alumnos_model->cursoActual($id_alumno);
		if(!$datos){
			$datos = array(
				'titulo' =>  'El alumno no está inscrito en la convocatoria actual',
				'texto' => 'Acude a Control Escolar a solicitar tu inscripción o manda mensaje a administración.'
			);
			$this->load->view('alumnos/header');
			$this->load->view('mensajes',$datos);
			$this->load->view('footer');
		}else{
			$this->load->view('alumnos/header');
		$this->load->view('alumnos/cursos',$datos);
		$this->load->view('footer');
		}
		
	}

	public function datos(){
		$this->load->view('alumnos/header');
		$this->load->view('alumnos/datosPersonales');
		$this->load->view('footer');
	}

	public function calificaciones($id_alumno = null){
		if($this->session->userdata('tipo_usuario') == 4){
			$data['id_alumno'] = $this->session->userdata('id_usuario') ;
			$this->load->view('alumnos/header');
			$this->load->view('alumnos/calificaciones',$data);
			$this->load->view('footer');
		}

		if($this->session->userdata('tipo_usuario') == 1){
			$datos = $this->alumnos_model->cursoActual($id_alumno);
			if($datos){
				$data['id_alumno'] = $id_alumno ;
				$this->load->view('alumnos/header');
				$this->load->view('alumnos/calificaciones',$data);
				$this->load->view('alumnos/cursos',$datos);
				$this->load->view('footer');
			}
			else{
				$datos = array(
					'titulo' =>  'No hay datos suficientes del alumno',
					'texto' => 'Disculpe las molestias :('
				);
				$this->load->view('alumnos/header');
				$this->load->view('mensajes',$datos);
				$this->load->view('footer');
			}
		}
		
	}

	public function tareas(){
		$this->load->view('alumnos/header');
		$this->load->view('alumnos/tareas');
		$this->load->view('footer');
	}
}
