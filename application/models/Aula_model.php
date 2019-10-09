
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Aula_model extends CI_Model {

    public function get($id_aula = null){
        if($id_aula){
            $resultado = $this->db->query("SELECT * FROM aula WHERE id_aula = $id_aula");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM aula");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('aula');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_aula,$data){
        $this->db->set($data)->where('id_aula', $id_aula)->update('aula');
        return true;
    } 

    public function delete($id_aula)
    {
        $this->db->where('id_aula', $id_aula)->delete('aula');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }
}
        