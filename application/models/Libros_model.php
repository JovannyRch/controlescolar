
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Libros_model extends CI_Model {

	public function libros(){
		$query = "SELECT * FROM libros" ;
		$resultado = $this->db->query($query);
		if($resultado){
			return $resultado->result_array();
		}
		return false;
	}	

	public function libro($ID_libro){
		$query = "SELECT * FROM libros WHERE ID_libro=($ID_libro)" ;
		$resultado = $this->db->query($query);
		if($resultado){
			return $resultado->row_array();
		}
		return false;
	}	

	public function guardar($clasificacion,$autor,$titulo,$pie_Imprenta,$paginas,$ISBN,$temas){
        $query = "INSERT INTO libros(clasificacion,autor,titulo,pie_Imprenta,paginas,ISBN,temas) VALUES('{$clasificacion}','{$autor}','{$titulo}','{$pie_Imprenta}',{$paginas},'{$ISBN}','{$temas}')";
        $this->db->query($query);
        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return false;
	}
	
	public function eliminar($ID_libro){
        $query = "DELETE FROM libros WHERE ID_libro=($ID_libro)";
        $this->db->query($query);
        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return false;
	}
	
	public function actualizar($ID_libro,$clasificacion,$autor,$titulo,$pie_Imprenta,$paginas,$ISBN,$temas){
		$query = "UPDATE libros SET clasificacion = '{$clasificacion}',autor='{$autor}', titulo='{$titulo}', pie_Imprenta='{$pie_Imprenta}', paginas='{$paginas}', ISBN='{$ISBN}', temas='{$temas}' WHERE ID_libro = {$ID_libro}";
        $this->db->query($query);
        if ($this->db->affected_rows() === 1) {
            return true;
        }
        return false;

	}
}