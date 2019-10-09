<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Profesores_materias_grupos extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("profesores_materias_grupos_model");
    }

    public function profesores_materias_grupos_get($id = null)
    {
        if($id) $resultado = $this->profesores_materias_grupos_model->get($id);
        else $resultado = $this->profesores_materias_grupos_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de profesores_materias_grupos", 400);
    }

    public function profesores_materias_gruposXprofesor_get($id_profesor){
        $resultado = $this->profesores_materias_grupos_model->getXprofesor($id_profesor);
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de profesores_materias_grupos_x_profesor", 400);
    }

    public function profesores_materias_grupos_post()
    {
        $data = array(
		'id_grupo' => $this->post('id_grupo'),
		'id_asignatura' => $this->post('id_asignatura'),
	    'id_profesor' => $this->post('id_profesor'),
	    'id_convocatoria' => $this->post('id_convocatoria')
       );
        $resultado = $this->profesores_materias_grupos_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de profesores_materias_grupos",400);
    }

    public function post_post(){
        $data = array(
            'id_profesores_materias' => $this->post('id_profesores_materias'),
            'id_grupo' => $this->post('id_grupo')
        );
        $resultado = $this->profesores_materias_grupos_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de profesores_materias_grupos",400);
    }

    public function delete_delete($id_profesores_materias){
        $resultado = $this->profesores_materias_grupos_model->delete($id_profesores_materias);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de profesores_materias_grupos',400);
    }

    public function profesores_materias_grupos_put($id)
    {
        $data = array(
	    'id_grupo' => $this->put('id_grupo'),
	    'id_asignatura' => $this->put('id_asignatura'),
        'id_profesor' => $this->put('id_profesor'),
        'id_convocatoria' => $this->put('id_convocatoria')
       );
        $resultado = $this->profesores_materias_grupos_model->update($id,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de profesores_materias_grupos",400);
    }
    
}
    