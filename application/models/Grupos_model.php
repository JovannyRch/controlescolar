
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Grupos_model extends CI_Model {

    public function get($id_grupo = null){
        if($id_grupo){
            $resultado = $this->db->query("SELECT * FROM grupos WHERE id_grupo = $id_grupo");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM grupos order by nombre desc");
            return $resultado->result_array();
        }
    }

    public function getXcurso($id_curso){
        $resultado = $this->db->query("SELECT * FROM grupos WHERE id_curso = $id_curso");
        return $resultado->result_array();
    }

    public function save($data){
        $this->db->set($data)->insert('grupos');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_grupo,$data){
        $this->db->set($data)->where('id_grupo', $id_grupo)->update('grupos');
        return true;
    } 

    public function delete($id_grupo)
    {
        $this->db->where('id_grupo', $id_grupo)->delete('grupos');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }
}
        