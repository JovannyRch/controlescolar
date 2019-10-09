<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Inscripciones extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("inscripciones_model");
    }

    public function inscripciones_get($id_inscripcion = null)
    {
        if($id_inscripcion) $resultado = $this->inscripciones_model->get($id_inscripcion);
        else $resultado = $this->inscripciones_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de inscripciones", 400);
    }

    public function inscripciones_post()
    {
        $data = array(
		'id_alumno' => $this->post('id_alumno'),
		'id_curso' => $this->post('id_curso'),
        'id_convocatoria' => $this->post('id_convocatoria'),
		'id_grupo' => $this->post('id_grupo')        
       );
        $resultado = $this->inscripciones_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de inscripciones",400);
    }

    public function inscripciones_put($id_inscripcion)
    {
        $data = array(
	    'id_alumno' => $this->put('id_alumno'),
	    'id_curso' => $this->put('id_curso'),
        'id_convocatoria' => $this->put('id_convocatoria'),
        'id_grupo' => $this->put('id_grupo')   
       );
        $resultado = $this->inscripciones_model->update($id_inscripcion,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de inscripciones",400);
    }
    
    public function inscripciones_delete($id_inscripcion)
    {
        $resultado = $this->inscripciones_model->delete($id_inscripcion);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de inscripciones',400);
    }

    public function validarInscripcion_get($id_convocatoria, $id_alumno){
        $resultado = $this->inscripciones_model->validarInscripcion($id_convocatoria, $id_alumno);
        if($resultado)$this->response(":)", 200);
        else $this->response("El alumno ya está inscrito en la convocatoria actual", 400);
    }
}
    