
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//By: JovannyRch

class Posts_model extends CI_Model {

    public function get($id_post = null){
        if($id_post){
            $resultado = $this->db->query("SELECT * FROM posts WHERE id_post = $id_post");
            if($resultado->num_rows() > 0) return $resultado->row_array();
            return false;
        }else{
            $resultado = $this->db->query("SELECT * FROM posts");
            return $resultado->result_array();
        }
    }

    public function save($data){
        $this->db->set($data)->insert('posts');
        if ($this->db->affected_rows() === 1) return $this->db->insert_id();
        return null;
    }

    public function update($id_post,$data){
        $this->db->set($data)->where('id_post', $id_post)->update('posts');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    } 

    public function delete($id_post)
    {
        $this->db->where('id_post', $id_post)->delete('posts');
        if ($this->db->affected_rows() === 1) return true;
        return null;
    }
}
        