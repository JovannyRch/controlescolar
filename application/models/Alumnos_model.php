<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Alumnos_model extends CI_Model {

    public function verificarEntrada($datos){
		$datos = trim($datos);
		$datos = stripslashes($datos);
		$datos = htmlspecialchars($datos);
		return $datos;
	}

    public function cursoActual($id_alumno){
        //jovannyrch@gmail.com
        
        $query = "SELECT * FROM (SELECT * from inscripciones natural join convocatorias ) as q1 natural join curso where activo = 1 and id_alumno = $id_alumno";
        $consulta = $this->db->query($query)->row_array();
        if(!$consulta) return null;

        $id_grupo = $consulta['id_grupo'];
        //Obtencion del grupo al que pertenece
        $grupo = $this->db->query("SELECT * from grupos where id_grupo = $id_grupo")->row_array();

        //Obtención del aula
        $id_aula = $grupo['id_grupo'];
        $aula = $this->db->query("SELECT nombre from aula where id_aula = $id_aula")->row_array();

        //Obtención de las materias
        $id_curso = $consulta['id_curso'];
        $materias = $this->db->query("SELECT id_asignatura,nombre from asignatura where id_curso = $id_curso")->result_array();
        
        //Obteción del curso
        $curso = $this->db->query("SELECT nombre from curso where id_curso = $id_curso")->row_array()['nombre'];

        //Profesor de cada una de las materias
        $materiasProfesor = array();
        foreach ($materias as $m) {
            $id_asignatura = $m['id_asignatura'];
            
            $profesor = $this->getProfesor($id_asignatura,$id_grupo);
    
            if(!$profesor){
                $materiasProfesor[] = array(
                    'nombre' => $m['nombre'],
                    'profesor' => "No se ha asignado profesor para el grupo"
                );
            }

            else {
                $materiasProfesor[] = array(
                    'nombre' => $m['nombre'],
                    'profesor' => $this->usuario_string($profesor)
                );
            }
        }

        $datos = array(
            'convocatoria' =>  $consulta['convocatoria'],
            'grupo' => $grupo['nombre'],
            'aula' => $aula['nombre'],
            'curso' => $curso,
            'materias' => $materiasProfesor
         );      
        return $datos;
    }


    //Obtiene el profesor dado el grupo y la materia
    public function getProfesor($id_asignatura,$id_grupo){
        //jovannyrch@gmail.com
        $id_profesor = $this->db->query("SELECT id_profesor from profesores_materias natural join profesores_materias_grupos where id_grupo = $id_grupo and id_asignatura = $id_asignatura")
        ->row_array()['id_profesor'];
        if($id_profesor){
            return $this->db
            ->query("SELECT nombre,apellido_paterno,apellido_materno,id_usuario from usuarios where id_usuario = $id_profesor")
            ->row_array();
        }
        else return null;
    }

    public function usuario_string($usuario){
        return $usuario['apellido_paterno']." ".$usuario['apellido_materno'].", ".$usuario['nombre'];
    }

    //Obtener las calificaciones de un alumno por materias
    public function calificacionesPorCurso($id_alumno){
        
        //jovannyrch@gmail.com
        $query = "SELECT * FROM (SELECT * from inscripciones natural join convocatorias ) as q1 natural join curso where activo = 1 and id_alumno = $id_alumno";
        $consulta = $this->db->query($query)->row_array();
        if(!$consulta) return null;
        $id_convocatoria = $this->db->select('id_convocatoria')->from('convocatorias')->where('activo',1)->get()
        ->row_array()['id_convocatoria'];
        $id_grupo = $consulta['id_grupo'];
        //Obtencion del grupo al que pertenece
        $grupo = $this->db->query("SELECT * from grupos where id_grupo = $id_grupo")->row_array();

        //Obtención de las materias
        $id_curso = $consulta['id_curso'];
        $materias = $this->db->query("SELECT id_asignatura,nombre from asignatura where id_curso = $id_curso")->result_array();
        
       
        //Profesor de cada una de las materias
        $materiasProfesor = array();
        foreach ($materias as $m) {
            $id_asignatura = $m['id_asignatura'];
            $profesor = $this->getProfesor($id_asignatura,$id_grupo);
        
            $id_profesor = $profesor['id_usuario'];

            if($id_profesor){
               
                // Solo se toma en cuenta la califición de la evaluación final
                $id_evaluacion = 4;
                

                $materiasProfesor[] = array(
                    'id_profesor' => $id_profesor,
                    'id_asignatura' =>$id_asignatura
                );
            }
        }

        $datos = array(
            'id_convocatoria' =>  $id_convocatoria,
            'id_grupo' => $id_grupo,
            'id_curso' => $id_curso,
            'id_alumno' => $id_alumno,
            'materias' => $materiasProfesor
         );      
        return $datos;
    }

    // Obtener las calificaciones del alumno
    public function calificacionesAlumno($id_alumno){
        //jovannyrch@gmail.com
        $query = "SELECT * FROM (SELECT * from inscripciones natural join convocatorias ) as q1 natural join curso where activo = 1 and id_alumno = $id_alumno";
        $consulta = $this->db->query($query)->row_array();
        if(!$consulta) return null;

        $id_grupo = $consulta['id_grupo'];
        //Obtencion del grupo al que pertenece
        $grupo = $this->db->query("SELECT * from grupos where id_grupo = $id_grupo")->row_array();

        //Obtención del aula
        $id_aula = $grupo['id_grupo'];
        $aula = $this->db->query("SELECT nombre from aula where id_aula = $id_aula")->row_array();

        //Obtención de las materias
        $id_curso = $consulta['id_curso'];
        $materias = $this->db->query("SELECT nombre,id_asignatura from asignatura where id_curso = $id_curso")->result_array();
        
        $arrayMaterias = array();
        

        $evaluaciones = $this->db->query("SELECT * from evaluaciones limit 4")->result_array();
         // Otencion de promedios por cada materia
        foreach ($materias as $m) {
            $arrayMaterias[] = $m['nombre'];
        }

        $id_convocatoria = $this->db->select('id_convocatoria')->from('convocatorias')->where('activo',1)->get()
        ->row_array()['id_convocatoria'];

        $arrayPromedioMaterias = array();
        foreach ($evaluaciones as $eval) {
            $id_evaluacion = $eval['id_evaluacion'];

            $calificaciones = array();
            foreach ($materias as $m) {
                $id_asignatura = $m['id_asignatura'];
                $calificacion = $this->db->query("SELECT calificacion 
                FROM calificaciones where 
                    id_asignatura = $id_asignatura and 
                    id_convocatoria = $id_convocatoria and 
                    id_evaluacion = $id_evaluacion and 
                    id_alumno = $id_alumno
                ")->row_array()['calificacion'];

                if(!$calificacion && $id_evaluacion == 4){
                    $calificacion = $this->db->query("SELECT calificacion 
                    FROM calificaciones where 
                        id_asignatura = $id_asignatura and 
                        id_convocatoria = $id_convocatoria and 
                        id_evaluacion in (1,2,3) and 
                        id_alumno = $id_alumno
                    ")->row_array()['calificacion'];
                }

                $calificaciones[] = floatval($calificacion);
            }
            if($id_evaluacion != 4){
                $arrayPromedioMaterias[] = array(
                    'type' => 'column',
                    'name' => $eval['nombre'],
                    'data' => $calificaciones
                 );
            }else{
                $arrayPromedioMaterias[] = array(
                    'type' => 'spline',
                    'name' => 'Promedio',
                    'data' => $calificaciones,
                    'marker' => array(
                        'lineWidth' => 2,
                        'fillColor' => 'black'
                    )
                 );
               
            }
        }
        
        //Obteción del curso
        $curso = $this->db->query("SELECT nombre from curso where id_curso = $id_curso")->row_array()['nombre'];

        //Profesor de cada una de las materias
        $materiasProfesor = array();
        
        $alumno = $this->db->query("SELECT nombre,apellido_paterno,apellido_materno from usuarios where id_usuario = $id_alumno")->row_array();
        

        $calificacionPromedioCurso = $this->db->query("SELECT avg(calificacion) 
        FROM calificaciones where 
            id_convocatoria = $id_convocatoria and 
            id_evaluacion in (1,2,3) and 
            id_curso = $id_curso and
            id_alumno = $id_alumno
        ")->row_array()['avg(calificacion)']; 
       
       

        $datos = array(
            'convocatoria' =>  $consulta['convocatoria'],
            'alumno' => $this->usuario_string($alumno),
            'grupo' => $grupo['nombre'],
            'promedioCurso' => number_format($calificacionPromedioCurso."",2),
            'aula' => $aula['nombre'],
            'curso' => $curso,
            'materias' => $arrayMaterias,
            'calificaciones' => $arrayPromedioMaterias
         );       
        return $datos;
    }

    //Busqueda de alumnos por nombre, matricula
    public function busqueda(){
        //jovannyrch@gmail.com
        $resultados = $this->db->query("SELECT ");
    }



    /*
    
    public function calificacionesPorCurso($id_alumno){
        
        $query = "SELECT * FROM (SELECT * from inscripciones natural join convocatorias ) as q1 natural join curso where activo = 1 and id_alumno = $id_alumno";
        $consulta = $this->db->query($query)->row_array();
        if(!$consulta) return null;
        $id_convocatoria = $this->db->select('id_convocatoria')->from('convocatorias')->where('activo',1)->get()
        ->row_array()['id_convocatoria'];
        $id_grupo = $consulta['id_grupo'];
        //Obtencion del grupo al que pertenece
        $grupo = $this->db->query("SELECT * from grupos where id_grupo = $id_grupo")->row_array();

        //Obtención de las materias
        $id_curso = $consulta['id_curso'];
        $materias = $this->db->query("SELECT id_asignatura,nombre from asignatura where id_curso = $id_curso")->result_array();
        
       
        //Profesor de cada una de las materias
        $materiasProfesor = array();
        foreach ($materias as $m) {
            $id_asignatura = $m['id_asignatura'];
            $profesor = $this->getProfesor($id_asignatura,$id_grupo);
        
            $id_profesor = $profesor['id_usuario'];

            if($id_profesor){
                $materiasProfesor[] = array(
                    'id_profesor' => $id_profesor,
                    'id_asignatura' =>$id_asignatura
                );

                // Solo
            }
        }

        $datos = array(
            'id_convocatoria' =>  $id_convocatoria,
            'id_grupo' => $id_grupo,
            'id_curso' => $id_curso,
            'id_alumno' => $id_alumno,
            'materias' => $materiasProfesor
         );      
        return $datos;
    }

    */
}