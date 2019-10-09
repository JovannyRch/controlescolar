<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Asignaturas_usuario extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("asignaturas_usuario_model");
    }

    public function asignaturas_usuario_get($id_asignaturas_usuario = null)
    {
        if($id_asignaturas_usuario) $resultado = $this->asignaturas_usuario_model->get($id_asignaturas_usuario);
        else $resultado = $this->asignaturas_usuario_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de asignaturas_usuario", 400);
    }

    public function asignaturas_usuario_post()
    {
        $data = array(
		'id_usuario' => $this->post('id_usuario'),
		'id_asignatura' => $this->post('id_asignatura')
       );
        $resultado = $this->asignaturas_usuario_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de asignaturas_usuario",400);
    }

    public function asignaturas_usuario_put($id_asignaturas_usuario)
    {
        $data = array(
	    'id_usuario' => $this->put('id_usuario'),
	    'id_asignatura' => $this->put('id_asignatura')
       );
        $resultado = $this->asignaturas_usuario_model->update($id_asignaturas_usuario,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de asignaturas_usuario",400);
    }
    
    public function asignaturas_usuario_delete($id_asignaturas_usuario)
    {
        $resultado = $this->asignaturas_usuario_model->delete($id_asignaturas_usuario);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de asignaturas_usuario',400);
    }
}