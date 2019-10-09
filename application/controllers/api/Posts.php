<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Posts extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("posts_model");
    }

    public function posts_get($id_post = null)
    {
        if($id_post) $resultado = $this->posts_model->get($id_post);
        else $resultado = $this->posts_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de posts", 400);
    }

    public function posts_post()
    {
        $data = array(
		'titulo' => $this->post('titulo'),
		'cuerpo' => $this->post('cuerpo'),
		'imagen' => $this->post('imagen')
       );
        $resultado = $this->posts_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de posts",400);
    }

    public function posts_put($id_post)
    {
        $data = array(
            'titulo' => $this->put('titulo'),
            'cuerpo' => $this->put('cuerpo'),
            'imagen' => $this->put('imagen')
       );
        $resultado = $this->posts_model->update($id_post,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de posts",400);
    }
    
    public function posts_delete($id_post)
    {
        $resultado = $this->posts_model->delete($id_post);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de posts',400);
    }
}
    