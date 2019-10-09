
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Usuario_acceso_model extends CI_Model {

    public function get($id_usuario_acceso = null){
        if($id_usuario_acceso){
            $resultado = $this->db->query("SELECT * FROM usuario_acceso WHERE id_usuario_acceso = $id_usuario_acceso");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM usuario_acceso");
            return $resultado->result_array();
        }
    }

    public function getByUser($id_usuario){
        $resultado = $this->db->query("SELECT * FROM usuario_acceso WHERE id_usuario = $id_usuario");
        if($resultado->num_rows() > 0) {
            $resultado = $resultado->row_array();
            return $resultado;

        }
        return false;
    }

    public function save($data){
        $this->db->set($data)->insert('usuario_acceso');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_usuario_acceso,$data){
        $this->db->set($data)->where('id_usuario_acceso', $id_usuario_acceso)->update('usuario_acceso');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    } 

    public function delete($id_usuario_acceso)
    {
        $this->db->where('id_usuario_acceso', $id_usuario_acceso)->delete('usuario_acceso');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }
}
        