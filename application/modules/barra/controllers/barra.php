<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Barra extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->layout->current = 1;
	}

	public function index(){
		#title
		$this->layout->title('Trazabilidad HHCC');
		
		#metas
		$this->layout->setMeta('title','Trazabilidad HHCC');
		$this->layout->setMeta('description','Trazabilidad HHCC');
		$this->layout->setMeta('keywords','Trazabilidad HHCC');

		$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
		
		$this->layout->view('index', array("generator" => $generator));
	}
	
}