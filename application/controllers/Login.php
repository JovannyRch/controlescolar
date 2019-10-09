
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
 
        // load Session Library
        $this->load->library('session');
         
        // load url helper
		$this->load->helper('url');
		
		$this->load->model('usuarios_model');
    }

	public function index()
	{
		if($this->session->userdata('nombre')){
			$this->redireccionar($this->session->userdata('tipo_usuario'));
		}
		else if(isset($_POST['password'])){
			$consulta = $this->usuarios_model->login($this->verificarEntrada($_POST['username']),$this->verificarEntrada($_POST['password']));
			if(!is_null($consulta)){

				$usuario = $this->usuarios_model->get($consulta['id_usuario']);
				$tipo_usuario = $this->usuarios_model->tipoUsuario($usuario['id_tipo_usuario']);
				
				$data = array(
					'username' => $_POST['username'],
					'nombre' => $usuario['nombre'],
					'apellido_paterno' => $usuario['apellido_paterno'],
					'apellido_materno' => $usuario['apellido_materno'],
					'id_usuario' => $usuario['id_usuario'],
					'tipo_usuario' => $tipo_usuario
				);	
				$this->session->set_userdata($data);
				$this->redireccionar($tipo_usuario);
				
			}else{
				redirect('login#error','refresh');
			}
		}
		else {
			$this->load->view('login');
		}
		
	}

	public function verificarEntrada($datos){
		$datos = trim($datos);
		$datos = stripslashes($datos);
		$datos = htmlspecialchars($datos);
		return $datos;
	}

	public function redireccionar($tipo_usuario){
		if($tipo_usuario == 1){
			redirect('inicio','refresh');
		}
		else if($tipo_usuario == 2){
			redirect('inicio','refresh');
		}
		else if($tipo_usuario == 3){
			redirect('inicio','refresh');
		}
		else if($tipo_usuario == 4){
			redirect('inicio','refresh');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login','refresh');
		
	}

}

/* End of file Login.php */

