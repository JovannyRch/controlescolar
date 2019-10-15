
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Pagos_model extends CI_Model {

    public function get($id = null){
        if($id){
            $resultado = $this->db->query("SELECT * FROM pagos WHERE id = $id");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM pagos");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('pagos');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id,$data){
        $this->db->set($data)->where('id', $id)->update('pagos');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    } 

    public function delete($id)
    {
        $this->db->where('id', $id)->delete('pagos');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }

      //PAGOS DE UN ALUMNO
      public function getPagosAlumno($id_usuario){
        //jovannyrch@gmail.com
        $pagos = $this->db->query("SELECT * from pagos where id_alumno = $id_usuario")->result_array();
        $suma = $this->db->query("SELECT sum(monto) suma from pagos where id_alumno = $id_usuario")->row_array()['suma'];
        return array(
            'pagos' => $pagos,
            'suma' => $suma
        );
    }


}
        