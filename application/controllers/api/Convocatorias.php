<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Convocatorias extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("convocatorias_model");
    }

    public function convocatoriaActual_get()
    {
        $resultado = $this->convocatorias_model->getActual();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de convocatorias", 400);
    }

    public function convocatorias_get($id_convocatoria = null)
    {
        if($id_convocatoria) $resultado = $this->convocatorias_model->get($id_convocatoria);
        else $resultado = $this->convocatorias_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de convocatorias", 400);
    }

    public function convocatorias_post()
    {
        $data = array(
        'convocatoria' => $this->post('convocatoria'),
        'activo' => 0
       );
        $resultado = $this->convocatorias_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de convocatorias",400);
    }

    public function convocatorias_put($id_convocatoria)
    {
        $data = array(
	    'convocatoria' => $this->put('convocatoria')
       );
        $resultado = $this->convocatorias_model->update($id_convocatoria,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de convocatorias",400);
    }
    
    public function convocatorias_delete($id_convocatoria)
    {
        $resultado = $this->convocatorias_model->delete($id_convocatoria);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de convocatorias',400);
    }

    public function activar_post($id_convocatoria){
        $resultado = $this->convocatorias_model->activar($id_convocatoria);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de convocatorias",400);
    }

    
}
    