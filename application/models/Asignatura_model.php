<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Asignatura_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model("calificaciones_model");
    }

    public function get($id_asignatura = null){
        if($id_asignatura){
            $resultado = $this->db->query("SELECT * FROM asignatura WHERE id_asignatura = $id_asignatura");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM asignatura order by id_asignatura desc");
            return $resultado->result_array();
        }
    }

    public function getDatos($id_asignatura){
        $query = "SELECT * from asignatura where id_asignatura = $id_asignatura";
        $consulta = $this->db->query($query)->row_array();
        
        if(!$consulta) return null;
        
        $curso = $this->db->query("SELECT c.nombre FROM curso as c inner join asignatura as a on c.id_curso = a.id_curso where a.id_asignatura = $id_asignatura")->row_array()['nombre'];
        // Profesores que dan esa materia
        $profesores = $this->getProfesores($id_asignatura);
        
        $datos = array(
            'id_asignatura' => $id_asignatura,
            'nombre' => $consulta['nombre'],    
            'profesores' => $profesores,
            'curso' => $curso
        );
        return $datos;
    }
    
    //Profesores disponibles para dar la materia
    public function profesoresDisp($id_asignatura){
        return 
        $this->db
        ->query("SELECT id_usuario,nombre,apellido_paterno,apellido_materno from usuarios where id_usuario not in(SELECT id_profesor from profesores_materias as p where p.id_asignatura = $id_asignatura) and id_tipo_usuario = 2")      
        ->result_array();
    }

    // Obtiene los grupos que dan una materia
    public function getProfesores($id_asignatura){
        $profesores = $this->db
        ->query("SELECT id_profesores_materias,nombre,apellido_paterno,apellido_materno from usuarios as u inner join profesores_materias as p on u.id_usuario = p.id_profesor where p.id_asignatura = $id_asignatura")      
        ->result_array();

        $resultado = array();
        foreach ($profesores as $p) {
            $id_profesores_materias = $p['id_profesores_materias'];
            
            //Obetencion de los grupos en los que se dan es materia con cada profesor
            $grupos = $this->db->query(
                "SELECT id_profesores_materias_grupos,nombre from grupos natural join profesores_materias_grupos where id_profesores_materias = $id_profesores_materias"
                )->result_array();

            $resultado[] = array(
                'id_profesores_materias'  => $p['id_profesores_materias'],
                'nombre'  => $p['nombre'],
                'apellido_paterno'  => $p['apellido_paterno'],
                'apellido_materno'  => $p['apellido_materno'],
                'grupos' => $grupos
            );
        }
        return $resultado;
    }

    // Obtiene los grupos disponibles para el profesor de esa materia
    public function gruposAsignatura($id_profesores_materias){
        //Obtencion de la materia
        $q1 = $this->db->query("SELECT * from profesores_materias where id_profesores_materias = $id_profesores_materias")->row_array();
        $id_asignatura = $q1['id_asignatura'];
        $materia = $this->db->query("SELECT id_asignatura,nombre,id_curso from asignatura where id_asignatura = $id_asignatura")->row_array();
        //Obtencion del curso de la materia
        $id_curso = $materia['id_curso'];
        $grupos = $this->db->query("SELECT * from grupos where id_curso = $id_curso 
        and id_grupo not in (SELECT id_grupo from profesores_materias_grupos natural join profesores_materias where id_asignatura = $id_asignatura)")->result_array();

        return $grupos;   
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

    //Datos materia, grupos
    public function alumnosMateriaGrupo($id_grupo,$id_asignatura,$id_profesor){
      
        
        
        
        $convocatoriaArray = $this->db->query("SELECT * from convocatorias where activo = 1")->row_array();
        $convocatoriaActual = $convocatoriaArray['convocatoria'];
        $id_convocatoria = $convocatoriaArray['id_convocatoria'];

        $evaluaciones = $this->db->query("SELECT * from evaluaciones")->result_array();

       // $asignatura = $this->db->query("SELECT nombre,id_curso from asignatura where id_asignatura = $id_asignatura")
         //   ->row_array(); 
        $asignatura = 
            $this->db->select('nombre,id_curso')->from('asignatura')->where('id_asignatura',$id_asignatura)->get()
            ->row_array();

        $id_curso = $asignatura['id_curso'];
        $curso = $this->db->query("SELECT nombre from curso where id_curso = $id_curso")->row_array()['nombre'];

        $grupo = $this->db->query("SELECT * from grupos where id_grupo = $id_grupo")->row_array()['nombre'];
        

        //Obtenener alumnos y las calificaciones de cada evaluación de cada alumno
        $alumnos = $this->alumnos($id_grupo);
        $alumnosCalificados = array();

        // Guarda las evaluaciones disponibles para editar y la que es disponible para guardar
        // Es decir, si ya no ya se califacó las dos primeras evaluaciones 
        // Habrá 3 evaluaciones disponibles 2 para editar la califiación y 1 para asignar la calificación
        // Esto lo hará para el primer alumno de la materia, basta saber que evaluaciones tiene el primer alumno 
        // Ya que esto será lo mismo para los demás alumnos
        $evaluacionesDisponibles = array();
        $bandera = true;
        $bandera2 = true;
        $banderaEvalucionEditar = true;  // Desactiva la bandera para saber cuando se ha guardao evaluación para editar
        foreach ($alumnos as $a) {
            $id_alumno = $a['id_usuario'];
            $calificaciones = array();

            foreach($evaluaciones as $eval){
                $id_evaluacion = $eval['id_evaluacion'];

                $calificacion = $this->db->query("SELECT calificacion from calificaciones where 
                    id_asignatura = $id_asignatura and 
                    id_convocatoria = $id_convocatoria and 
                    id_grupo = $id_grupo and 
                    id_profesor = $id_profesor and 
                    id_alumno = $id_alumno and 
                    id_evaluacion = $id_evaluacion and 
                    id_curso = $id_curso 
                ")
                ->row_array()['calificacion'];


                // Solo checa las calificaciones del primer alumno
                if($bandera){
                    
                    if($bandera2){



                        // Si se cumple, ha encontrado la evaluación disponible para ingresar nuevas calificaciones y no editar
                        $evaluacionesDisponibles[] = $eval;
                        if(!$calificacion){
                           
                        
                    
                            // Agrega la ultima evaluación disponible y desactiva la bandera para no seguir
                         
                            $bandera2 = false;

                            // Si la lista tiene de tamaño 4, es porque la evaluación final está disponible
                            // La cual debe ser calificada automáticamente toma el promedio de las 3 evaluaciones parciales
                            $tamanio = sizeof($evaluacionesDisponibles);
                            if($tamanio == 4){
                                // Obtiene el promedio de las 3 evaluaciones pasadas para todos los alumnos del grupo de la materia
                               $primerAlumno = true;
                                foreach ($alumnos as $alumnosaux) {

                                    $id_alumnos_aux = $alumnosaux['id_usuario'];
                                    $promedio = $this->db->query("SELECT avg(calificacion) from calificaciones where 
                                    id_asignatura = $id_asignatura and 
                                    id_convocatoria = $id_convocatoria and 
                                    id_grupo = $id_grupo and 
                                    id_profesor = $id_profesor and 
                                    id_alumno = $id_alumnos_aux and 
                                    id_evaluacion in (1,2,3)  and 
                                    id_curso = $id_curso 
                                    ")
                                    ->row_array()['avg(calificacion)'];

                                    if($primerAlumno)$calificacion = $promedio;
                                    $primerAlumno = false;

                                    $registro = array(
                                        'id_asignatura' => $id_asignatura,
                                        'id_convocatoria' => $id_convocatoria,
                                        'id_grupo' => $id_grupo,
                                        'id_profesor' =>$id_profesor,
                                        'id_evaluacion' => 4,
                                        'id_alumno' => $id_alumnos_aux,
                                        'id_curso' => $id_curso,
                                        'calificacion' => $promedio
                                    );
                                    $this->db->set($registro)->insert('calificaciones');
                                    $this->mandarMensajesCalificaciones($registro,1);


                               }
                            }


                        } 
                    
                    }
                }
                

                if(!$calificacion) {
                    $calificacion = '';
                    
                }

                // Si no existe esa calificación, entonces esa evaluación no está disponible


                $calificaciones[$id_evaluacion] = array(
                    'id_evaluacion' => $eval['id_evaluacion'],
                    'nombre' => $eval['nombre'],
                    'calificacion' => floatval($calificacion)
                ); 
            }
            $alumnosCalificados[] = array(
                'id_usuario' => $id_alumno,
                'nombre' => $a['nombre'],
                'evaluaciones' => $calificaciones
            );
            $bandera = false;
        }

        // Calculo de los promedios de cada evaluación
        $evaluacionesDispConPromedios = array();
        foreach ($evaluacionesDisponibles as $evaluacion) {
            $id_evaluacion = $evaluacion['id_evaluacion'];

            $promedio = $this->db->query("SELECT avg(calificacion) 
                FROM calificaciones where 
                    id_asignatura = $id_asignatura and 
                    id_convocatoria = $id_convocatoria and 
                    id_grupo = $id_grupo and 
                    id_profesor = $id_profesor and
                    id_evaluacion = $id_evaluacion and 
                    id_curso = $id_curso 
            ")->row_array()['avg(calificacion)'];

            $evaluacionesDispConPromedios[] = array(
                'id_evaluacion' => $id_evaluacion,
                'nombre' => $evaluacion['nombre'],
                'promedio' => floatval($promedio)
            );
        }

        return array(
            'id_convocatoria' => $id_convocatoria,
            'convocatoria' => $convocatoriaActual,
            'asignatura'=> $asignatura['nombre'],
            'id_curso' => $id_curso,
            'curso'=> $curso,
            'grupo'=> $grupo,
            'evaluacionesDisponibles' => $evaluacionesDispConPromedios,
            'alumnos' => $alumnosCalificados
        );
    }


   

    //Obtiene los alumnos de un grupo
    public function alumnos($id_grupo){
        //Convocatoria actual
        $id_convocatoria = $this->db->query("SELECT * from convocatorias where activo = 1")->row_array()['id_convocatoria'];
        
        $alumnosArray = $this->db->query(
            "SELECT id_usuario,nombre,apellido_paterno,apellido_materno from usuarios where id_usuario in 
            (SELECT id_alumno from inscripciones where id_convocatoria = $id_convocatoria and id_grupo = $id_grupo) order by apellido_paterno asc"
        )->result_array();
        
        $alumnos = array();
        
        foreach ($alumnosArray as $a ) {
            $alumnos[] = array(
                'id_usuario' => $a['id_usuario'],
                'nombre' => $this->usuario_string($a)
            );
        }

        return $alumnos;
    }

    
    

    public function usuario_string($profesor){
        return $profesor['apellido_paterno']." ".$profesor['apellido_materno'].", ".$profesor['nombre'];
    }

    
    public function save($data){
        $this->db->set($data)->insert('asignatura');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_asignatura,$data){
        $this->db->set($data)->where('id_asignatura', $id_asignatura)->update('asignatura');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    } 

    public function delete($id_asignatura)
    {
        $this->db->where('id_asignatura', $id_asignatura)->delete('asignatura');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }

    public function getXcurso($id_curso){
        $resultado = $this->db->query("SELECT * FROM asignatura WHERE id_curso = $id_curso");
        return $resultado->result_array();
    }

    // Mandar mensaje a un alumno sombre su calificación.
    public function mandarMensajesCalificaciones($datos,$tipo){
        $id_asignatura = $datos['id_asignatura'];
	    $id_convocatoria = $datos['id_convocatoria'];
	    $id_grupo = $datos['id_grupo'];
        $id_profesor =$datos['id_profesor'];
        $id_evaluacion =$datos['id_evaluacion'];
        $id_alumno = $datos['id_alumno'];
        $calificacion = $datos['calificacion'];
        $id_curso = $datos['id_curso'];

        $curso = $this->db->select('nombre')->from('curso')->where('id_curso',$id_curso)
        ->get()->row_array()['nombre'];

        $asignatura = $this->db->select('nombre')->from('asignatura')->where('id_asignatura',$id_asignatura)
        ->get()->row_array()['nombre'];

        $convocatoria = $this->db->select('convocatoria')->from('convocatorias')->where('id_convocatoria',$id_convocatoria)
        ->get()->row_array()['convocatoria'];

        $grupo = $this->db->select('nombre')->from('grupos')->where('id_grupo',$id_grupo)
        ->get()->row_array()['nombre'];

        $profesorArray = $this->db->select('nombre,apellido_paterno,apellido_materno')
        ->from('usuarios')->where('id_usuario',$id_profesor)
        ->get()->row_array();

        $alumnoArray = $this->db->select('nombre,apellido_paterno,apellido_materno')
        ->from('usuarios')->where('id_usuario',$id_alumno)
        ->get()->row_array();
        
        $alumno = $this->usuario_string($alumnoArray);
        $profesor = $this->usuario_string($profesorArray);

        $evaluacion = $this->db->select('nombre')->from('evaluaciones')->where('id_evaluacion',$id_evaluacion)
        ->get()->row_array()['nombre'];

        $asunto = "Calificación ".$evaluacion;
        if($tipo == 1){
            $asunto = "Calificación ".$evaluacion.", ".$asignatura;
            $texto = "$convocatoria,\r\n
            Estimado alumno $alumno del curso $curso su calificación de la evaluación $evaluacion de la asignatura $asignatura es \r\n $calificacion.";
        }else{
            $asunto = "Actualización de calificación ";
            $texto = "$convocatoria,\r\n
            Estimado alumno $alumno del curso $curso su calificación de la evaluación $evaluacion de la asignatura $asignatura ha sido actualizada a \r\n $calificacion.";
        }
            $mensaje = array(
            'id_remitente' => 1,
            'id_destinatario' => $id_alumno,
            'asunto' => $asunto,
            'texto' => $texto,
            'id_prioridad' => 2,
            'leido' => 0,
            'fecha_hora' => (new \DateTime(null, new DateTimeZone('America/Mexico_City')))->format('Y-m-d H:i:s') 
        );

        $this->db->set($mensaje)->insert('mensajes');
        
    }
}