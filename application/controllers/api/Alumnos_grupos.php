<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Alumnos_grupos extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("alumnos_grupos_model");
    }

    public function alumnos_grupos_get($id = null)
    {
        if($id) $resultado = $this->alumnos_grupos_model->get($id);
        else $resultado = $this->alumnos_grupos_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de alumnos_grupos", 400);
    }

    public function alumnos_grupos_post()
    {
        $data = array(
		'id_alumno' => $this->post('id_alumno'),
		'id_grupo' => $this->post('id_grupo'),
       );
        $resultado = $this->alumnos_grupos_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de alumnos_grupos",400);
    }

    public function alumnos_grupos_put($id)
    {
        $data = array(
	    'id_alumno' => $this->put('id_alumno'),
	    'id_grupo' => $this->put('id_grupo'),
	    'id_convocatoria' => $this->put('id_convocatoria')
       );
        $resultado = $this->alumnos_grupos_model->update($id,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de alumnos_grupos",400);
    }
    
    public function alumnos_grupos_delete($id)
    {
        $resultado = $this->alumnos_grupos_model->delete($id);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de alumnos_grupos',400);
    }


    
    public function alumnos_get($id_grupo){
        $this->response(
            $this->alumnos_grupos_model->get_alumnos($id_grupo)
            , 200);
    }

}
    
