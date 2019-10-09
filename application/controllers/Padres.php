
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Padres extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('padres_index');
		$this->load->view('footer');
    }
    
    public function registro(){
        $this->load->view('header');
		$this->load->view('alumnos_nuevo');
		$this->load->view('footer');
    }

    public function ver($id){
        $datos['id'] = $id;
        $this->load->view('header');
		$this->load->view('padre_mostrar',$datos);
		$this->load->view('footer');
    }

}
