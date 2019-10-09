
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Asignaturas_usuario_model extends CI_Model {

    public function get($id_asignaturas_usuario = null){
        if($id_asignaturas_usuario){
            $resultado = $this->db->query("SELECT * FROM asignaturas_usuario WHERE id_asignaturas_usuario = $id_asignaturas_usuario");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM asignaturas_usuario");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('asignaturas_usuario');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_asignaturas_usuario,$data){
        $this->db->set($data)->where('id_asignaturas_usuario', $id_asignaturas_usuario)->update('asignaturas_usuario');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    } 

    public function delete($id_asignaturas_usuario)
    {
        $this->db->where('id_asignaturas_usuario', $id_asignaturas_usuario)->delete('asignaturas_usuario');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }
}