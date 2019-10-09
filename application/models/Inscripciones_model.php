
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Inscripciones_model extends CI_Model {

    public function get($id_inscripcion = null){
        if($id_inscripcion){
            $resultado = $this->db->query("SELECT * FROM inscripciones WHERE id_inscripcion = $id_inscripcion");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM inscripciones");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('inscripciones');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_inscripcion,$data){
        $this->db->set($data)->where('id_inscripcion', $id_inscripcion)->update('inscripciones');
        return true;
    } 

    public function delete($id_inscripcion)
    {
        $this->db->where('id_inscripcion', $id_inscripcion)->delete('inscripciones');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }

    public function validarInscripcion($id_convocatoria, $id_alumno){
        $query = "SELECT * FROM inscripciones WHERE id_convocatoria = $id_convocatoria and id_alumno = $id_alumno";
        $resultado = $this->db->query($query);
        if($resultado->num_rows() == 0) return true;
        return false;
    }
}
        