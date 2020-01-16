<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Calificaciones_materia extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("calificaciones_materia_model");
    }

    public function calificaciones_materia_get($id = null)
    {
        if($id) $resultado = $this->calificaciones_materia_model->get($id);
        else $resultado = $this->calificaciones_materia_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de calificaciones_materia", 400);
    }

    public function calificaciones_materia_post()
    {
        $data = array(
		'id_alumno' => $this->post('id_alumno'),
		'id_materia' => $this->post('id_materia'),
		'id_convocatoria' => $this->post('id_convocatoria'),
		'primera_evaluacion' => $this->post('primera_evaluacion'),
		'segunda_evaluacion' => $this->post('segunda_evaluacion'),
		'final' => $this->post('final'),
		'extraordinario' => $this->post('extraordinario'),
		'promedio' => $this->post('promedio')
       );
        $resultado = $this->calificaciones_materia_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de calificaciones_materia",400);
    }

    public function calificaciones_materia_put($id)
    {
        $data = array(
	    'id_alumno' => $this->put('id_alumno'),
	    'id_materia' => $this->put('id_materia'),
	    'id_convocatoria' => $this->put('id_convocatoria'),
	    'primera_evaluacion' => $this->put('primera_evaluacion'),
	    'segunda_evaluacion' => $this->put('segunda_evaluacion'),
	    'final' => $this->put('final'),
	    'extraordinario' => $this->put('extraordinario'),
	    'promedio' => $this->put('promedio')
       );
        $resultado = $this->calificaciones_materia_model->update($id,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de calificaciones_materia",400);
    }
    
    public function calificaciones_materia_delete($id)
    {
        $resultado = $this->calificaciones_materia_model->delete($id);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de calificaciones_materia',400);
    }
}
    