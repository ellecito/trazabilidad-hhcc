<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Nominas extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_nominas", "objNominas");
		$this->load->model("generar_agenda/modelo_agenda", "objAgenda");
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		$this->load->model("medicos/modelo_medicos", "objMedico");
		$this->load->model("box/modelo_box", "objBox");
		$this->layout->current = 4;
	}

	public function index(){
		$starttime = microtime(true);
		#title
		$this->layout->title('Generar Nominas');
		
		#metas
		$this->layout->setMeta('title','Generar Nominas');
		$this->layout->setMeta('description','Generar Nominas');
		$this->layout->setMeta('keywords','Generar Nominas');


		$nominas = array();
		foreach($this->objMedico->listar(array("me_estado" => 1)) as $medico){
			$nomina = new stdClass();
			$nomina->medico = $medico;
			$nomina->agendas = $this->objAgenda->listar(array("me_codigo" => $medico->codigo));
			$nominas[] = $nomina;
		}

		$endtime = microtime(true);
		$timediff = $endtime - $starttime;

		//die(print_array($nominas));

		$this->layout->view('index', array("timediff" => $timediff, "nominas" => $nominas));
	}
	
}