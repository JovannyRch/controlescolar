<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Alumnos extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("alumnos_model");
    }

    public function cursoActual_get($id_alumnno)
    {
        //jovannyrch@gmail.com
        $resultado = $this->alumnos_model->cursoActual($id_alumnno);
        $this->response($resultado, 200);
    }

    public function reporteCursoActual_get($id_alumnno){
        //jovannyrch@gmail.com
        $resultado = $this->alumnos_model->calificacionesPorCurso($id_alumnno);
        $this->response($resultado, 200);
    }

    public function reporteCalificaciones_get($id_alumnno){
        //jovannyrch@gmail.com
        $this->response(
            $this->alumnos_model->calificacionesAlumno($id_alumnno)
            ,200
        );
    }

    public function busqueda_get($por, $valor){
        //jovannyrch@gmail.com
        $this->response(
            $this->alumnos_model->busqueda($por, $valor)
            ,200
        );
    }





}
    