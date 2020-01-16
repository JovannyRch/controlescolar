
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Cursos_materias_model extends CI_Model {

    public function get($id = null){
        if($id){
            $resultado = $this->db->query("SELECT * FROM cursos_materias WHERE id = $id");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM cursos_materias");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('cursos_materias');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id,$data){
        $this->db->set($data)->where('id', $id)->update('cursos_materias');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    } 

    public function delete($id)
    {
        $this->db->where('id', $id)->delete('cursos_materias');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }
}
        