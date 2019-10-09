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
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de usuarios", 400);
    }

    public function profesores_get()
    {
        $resultado = $this->usuarios_model->getProfesores();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de profesores_get", 400);
    }

    public function alumnos_get()
    {
         $resultado = $this->usuarios_model->getAlumnos();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de alumnos_get", 400);
    }

    public function padres_get()
    {
        $resultado = $this->usuarios_model->getPadres();
      
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de padres_get", 400);
    }

    public function usuarios_post()
    {
       
        $data = array(
		'id_tipo_usuario' =>  htmlspecialchars($this->post('id_tipo_usuario')),
		'nombre' =>  htmlspecialchars($this->post('nombre')),
		'apellido_paterno' =>  htmlspecialchars($this->post('apellido_paterno')),
		'apellido_materno' =>  htmlspecialchars($this->post('apellido_materno')),
		'email' =>  htmlspecialchars($this->post('email')),
		'direccion' =>  htmlspecialchars($this->post('direccion')),
		'localidad' =>  htmlspecialchars($this->post('localidad')),
		'pais' =>  htmlspecialchars($this->post('pais')),
		'fecha_alta' =>  htmlspecialchars($this->post('fecha_alta')),
		'fecha_nacimiento' =>  htmlspecialchars($this->post('fecha_nacimiento')),
		'telefono' =>  htmlspecialchars($this->post('telefono')),
		'cod_postal' =>  htmlspecialchars($this->post('cod_postal'))
       );
        $resultado = $this->usuarios_model->save($data);
        if($resultado) $this->response($resultado,200);
        else $this->response("Error en el post de usuarios",400);
    }

    public function usuarios_put($id_usuario)
    {
        
        $data = array(
	    'id_tipo_usuario' => htmlspecialchars($this->put('id_tipo_usuario')),
	    'nombre' => htmlspecialchars($this->put('nombre')),
	    'apellido_paterno' => htmlspecialchars($this->put('apellido_paterno')),
	    'apellido_materno' => htmlspecialchars($this->put('apellido_materno')),
	    'email' => htmlspecialchars($this->put('email')),
	    'direccion' => htmlspecialchars($this->put('direccion')),
	    'localidad' => htmlspecialchars($this->put('localidad')),
	    'pais' => htmlspecialchars($this->put('pais')),
	    'fecha_alta' => htmlspecialchars($this->put('fecha_alta')),
	    'fecha_nacimiento' => htmlspecialchars($this->put('fecha_nacimiento')),
        'telefono' => htmlspecialchars($this->put('telefono')),
		'cod_postal' => htmlspecialchars($this->put('cod_postal'))
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
}
    