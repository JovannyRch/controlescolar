
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
        // Obtención del periodo actual
        $convocatoria_actual = $this->db->query("SELECT id_convocatoria from convocatorias where activo = 1")->row_array()['id_convocatoria'];
        $data['id_convocatoria'] = $convocatoria_actual;
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
        $pagos = $this->db->query("SELECT *,(SELECT convocatoria from convocatorias c where c.id_convocatoria = pagos.id_convocatoria) convocatoria from pagos where id_alumno = $id_usuario  order by 1 desc")->result_array();
        $suma = $this->db->query("SELECT sum(monto) suma from pagos where id_alumno = $id_usuario")->row_array()['suma'];
        if(is_null($suma)) $suma = 0;
        return array(
            'pagos' => $pagos,
            'suma' => $suma
        );
    }


}
        