<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Generar_agenda extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_agenda", "objAgenda");
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		$this->load->model("medicos/modelo_medicos", "objMedico");
		$this->load->model("box/modelo_box", "objBox");
		$this->load->model("especialidades/modelo_especialidad", "objEspecialidad");
		$this->layout->current = 3;
	}

	public function index(){
		$starttime = microtime(true);
		#title
		$this->layout->title('Generar Agenda');
		
		#metas
		$this->layout->setMeta('title','Generar Agenda');
		$this->layout->setMeta('description','Generar Agenda');
		$this->layout->setMeta('keywords','Generar Agenda');

		$pacientes = $this->objPaciente->listar(array("pa_estado" => 1));
		$medicos = $this->objMedico->listar(array("me_estado" => 1));
		$boxs = $this->objBox->listar();
		$especialidades = $this->objEspecialidad->listar();

		for ($i=0; $i < 100 ; $i++) {
			$datos = array(
				"ag_codigo" => $this->objAgenda->getLastId(),
				"ag_hora_pedido" => date("Y-m-d H:i:s"),
				"ag_hora_agendada" => date("Y-m-d H:i:s", strtotime("+1 day")),
				"pa_codigo" => $pacientes[array_rand($pacientes, 1)]->codigo,
				"me_codigo" => $medicos[array_rand($medicos, 1)]->codigo,
				"bx_codigo" => $boxs[array_rand($boxs, 1)]->codigo,
				"es_codigo" => $especialidades[array_rand($especialidades, 1)]->codigo
			);
			$this->objAgenda->insertar($datos);
		}

		$endtime = microtime(true);
		$timediff = $endtime - $starttime;

		//die(print_array($this->objAgenda->listar()));

		$this->layout->view('index', array("timediff" => $timediff));
	}
	
}