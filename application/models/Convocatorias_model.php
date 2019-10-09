
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Convocatorias_model extends CI_Model {

    public function get($id_convocatoria = null){
        if($id_convocatoria){
            $resultado = $this->db->query("SELECT * FROM convocatorias WHERE id_convocatoria = $id_convocatoria");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM convocatorias");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('convocatorias');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_convocatoria,$data){
        $this->db->set($data)->where('id_convocatoria', $id_convocatoria)->update('convocatorias');
        return true;
    } 

    public function delete($id_convocatoria)
    {
        $this->db->where('id_convocatoria', $id_convocatoria)->delete('convocatorias');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }

    public function activar($id_convocatoria){
        $query = "UPDATE convocatorias SET activo = 0 WHERE activo = 1";
        $this->db->query($query);
        $query = "UPDATE convocatorias SET activo = 1 WHERE id_convocatoria = $id_convocatoria";
        $this->db->query($query);
    }

    public function getActual(){
        $query = "SELECT * FROM convocatorias WHERE activo = 1";
        $resultado = $this->db->query($query);
        if($resultado->num_rows() > 0) return $resultado->row_array();
        return false;
    }

    
}
        