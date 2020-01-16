<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Cursos_materias extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("cursos_materias_model");
    }

    public function cursos_materias_get($id = null)
    {
        if($id) $resultado = $this->cursos_materias_model->get($id);
        else $resultado = $this->cursos_materias_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de cursos_materias", 400);
    }

    public function cursos_materias_post()
    {
        $data = array(
		'id_curso' => $this->post('id_curso'),
		'id_asignatura' => $this->post('id_asignatura')
       );
        $resultado = $this->cursos_materias_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de cursos_materias",400);
    }

    public function cursos_materias_put($id)
    {
        $data = array(
	    'id_curso' => $this->put('id_curso'),
	    'id_asignatura' => $this->put('id_asignatura')
       );
        $resultado = $this->cursos_materias_model->update($id,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de cursos_materias",400);
    }
    
    public function cursos_materias_delete($id)
    {
        $resultado = $this->cursos_materias_model->delete($id);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de cursos_materias',400);
    }
}
    