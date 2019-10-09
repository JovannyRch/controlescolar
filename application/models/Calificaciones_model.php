<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//By: JovannyRch

class Calificaciones_model extends CI_Model {

    public function get($id_calificacion = null){
        if($id_calificacion){
            $resultado = $this->db->query("SELECT * FROM calificaciones WHERE id_calificacion = $id_calificacion");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM calificaciones");
            return $resultado->result_array();
        }
    }

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
                echo "Nuevo registro";
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
        
        $alumno = $this->profesor_string($alumnoArray);
        $profesor = $this->profesor_string($profesorArray);

        $evaluacion = $this->db->select('nombre')->from('evaluaciones')->where('id_evaluacion',$id_evaluacion)
        ->get()->row_array()['nombre'];


        // Configura el mensaje de notificación
        
        if($tipo == 1){
            $asunto = "Calificación ".$evaluacion.", ".$asignatura;
            $texto = "$convocatoria,\r\n
            Estimado alumno $alumno del curso $curso su calificación de la evaluación $evaluacion de la asignatura $asignatura es \r\n $calificacion.";
        }else{
            $asunto = "Actualización de calificación ".$evaluacion.", ".$asignatura;
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


    public function profesor_string($profesor){
        return $profesor['apellido_paterno']." ".$profesor['apellido_materno'].", ".$profesor['nombre'];
    }

    public function update($id_calificacion,$data){
        $this->db->set($data)->where('id_calificacion', $id_calificacion)->update('calificaciones');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    } 

    public function delete($id_calificacion)
    {
        $this->db->where('id_calificacion', $id_calificacion)->delete('calificaciones');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }
}