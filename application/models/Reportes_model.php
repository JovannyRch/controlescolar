
<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//By: JovannyRch

class Reportes_model extends CI_Model {

    
    public function save($data){
        $alumnos = $data['alumnos'];
        foreach ($alumnos as $a) {
            $id_alumno = $a['id_usuario'];
            $calificacion = $a['evaluaciones'][$data['id_evaluacion']]['calificacion'];
            
            $id_asignatura = $data['id_asignatura'];
            $id_convocatoria = $data['id_convocatoria'];
            $id_grupo = $data['id_grupo'];
            $id_profesor = $data['id_profesor'];
            $id_evaluacion = $data['id_evaluacion'];
            $id_alumno = $a['id_usuario'];
            $id_curso = $data['id_curso'];
        
            //Validar si se trata de actualización o nueva calificación
            $busqueda = $this->db->query("SELECT id_calificacion,calificacion from calificaciones where 
                id_asignatura = $id_asignatura and 
                id_convocatoria = $id_convocatoria and 
                id_grupo = $id_grupo and 
                id_profesor = $id_profesor and 
                id_alumno = $id_alumno and 
                id_evaluacion = $id_evaluacion and 
                id_curso = $id_curso 
            ")
            ->row_array();

            $registro = array(
                'id_asignatura' => $data['id_asignatura'],
                'id_convocatoria' => $data['id_convocatoria'],
                'id_grupo' => $data['id_grupo'],
                'id_profesor' =>$data['id_profesor'],
                'id_evaluacion' =>$data['id_evaluacion'],
                'id_alumno' => $id_alumno,
                'id_curso' => $data['id_curso'],
                'calificacion' => $calificacion
            );
            //Nueva calificación
            if(!isset($busqueda['id_calificacion'])){
                $this->db->set($registro)->insert('calificaciones');
                $this->mandarMensajesCalificaciones($registro,1);
            }else{
               //Edición de calificación
               $id_calificacion = $busqueda['id_calificacion'];
               if(floatval($busqueda['calificacion']) != floatval($calificacion)){
                    $nuevaCalificacion = array('calificacion',$calificacion);
                    $this->db->query("UPDATE calificaciones set calificacion = $calificacion where id_calificacion = $id_calificacion");
                    $this->mandarMensajesCalificaciones($registro,2);
               }
            }
        }

        

        if ($this->db->affected_rows() >= 1) return true;
        return null;
       
    }

    // Reportes por grupo por alumnos
    public function grupo($id_grupo){
        /*$busqueda = $this->db->query("SELECT id_calificacion,calificacion from calificaciones where 
            id_asignatura = $id_asignatura and 
            id_convocatoria = $id_convocatoria and 
            id_grupo = $id_grupo and 
            id_profesor = $id_profesor and 
            id_alumno = $id_alumno and 
            id_evaluacion = $id_evaluacion and 
            id_curso = $id_curso 
        ")
        ->row_array();*/

        $grupo = $this->db->query("SELECT nombre from grupos where id_grupo = $id_grupo")->row_array()['nombre'];
        $convocatoriaArray = $this->db->query("SELECT * from convocatorias where activo = 1")->row_array();
        $convocatoriaActual = $convocatoriaArray['convocatoria'];
        $id_convocatoria = $convocatoriaArray['id_convocatoria'];

        $alumnos = $this->db->query(" SELECT id_usuario,nombre, apellido_paterno, apellido_materno
            from usuarios where id_usuario in (SELECT id_alumno from inscripciones where id_grupo = $id_grupo and 
             id_convocatoria = $id_convocatoria) order by apellido_paterno
        ")->result_array();

        if(sizeof($alumnos) == 0) return null;
        

        $alumnosArrayString = array();
        $calificaciones = array();
        foreach ($alumnos as $a) {
            $id_usuario = $a['id_usuario'];
            

            $calificacion = $this->db->query("SELECT avg(calificacion) from calificaciones where 
            id_convocatoria = $id_convocatoria and 
            id_grupo = $id_grupo and 
            id_evaluacion in (1,2,3) and
            id_alumno = $id_usuario
        ")
        ->row_array()['avg(calificacion)'];
        
            $calificaciones[] = floatval(number_format($calificacion,2));
            $alumnosArrayString[] = $this->usuario_string($a);
        }
        
        $promGrupo = $this->db->query("SELECT avg(calificacion) from calificaciones where 
            id_convocatoria = $id_convocatoria and 
            id_grupo = $id_grupo and 
            id_evaluacion in (1,2,3)
        ")
        ->row_array()['avg(calificacion)'];


        return array(
            'grupo' => $grupo,
            'convocatoria' => $convocatoriaActual,
            'cantidadAlumnos' => sizeof($alumnos),
            'alumnos' => $alumnosArrayString,
            'calificaciones' => $calificaciones,
            'promedioGrupo' => floatval(number_format($promGrupo,2)) 
        );
    }

    // Reportes por grupo por materias
    public function grupoMaterias($id_grupo){

        $grupo = $this->db->query("SELECT nombre,id_curso from grupos where id_grupo = $id_grupo")->row_array();
        $convocatoriaArray = $this->db->query("SELECT * from convocatorias where activo = 1")->row_array();
        $convocatoriaActual = $convocatoriaArray['convocatoria'];
        $id_convocatoria = $convocatoriaArray['id_convocatoria'];

        // Obtencion de las materias
        $id_curso = $grupo['id_curso'];
        $materias = $this->db->query("SELECT * from asignatura where id_curso = $id_curso")->result_array();
        

        if(sizeof($materias) == 0) return null;
        


        $materiasString = array();
        $calificaciones = array();
        foreach ($materias as $m) {
            $id_asignatura = $m['id_asignatura'];

            $calificacion = $this->db->query("SELECT avg(calificacion) from calificaciones where 
            id_convocatoria = $id_convocatoria and 
            id_grupo = $id_grupo and
            id_evaluacion in (1,2,3) and
            id_asignatura = $id_asignatura
        ")
        ->row_array()['avg(calificacion)'];
        
        
            $calificaciones[] = floatval(number_format($calificacion,2));
            $materiasString[] = $m['nombre'];
        }
        
        $promGrupo = $this->db->query("SELECT avg(calificacion) from calificaciones where 
            id_convocatoria = $id_convocatoria and 
            id_grupo = $id_grupo and 
            id_evaluacion in (1,2,3) 
        ")
        ->row_array()['avg(calificacion)'];

     
        

        return array(
            'grupo' => $grupo['nombre'],
            'convocatoria' => $convocatoriaActual,
            'cantidad' => sizeof($calificaciones),
            'materias' => $materiasString,
            'calificaciones' => $calificaciones,
            'promedioGrupo' => floatval(number_format($promGrupo,2))
        );
    }

    // Reporte de profesores materia
    public function profesorMateria($id_profesor){
        $query1 = $this->getXProfesor($id_profesor);
        $materias = $query1['asignaturas'];

        if(sizeof($materias) == 0) return null;

        $convocatoriaArray = $this->db->query("SELECT * from convocatorias where activo = 1")->row_array();
        $convocatoriaActual = $convocatoriaArray['convocatoria'];
        $id_convocatoria = $convocatoriaArray['id_convocatoria'];

        $calificaciones = array();
        $materiasString = array();

        $resultado = array();
        foreach ($materias as $m ) {
            $id_asignatura = $m['id_asignatura'];
            
            $calificacion = $this->db->query("SELECT avg(calificacion) from calificaciones where 
            id_convocatoria = $id_convocatoria and 
            id_profesor = $id_profesor and
            id_evaluacion in (1,2,3) and
            id_asignatura = $id_asignatura
        ")
        ->row_array()['avg(calificacion)'];

            $calificaciones[] = floatval(number_format($calificacion,2));
            $materiasString[] = $m['asignatura'];



        }


        $promedioProfesor = $this->db->query("SELECT avg(calificacion) from calificaciones where 
            id_convocatoria = $id_convocatoria and 
            id_profesor = $id_profesor and
            id_evaluacion in (1,2,3)
        ")
        ->row_array()['avg(calificacion)'];

        return array(
            'convocatoria' => $query1['convocatoria'],
            'profesor' => $query1['nombre'],
            'promedioProfesor' =>  floatval(number_format($promedioProfesor,2)),
            'asignaturas' => $materiasString,
            'promedios' => $calificaciones,
            'cantidad' => sizeof($materiasString)
        );
    }


    //Obtiene las materias de cada profesor
    public function getXProfesor($id_profesor){


        //Asignturas que da el profesor
        $asignaturasP = $this->db->query(
            "SELECT a.id_asignatura,a.nombre from profesores_materias as pm inner join 
        asignatura as a on a.id_asignatura = pm.id_asignatura
        where pm.id_profesor = $id_profesor order by a.id_curso, a.nombre")
        ->result_array();

        $asignaturas = array();
        $convocatoria = $this->db->query("SELECT * from convocatorias where activo = 1")->row_array();
        $materias = array();
        foreach ($asignaturasP as $a) {
            
            $id_asignatura = $a['id_asignatura'];
            $asignatura = $this->db->query("SELECT nombre,id_curso from asignatura where id_asignatura = $id_asignatura")
            ->row_array();
            
            $id_curso = $asignatura['id_curso'];
            $curso = $this->db->query("SELECT nombre from curso where id_curso = $id_curso")->row_array()['nombre'];

            $asignaturaXgrupo = $this->db->query(
                "SELECT id_grupo,id_profesores_materias_grupos from profesores_materias natural join
                 profesores_materias_grupos where id_asignatura = $id_asignatura and id_profesor = $id_profesor 
                ")->result_array();
            $grupos = array();
            foreach ($asignaturaXgrupo as $a) {
                $id_grupo = $a['id_grupo'];
                $grupo = $this->db->query("SELECT * from grupos where id_grupo = $id_grupo")->row_array();
                
                $id_aula = $grupo['id_aula'];
                $aula = $this->db->query("SELECT nombre from aula where id_aula = $id_aula")->row_array()['nombre'];
                
                $grupos[] = array(
                    'id_grupo' => $id_grupo,
                    'grupo' => $grupo['nombre'],
                    'aula' => $aula
                );
    
            }
            $asignaturas[] = array(
                'asignatura' => $asignatura['nombre'],
                'id_asignatura' => $id_asignatura,
                'curso' => $curso,
                'grupos' => $grupos
            );
        }

        $profesorArray = $this->db->query("SELECT * from usuarios where id_usuario = $id_profesor")

        ->row_array();


        return array(
            'nombre' => $this->usuario_string($profesorArray),
            'convocatoria' => $convocatoria['convocatoria'],
            'asignaturas' => $asignaturas
        );
    } 
    

    public function general(){
        
        
        $profesores = $this->db->query("SELECT count(id_usuario) from usuarios where id_tipo_usuario = 2")->row_array()['count(id_usuario)'];
        $padres = $this->db->query("SELECT count(id_usuario) from usuarios where id_tipo_usuario = 3")->row_array()['count(id_usuario)'];
        $alumnos = $this->db->query("SELECT count(id_usuario) from usuarios where id_tipo_usuario = 4")->row_array()['count(id_usuario)'];

        $usuarios = $this->db->query("SELECT count(id_usuario) from usuarios")->row_array()['count(id_usuario)'];

        $mensajes = $this->db->query("SELECT count(id_mensaje) from mensajes")->row_array()['count(id_mensaje)'];
        $mensajesNoLeidos = $this->db->query("SELECT count(id_mensaje) from mensajes where leido = 0")->row_array()['count(id_mensaje)'];
        $mensajesLeidos = $this->db->query("SELECT count(id_mensaje) from mensajes where leido = 1")->row_array()['count(id_mensaje)'];



        $cursos = $this->db->query("SELECT count(id_curso) from curso ")->row_array()['count(id_curso)'];
        $calificaciones = $this->db->query("SELECT count(id_calificacion) from calificaciones ")->row_array()['count(id_calificacion)'];
        $publicaciones =  $this->db->query("SELECT count(id_post) from posts ")->row_array()['count(id_post)'];

        $aulas = $this->db->query("SELECT count(id_aula) from aula ")->row_array()['count(id_aula)'];

        $grupos = $this->db->query("SELECT count(id_grupo) from grupos ")->row_array()['count(id_grupo)'];
        $asignaturas = $this->db->query("SELECT count(id_asignatura) from asignatura ")->row_array()['count(id_asignatura)'];

        $calificacionGlobal = $this->db->query(" SELECT avg(calificacion) from calificaciones where 
        id_evaluacion in (1,2,3)
        ")->row_array()['avg(calificacion)'];

        return array(
            'padres' => intval($padres),
            'profesores' => intval($profesores),
            'alumnos' => intval($alumnos),
            'usuarios' => intval($usuarios),
            'cursos' => intval($cursos),  
            'mensajes' => intval($mensajes),
            'mensajesLeidos' => intval($mensajesLeidos),
            'mensajesNoLeidos' => intval($mensajesNoLeidos),
            'calificaciones' => intval($calificaciones),
            'publicaciones' => intval($publicaciones),
            'aulas' => intval($aulas),
            'grupos' => intval($grupos),
            'asignaturas' => intval($asignaturas),
            'promedio' => floatval($calificacionGlobal)
        );
    }

    public function usuario_string($usuario){
        return $usuario['apellido_paterno']." ".$usuario['apellido_materno'].", ".$usuario['nombre'];
    }
    //      >
    public function materias(){
        //Obtenemos todas la asignaturas de la BDs
        $asignaturas = $this->db->query("SELECT id_asignatura, nombre from asignatura")->result_array();
        $evaluaciones = $this->db->query("SELECT * from evaluaciones")->result_array();

        $resultado = array();
        
        $asignaturasArray = [];
        foreach ($asignaturas as $asignatura) {
            $asignaturasArray[] = $asignatura['nombre'];
        }   
        
        foreach ($evaluaciones as $evaluacion){
            $id_evaluacion = $evaluacion['id_evaluacion'];
            $evaluacionNombre = $evaluacion['nombre'];

            $calificacionesXmateria = array();
            foreach ($asignaturas as $asignatura) {
                $id_asignatura = $asignatura['id_asignatura'];

                $promedio = $this->db->query("SELECT avg(calificacion) from calificaciones where 
                    id_evaluacion = $id_evaluacion and id_asignatura = $id_asignatura
                    ")->row_array()['avg(calificacion)'];
                if(!$promedio) $promedio = 0; 
                else $promedio = floatval($promedio); 

                $calificacionesXmateria[] = $promedio;
            }

            $resultado[]  = array(
                'name' =>$evaluacionNombre,
                'data' => $calificacionesXmateria
            );
        }

        /*
        foreach ($asignaturas as $asignatura) {
            $id_asignatura = $asignatura['id_asignatura'];
            $nombre = $asignatura['nombre'];

            $promediosXEvaluacion = array();
            // Obtención de calificaciones por evaluación
            foreach ($evaluaciones as $evaluacion) {
                $id_evaluacion = $evaluacion['id_evaluacion'];

                $promedio = $this->db->query("SELECT avg(calificacion) from calificaciones where 
                    id_evaluacion = $id_evaluacion and id_asignatura = $id_asignatura
                    ")->row_array()['avg(calificacion)'];
                if(!$promedio) $promedio = 0; 
                else $promedio = floatval($promedio); 
                $promediosXEvaluacion[] = $promedio;
            }  
            $resultado[] = array(
                'name' => $nombre,
                'data'  => $promediosXEvaluacion
            );
        }*/


        return array(
            'asignaturas' => $asignaturasArray,
            'evaluaciones' => $resultado
        );

    }
}
