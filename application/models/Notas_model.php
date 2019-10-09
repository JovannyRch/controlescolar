
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Notas_model extends CI_Model {

    public function get($id_nota = null){
        if($id_nota){
            $resultado = $this->db->query("SELECT * FROM notas2 WHERE id_nota = $id_nota");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM notas2");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('notas2');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_nota,$data){
        $this->db->set($data)->where('id_nota', $id_nota)->update('notas2');
        return true;
    } 

    public function delete($id_nota)
    {
        $this->db->where('id_nota', $id_nota)->delete('notas2');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }
}
        