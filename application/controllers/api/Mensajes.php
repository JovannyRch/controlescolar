<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Mensajes extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("mensajes_model");
    }

    public function mensajes_get($id_mensaje = null)
    {
        if($id_mensaje) $resultado = $this->mensajes_model->get($id_mensaje);
        else $resultado = $this->mensajes_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de mensajes", 400);
    }

    public function mensajes_entrada_get($id_usuario)
    {
        $resultado = $this->mensajes_model->getEntrada($id_usuario);
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de mensajes entrada", 400);
    }

    public function mensajes_salida_get($id_usuario)
    {
        $resultado = $this->mensajes_model->getSalida($id_usuario);
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de mensajes salida", 400);
    }

    public function mensajes_post()
    {
        $data = array(
		'id_remitente' => $this->post('id_remitente'),
		'id_destinatario' => $this->post('id_destinatario'),
		'asunto' => $this->post('asunto'),
		'texto' => $this->post('texto'),
		'fecha_hora' => $this->post('fecha_hora'),
		'id_prioridad' => $this->post('id_prioridad'),
		'leido' => $this->post('leido')
       );
        $resultado = $this->mensajes_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de mensajes",400);
    }

    public function destinatarios_post(){
        $destinatarios = $this->post('destinatarios');
        $data = array(
            'id_remitente' => $this->post('id_remitente'),
            'asunto' => $this->post('asunto'),
            'texto' => $this->post('texto'),
            'fecha_hora' => $this->post('fecha_hora'),
            'id_prioridad' => $this->post('id_prioridad'),
            'leido' => $this->post('leido')
           );
            $resultado = $this->mensajes_model->saveDestinatarios($destinatarios,$data);
            if($resultado) $this->response('Guardado con éxito',200);
            else $this->response("Error en el post de mensajes",400);
    }

    public function mensajes_put($id_mensaje)
    {
        $data = array(
	    'id_remitente' => $this->put('id_remitente'),
	    'id_destinatario' => $this->put('id_destinatario'),
	    'asunto' => $this->put('asunto'),
	    'texto' => $this->put('texto'),
	    'fecha_hora' => $this->put('fecha_hora'),
	    'id_prioridad' => $this->put('id_prioridad'),
	    'leido' => $this->put('leido')
       );
        $resultado = $this->mensajes_model->update($id_mensaje,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de mensajes",400);
    }

    public function mensajeLeido_put($id_mensaje)
    {
        $resultado = $this->mensajes_model->updateLeido($id_mensaje);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de mensajes",400);
    }
    
    public function mensajes_delete($id_mensaje)
    {
        $resultado = $this->mensajes_model->delete($id_mensaje);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de mensajes',400);
    }
}
    