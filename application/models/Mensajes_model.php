<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Mensajes_model extends CI_Model {

    public function get($id_mensaje = null){
        if($id_mensaje){
            $resultado = $this->db->query("SELECT * FROM mensajes WHERE id_mensaje = $id_mensaje");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM mensajes");
            return $resultado->result_array();
        }
    }

    public function getEntrada($id_usuario){
        $resultado = $this->db->query("SELECT * FROM mensajes WHERE id_destinatario = $id_usuario ORDER BY fecha_hora DESC");
        if($resultado->num_rows() > 0) return $resultado->result_array();
        return false;
    }

    public function getSalida($id_usuario){
        $resultado = $this->db->query("SELECT * FROM mensajes WHERE id_remitente = $id_usuario ORDER BY fecha_hora DESC");
        if($resultado->num_rows() > 0) return $resultado->result_array();
        return false;
    }

    public function save($data){
        $this->db->set($data)->insert('mensajes');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function saveDestinatarios($destinatarios,$data){
        
        foreach ($destinatarios as $destinatario) {
            $aux = null;
            $aux = $data;
            $id_destinatario = $destinatario['id_usuario'];
           
            $aux['id_destinatario'] = $id_destinatario;
            $this->db->set($aux)->insert('mensajes');
        }
        if ($this->db->affected_rows() >= 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_mensaje,$data){
        $this->db->set($data)->where('id_mensaje', $id_mensaje)->update('mensajes');
        return true;
    } 

    public function delete($id_mensaje)
    {
        $this->db->where('id_mensaje', $id_mensaje)->delete('mensajes');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }

    public function updateLeido($id_mensaje){
        $data = array(
            'leido' => 1
           );
        $this->db->set($data)->where('id_mensaje', $id_mensaje)->update('mensajes');
        return true;
    }
}
        