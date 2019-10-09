
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autores extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('autores_model');
	}

	public function index($tipo)
	{
		$data['tipo'] = $tipo;
		if($tipo == 1){
			$data['titulo'] = 'Autores de libros';
			$data['clase'] = 'fa fa-book';
		}

		if($tipo == 2){
			$data['clase'] = 'fa fa-film';
			$data['titulo'] = 'Directores de películas';
		}

		if($tipo == 3){
			$data['clase'] = 'fa fa-music';
			$data['titulo'] = 'Artista de música';
		}

	

		$this->load->view('autores_index', $data);
	}

}

/* End of file Autores.php */
/* Location: ./application/controllers/Autores.php */