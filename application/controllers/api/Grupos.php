<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Grupos extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("grupos_model");
    }

    public function grupos_get($id_grupo = null)
    {
        if($id_grupo) $resultado = $this->grupos_model->get($id_grupo);
        else $resultado = $this->grupos_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de grupos", 400);
    }

    public function grupos_post()
    {
        $data = array(
		'id_aula' => $this->post('id_aula'),
		'id_curso' => $this->post('id_curso'),
		'nombre' => $this->post('nombre'),
		'descripcion' => $this->post('descripcion')
       );
        $resultado = $this->grupos_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de grupos",400);
    }

    public function grupos_put($id_grupo)
    {
        $data = array(
	    'id_aula' => $this->put('id_aula'),
	    'id_curso' => $this->put('id_curso'),
	    'nombre' => $this->put('nombre'),
	    'descripcion' => $this->put('descripcion')
       );
        $resultado = $this->grupos_model->update($id_grupo,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de grupos",400);
    }
    
    public function grupos_delete($id_grupo)
    {
        $resultado = $this->grupos_model->delete($id_grupo);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de grupos',400);
    }

    public function gruposXcurso_get($id_curso)
    {
        $resultado = $this->grupos_model->getXcurso($id_curso);
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de grupos x cursos", 400);
    }

}
    