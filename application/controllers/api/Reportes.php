<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Reportes extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("reportes_model");
    }


    public function grupo_get($id_grupo){
        $this->response(
            $this->reportes_model->grupo($id_grupo)
            ,200
        );
    }

    public function grupoMaterias_get($id_grupo){
        $this->response(
            $this->reportes_model->grupoMaterias($id_grupo)
            ,200
        );
    }

    public function profesorMateria_get($id_profesor){
        $this->response(
            $this->reportes_model->profesorMateria($id_profesor)
            ,200
        );
    }

    public function general_get(){
        $this->response(
            $this->reportes_model->general()
            ,200
        );
    }

    public function materias_get(){
        $this->response(
            $this->reportes_model->materias()
            ,200
        );
    }

}
    