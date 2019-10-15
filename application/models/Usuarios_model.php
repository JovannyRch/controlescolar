
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Usuarios_model extends CI_Model {

    public function login($username,$password)
    {
        $query = "SELECT * FROM usuario_acceso WHERE logins = '".$username."' and password = '".$password."'";
        $resultado = $this->db->query($query);
        if($resultado->num_rows() == 1){
            return $resultado->row_array();
        }
        return null;
    }

    // Obtienes la cantidad de mensajes para el usuario que no han sido leidos
    public function getMensajesNoLeidos($id_usuario){
        $query = "SELECT count(id_mensaje) from mensajes where id_destinatario = $id_usuario and leido = 0";
        $resultado = $this->db->query($query)->row_array()['count(id_mensaje)'];
        if ($resultado){
            return $resultado;
        }
        else{
            return 0;
        }
    }

    public function tipoUsuario($id_tipo_usuario){
        $query = "SELECT tipo FROM tipo_usuario WHERE id_tipo_usuario = $id_tipo_usuario";
        $resultado = $this->db->query($query);
        if($resultado->num_rows() == 1){
            return $resultado->row_array()['tipo'];
        }
        return -1;
    }

    public function get($id_usuario = null){
        if($id_usuario){
            $resultado = $this->db->query("SELECT * FROM usuarios WHERE id_usuario = $id_usuario order by id_tipo_usuario");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM usuarios order by id_tipo_usuario, nombre");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('usuarios');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_usuario,$data){
        $this->db->set($data)->where('id_usuario', $id_usuario)->update('usuarios');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    } 

    public function delete($id_usuario)
    {
        $this->db->where('id_usuario', $id_usuario)->delete('usuarios');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }

    
     public function getProfesores(){
        $resultado = $this->db->query("SELECT * FROM usuarios WHERE id_tipo_usuario = 2 order by apellido_paterno");
        return $resultado->result_array();
    }
    public function getPadres(){
         $resultado = $this->db->query("SELECT * FROM usuarios WHERE id_tipo_usuario = 3 order by apellido_paterno");
        return $resultado->result_array();
    }

    public function getAlumnos(){
        $resultado = $this->db->query("SELECT * FROM usuarios WHERE id_tipo_usuario = 4 order by apellido_paterno");
        return $resultado->result_array();
    }

    public function like($nombre){
        $query = "SELECT * from usuarios where nombre LIKE '%{$nombre}%' and id_tipo_usuario = 4";
        $resultado = $this->db->query($query);
        return $resultado->result_array();
    }

    public function registrarAlumno($datos_usuario, $datos_alumno){
        $id_usuario = $this->save($datos_usuario);
        if($id_usuario){
            $datos_alumno['id_alumno'] = $id_usuario;
            $this->db->set($datos_alumno)->insert('datos_alumnos');
            if ($this->db->affected_rows() >= 1) return $id_usuario;
            else return null;
        }else return null;
    }

}
        