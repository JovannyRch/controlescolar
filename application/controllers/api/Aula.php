<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Aula extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("aula_model");
    }

    public function aula_get($id_aula = null)
    {
        if($id_aula) $resultado = $this->aula_model->get($id_aula);
        else $resultado = $this->aula_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de aula", 400);
    }

    public function aula_post()
    {
        $data = array(
		'nombre' => $this->post('nombre'),
		'descripcion' => $this->post('descripcion')
       );
        $resultado = $this->aula_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de aula",400);
    }

    public function aula_put($id_aula)
    {
        $data = array(
	    'nombre' => $this->put('nombre'),
	    'descripcion' => $this->put('descripcion')
       );
        $resultado = $this->aula_model->update($id_aula,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de aula",400);
    }
    
    public function aula_delete($id_aula)
    {
        $resultado = $this->aula_model->delete($id_aula);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de aula',400);
    }
}
    