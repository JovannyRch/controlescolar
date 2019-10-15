<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Usuarios_api extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("usuarios_model");
    }

    public function usuarios_get($id_usuario = null)
    {
        if($id_usuario) $resultado = $this->usuarios_model->get($id_usuario);
        else $resultado = $this->usuarios_model->get();
        if($resultado)$this->response(array(), 200);
        else $this->response("Error en el get de usuarios", 400);
    }

    public function usuarios_post()
    {   
        $data = array(
		'id_tipo_usuario' => $this->post(id_tipo_usuario),
		'nombre' => $this->post(nombre),
		'apellido_paterno' => $this->post(apellido_paterno),
		'apellido_materno' => $this->post(apellido_materno),
		'email' => $this->post(email),
		'fecha_alta' => $this->post(fecha_alta),
       );
        $resultado = $this->usuarios_model->save($data);
        if($resultado) $this->response($resultado,200);
        else $this->response("BRO",400);
    }

    public function usuarios_put($id_usuario)
    {
        $data = array(
	    'id_tipo_usuario' => $this->put(id_tipo_usuario),
	    'nombre' => $this->put(nombre),
	    'apellido_paterno' => $this->put(apellido_paterno),
	    'apellido_materno' => $this->put(apellido_materno),
	    'email' => $this->put(email),
	    'localidad' => $this->put(localidad),
       );
        $resultado = $this->usuarios_model->update($id_usuario,$data);
        $this->response('Moficado con éxito',200);  
    }
    
    public function usuarios_delete($id_usuario)
    {
        $resultado = $this->usuarios_model->delete($id_usuario);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de usuarios',400);
    }

    public function buscarAlumno_get($nombre){
        $resultado = $this->usuarios_model->like($nombre);
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de usuarios", 400);
    }

    public function mensajesNoLeidos_get($id_usuario){
        $resultado = $this->usuarios_model->getMensajesNoLeidos($id_usuario);
        $this->response($resultado, 200);
    }

    public function registarAlumno_post(){
        $datos_usuario = $this->post("datos_usuario");
        $datos_alumno = $this->post("datos_alumno");
        $id_usuario = $this->usuarios_model->registrarAlumno($datos_usuario, $datos_alumno);
        if($id_usuario){
            $this->response($id_usuario,200);
        }else{
            $this->response("Error al registar el alumno",400);
        }
    }

    

}
    