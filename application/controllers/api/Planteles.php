<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Planteles extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("planteles_model");
    }

    public function planteles_get($id = null)
    {
        if($id) $resultado = $this->planteles_model->get($id);
        else $resultado = $this->planteles_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de planteles", 400);
    }

    public function planteles_post()
    {
        $data = array(
		'nombre' => $this->post('nombre'),
		'telefono' => $this->post('telefono'),
		'correo' => $this->post('correo')
       );
        $resultado = $this->planteles_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de planteles",400);
    }

    public function planteles_put($id)
    {
        $data = array(
	    'nombre' => $this->put('nombre'),
	    'telefono' => $this->put('telefono'),
	    'correo' => $this->put('correo')
       );
        $resultado = $this->planteles_model->update($id,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de planteles",400);
    }
    
    public function planteles_delete($id)
    {
        $resultado = $this->planteles_model->delete($id);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de planteles',400);
    }
}
    