
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Alumnos_grupos_model extends CI_Model {

    public function get($id = null){
        if($id){
            $resultado = $this->db->query("SELECT * FROM alumnos_grupos WHERE id = $id");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM alumnos_grupos");
            return $resultado->result_array();
        }
    }

    public function save($data){
        
        // Get convocatoria actual
        // FIXME Si no hay convocatoria actual, mandar error
        // TODO Validar que no se repita el registro del alumno en el grupo
        $convocatoria_actual = $this->db->query("SELECT id_convocatoria from convocatorias where activo = 1")->row_array()['id_convocatoria'];
        $data['id_convocatoria'] = $convocatoria_actual;
        $this->db->set($data)->insert('alumnos_grupos');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id,$data){
        $this->db->set($data)->where('id', $id)->update('alumnos_grupos');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    } 

    public function delete($id)
    {
        $this->db->where('id', $id)->delete('alumnos_grupos');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }



      public function get_alumnos($id_grupo){
        $alumnos = $this->db->query("SELECT alumnos.*,alumnos_grupos.id id_ag from alumnos inner join alumnos_grupos where alumnos.id_usuario = alumnos_grupos.id_alumno and alumnos_grupos.id_grupo = $id_grupo");
        return $alumnos->result_array();
    }
}
        