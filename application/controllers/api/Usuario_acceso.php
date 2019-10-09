<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Usuario_acceso extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("usuario_acceso_model");
    }

    public function usuario_acceso_get($id_usuario_acceso = null)
    {
        if($id_usuario_acceso) $resultado = $this->usuario_acceso_model->get($id_usuario_acceso);
        else $resultado = $this->usuario_acceso_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response($resultado, 400);
    }

    public function usuario_login_get($id_usuario)
    {
        $resultado = $this->usuario_acceso_model->getByUser($id_usuario);
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de usuario_acceso", 400);
    }

    public function usuario_acceso_post()
    {
        $data = array(
		'id_usuario' => $this->post('id_usuario'),
		'logins' => $this->post('login'),
		'password' => $this->post('password')
       );
        $resultado = $this->usuario_acceso_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de usuario_acceso",400);
    }

    public function usuario_acceso_put($id_usuario_acceso)
    {
        $data = array(
	    'id_usuario' => $this->put('id_usuario'),
	    'logins' => $this->put('login'),
	    'password' => $this->put('password')
       );
        $resultado = $this->usuario_acceso_model->update($id_usuario_acceso,$data);
        if($resultado) $this->response('Login moficado con éxito',200);
        else  $this->response("Error en el post de usuario_acceso",400);
    }
    
    public function usuario_acceso_delete($id_usuario_acceso)
    {
        $resultado = $this->usuario_acceso_model->delete($id_usuario_acceso);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de usuario_acceso',400);
    }
}
    