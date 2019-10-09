
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Hijos_model extends CI_Model {

    public function get($id_hijos = null){
        if($id_hijos){
            $resultado = $this->db->query("SELECT * FROM hijos WHERE id_hijos = $id_hijos");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM hijos");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('hijos');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_hijos,$data){
        $this->db->set($data)->where('id_hijos', $id_hijos)->update('hijos');
        return true;
    } 

    public function delete($id_hijos)
    {
        $this->db->where('id_hijos', $id_hijos)->delete('hijos');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }
}
        