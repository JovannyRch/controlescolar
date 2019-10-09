
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paginas extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function usuarios()
	{
		$this->load->view('header');
		$this->load->view('usuarios');
		$this->load->view('footer');
	}

}

/* End of file Autores.php */
/* Location: ./application/controllers/Autores.php */