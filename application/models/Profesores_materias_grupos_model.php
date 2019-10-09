
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Profesores_materias_grupos_model extends CI_Model {

    public function get($id = null){
        if($id){
            $resultado = $this->db->query("SELECT * FROM profesores_materias_grupos WHERE id = $id");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM profesores_materias_grupos");
            return $resultado->result_array();
        }
    }

    public function getXprofesor($id_profesor){
        $resultado = $this->db->query("SELECT * FROM profesores_materias_grupos WHERE id_profesor= $id_profesor");
        if($resultado->num_rows() > 0) return $resultado->result_array();
        return false;
    }

    public function save($data){
        $this->db->set($data)->insert('profesores_materias_grupos');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id,$data){
        $this->db->set($data)->where('id', $id)->update('profesores_materias_grupos');
        return true;
    } 

    public function delete($id)
    {
        echo $id;
        $this->db->where('id_profesores_materias_grupos', $id)->delete('profesores_materias_grupos');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }


}
        