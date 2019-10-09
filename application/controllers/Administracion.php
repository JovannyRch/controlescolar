
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administracion extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
 
        // load Session Library
        $this->load->library('session');
         
        // load url helper
		$this->load->helper('url');
		
    }
	public function index()
	{
		$this->load->view('header');
		$this->load->view('administracion');
		$this->load->view('footer');
	}

}

/* End of file Autores.php */
/* Location: ./application/controllers/Autores.php */