<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Curso extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("curso_model");
    }

    public function curso_get($id_curso = null)
    {
        if($id_curso) $resultado = $this->curso_model->get($id_curso);
        else $resultado = $this->curso_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de curso", 400);
    }

    public function curso_post()
    {
        $data = array(
		'nombre' => $this->post('nombre'),
		'descripcion' => $this->post('descripcion')
       );
        $resultado = $this->curso_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de curso",400);
    }

    public function curso_put($id_curso)
    {
        $data = array(
	    'nombre' => $this->put('nombre'),
	    'descripcion' => $this->put('descripcion')
       );
        $resultado = $this->curso_model->update($id_curso,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de curso",400);
    }
    
    public function curso_delete($id_curso)
    {
        $resultado = $this->curso_model->delete($id_curso);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de curso',400);
    }
}
    