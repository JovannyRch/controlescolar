<?php
//REST_Controller
require_once APPPATH.'/libraries/REST_Controller.php';
//By: JovannyRch
class Asignatura extends REST_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model("asignatura_model");
    }

    public function asignatura_get($id_asignatura = null)
    {
        if($id_asignatura) $resultado = $this->asignatura_model->get($id_asignatura);
        else $resultado = $this->asignatura_model->get();
        if($resultado)$this->response($resultado, 200);
        else $this->response("Error en el get de asignatura", 400);
    }

    public function profesoresDisp_get($id_asignatura){
        $resultado = $this->asignatura_model->profesoresDisp($id_asignatura);
        $this->response($resultado, 200);
    }

    public function profesoresActivos_get($id_asignatura){
        $resultado = $this->asignatura_model->getProfesores($id_asignatura);
        $this->response($resultado, 200);
    }

    // Obtiene los grupos disponibles para una materia con un profesor
    public function gruposAsignatura_get($id_profesores_materias){
        $resultado = $this->asignatura_model->gruposAsignatura($id_profesores_materias);
        $this->response($resultado, 200);
    }

    // Post
    public function verificarEntrada($datos){
		$datos = trim($datos);
		$datos = stripslashes($datos);
		$datos = htmlspecialchars($datos);
		return $datos;
    }
    
    public function asignatura_post()
    {
        $data = array(
		'id_curso' => $this->verificarEntrada($this->post('id_curso')),
		'nombre' => $this->verificarEntrada($this->post('nombre')),
		'descripcion' => $this->verificarEntrada($this->post('descripcion'))
       );
        $resultado = $this->asignatura_model->save($data);
        if($resultado) $this->response('Guardado con éxito',200);
        else $this->response("Error en el post de asignatura",400);
    }

    public function asignatura_put($id_asignatura)
    {
        $data = array(
	    'id_curso' => $this->put('id_curso'),
	    'nombre' => $this->put('nombre'),
	    'descripcion' => $this->put('descripcion')
       );
        $resultado = $this->asignatura_model->update($id_asignatura,$data);
        if($resultado) $this->response('Moficado con éxito',200);
        else  $this->response("Error en el post de asignatura",400);
    }
    
    public function asignatura_delete($id_asignatura)
    {
        $resultado = $this->asignatura_model->delete($id_asignatura);
        if($resultado) $this->response('Eliminado con éxito',200);
        else $this->response('Error en el delete de asignatura',400);
    }

    public function asignaturaXcurso_get($id_curso){
        $resultado = $this->asignatura_model->getXcurso($id_curso);
        $this->response($resultado, 200);
    }

    //Obtener los datos de un profesor
    public function materiasProfesor_get($id_profesor){
        $this->response(
            $this->asignatura_model->getXProfesor($id_profesor)
            ,200
        );
    }

    //Obtiene los alumnos de un grupo 
    public function alumnos_get($id_grupo,$id_asignatura,$id_profesor){
        $this->response(
            $this->asignatura_model->alumnosMateriaGrupo($id_grupo,$id_asignatura,$id_profesor)
            ,200
        );
    }

}
    