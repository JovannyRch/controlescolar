<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Pagos extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("pagos_model");
    }

    public function pagos_get($id = null)
    {
        if($id) $resultado = $this->pagos_model->get($id);
        else $resultado = $this->pagos_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de pagos", 400);
    }

    public function pagos_post()
    {
        $data = array(
		'id_convocatoria' => $this->post('id_convocatoria'),
		'id_alumno' => $this->post('id_alumno'),
		'fecha' => $this->post('fecha'),
		'monto' => $this->post('monto')
       );
        $resultado = $this->pagos_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de pagos",400);
    }

    public function pagos_put($id)
    {
        $data = array(
	    'id_convocatoria' => $this->put('id_convocatoria'),
	    'id_alumno' => $this->put('id_alumno'),
	    'fecha' => $this->put('fecha'),
	    'monto' => $this->put('monto')
       );
        $resultado = $this->pagos_model->update($id,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de pagos",400);
    }
    
    public function pagos_delete($id)
    {
        $resultado = $this->pagos_model->delete($id);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de pagos',400);
    }
}
    