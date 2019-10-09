
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notas extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('notas_index');
		$this->load->view('footer');
    }

}
