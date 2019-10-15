<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Licenciaturas extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("licenciaturas_model");
    }

    public function licenciaturas_get($id = null)
    {
        
        if($id) $resultado = $this->licenciaturas_model->get($id);
        else $resultado = $this->licenciaturas_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de licenciaturas", 400);
    }

    public function licenciaturas_post()
    {
        $data = array(
		'nombre' => $this->post('nombre')
       );
        $resultado = $this->licenciaturas_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de licenciaturas",400);
    }

    public function licenciaturas_put($id)
    {
        $data = array(
	    'nombre' => $this->put('nombre')
       );
        $resultado = $this->licenciaturas_model->update($id,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de licenciaturas",400);
    }
    
    public function licenciaturas_delete($id)
    {
        $resultado = $this->licenciaturas_model->delete($id);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de licenciaturas',400);
    }
}
    