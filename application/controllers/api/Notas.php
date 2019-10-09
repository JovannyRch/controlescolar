<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Notas extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("notas_model");
    }

    public function notas_get($id_nota = null)
    {
        if($id_nota) $resultado = $this->notas_model->get($id_nota);
        else $resultado = $this->notas_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de notas", 400);
    }

    public function notas_post()
    {
        
        
        $data = array(
		'id_asignatura' => htmlspecialchars($this->post('id_asignatura')),
		'id_convocatoria' => htmlspecialchars($this->post('id_convocatoria')),
		'calificacion' => htmlspecialchars($this->post('calificacion')),
		'descripcion' => htmlspecialchars($this->post('descripcion')),
		'id_usuario' => htmlspecialchars($this->post('id_usuario'))
       );
        $resultado = $this->notas_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de notas",400);
    }

    public function notas_put($id_nota)
    {
        $data = array(
	    'id_asignatura' => htmlspecialchars($this->put('id_asignatura')),
	    'id_convocatoria' => htmlspecialchars($this->put('id_convocatoria')),
		'calificacion' => htmlspecialchars($this->put('calificacion')),
	    'descripcion' => htmlspecialchars($this->put('descripcion')),
	    'id_usuario' => htmlspecialchars($this->put('id_usuario'))
       );
        $resultado = $this->notas_model->update($id_nota,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de notas",400);
    }
    
    public function notas_delete($id_nota)
    {
        $resultado = $this->notas_model->delete($id_nota);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de notas',400);
    }
}
    