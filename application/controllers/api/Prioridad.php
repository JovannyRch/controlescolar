<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Prioridad extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("prioridad_model");
    }

    public function prioridad_get($id_prioridad = null)
    {
        if($id_prioridad) $resultado = $this->prioridad_model->get($id_prioridad);
        else $resultado = $this->prioridad_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de prioridad", 400);
    }

    public function prioridad_post()
    {
        $data = array(
		'nombre' => $this->post('nombre')
       );
        $resultado = $this->prioridad_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de prioridad",400);
    }

    public function prioridad_put($id_prioridad)
    {
        $data = array(
	    'nombre' => $this->put('nombre')
       );
        $resultado = $this->prioridad_model->update($id_prioridad,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de prioridad",400);
    }
    
    public function prioridad_delete($id_prioridad)
    {
        $resultado = $this->prioridad_model->delete($id_prioridad);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de prioridad',400);
    }
}
    