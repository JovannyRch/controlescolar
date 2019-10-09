<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Hijos extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("hijos_model");
    }

    public function hijos_get($id_hijos = null)
    {
        if($id_hijos) $resultado = $this->hijos_model->get($id_hijos);
        else $resultado = $this->hijos_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de hijos", 400);
    }

    public function hijos_post()
    {
        $data = array(
		'id_padre' => $this->post('id_padre'),
		'id_hijo' => $this->post('id_hijo')
       );
        $resultado = $this->hijos_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de hijos",400);
    }

    public function hijos_put($id_hijos)
    {
        $data = array(
	    'id_padre' => $this->put('id_padre'),
	    'id_hijo' => $this->put('id_hijo')
       );
        $resultado = $this->hijos_model->update($id_hijos,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de hijos",400);
    }
    
    public function hijos_delete($id_hijos)
    {
        $resultado = $this->hijos_model->delete($id_hijos);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de hijos',400);
    }
}
    