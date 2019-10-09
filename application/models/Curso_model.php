
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Curso_model extends CI_Model {

    public function get($id_curso = null){
        if($id_curso){
            $resultado = $this->db->query("SELECT * FROM curso WHERE id_curso = $id_curso");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM curso");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('curso');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_curso,$data){
        $this->db->set($data)->where('id_curso', $id_curso)->update('curso');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    } 

    public function delete($id_curso)
    {
        $this->db->where('id_curso', $id_curso)->delete('curso');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }
}