<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Calificaciones extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("calificaciones_model");
    }

    public function calificaciones_get($id_calificacion = null)
    {
        if($id_calificacion) $resultado = $this->calificaciones_model->get($id_calificacion);
        else $resultado = $this->calificaciones_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de calificaciones", 400);
    }

    public function calificaciones_post()
    {
        $data = array(
		'calificacion' => $this->post('calificacion')
       );
        $resultado = $this->calificaciones_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de calificaciones",400);
    }

    public function calificaciones_put($id_calificacion)
    {
        /*
            
        */
        $data = array(
	    'calificacion' => $this->put('calificacion')
       );
        $resultado = $this->calificaciones_model->update($id_calificacion,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de calificaciones",400);
    }
    
    public function calificaciones_delete($id_calificacion)
    {
        $resultado = $this->calificaciones_model->delete($id_calificacion);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de calificaciones',400);
    }

    public function post_post(){
        $data = array(
	        'id_asignatura' => $this->post('id_asignatura'),
	        'id_convocatoria' => $this->post('id_convocatoria'),
	        'id_grupo' => $this->post('id_grupo'),
	        'id_profesor' => $this->post('id_profesor'),
	        'alumnos' => $this->post('alumnos'),
	        'id_evaluacion' => $this->post('id_evaluacion'),
	        'id_curso' => $this->post('id_curso')
       );
       $resultado = $this->calificaciones_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
     else $this->response("Error en el post de calificaciones",400);
    }
}