
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Prioridad_model extends CI_Model {

    public function get($id_prioridad = null){
        if($id_prioridad){
            $resultado = $this->db->query("SELECT * FROM prioridad WHERE id_prioridad = $id_prioridad");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM prioridad");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('prioridad');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_prioridad,$data){
        $this->db->set($data)->where('id_prioridad', $id_prioridad)->update('prioridad');
        return true;
    } 

    public function delete($id_prioridad)
    {
        $this->db->where('id_prioridad', $id_prioridad)->delete('prioridad');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }
}
        