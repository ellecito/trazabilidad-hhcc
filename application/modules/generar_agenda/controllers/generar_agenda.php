<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Generar_agenda extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_agenda", "objAgenda");
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		$this->load->model("medicos/modelo_medicos", "objMedico");
		$this->load->model("medicos/modelo_medicos_especialidades", "objRel");
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

		$hora = "08:00:00";
		foreach($medicos as $medico){

			$medico->medico_especialidades = $this->objRel->listar(array("me_codigo" => $medico->codigo));
			$medico_especialidades = array();
			foreach($medico->medico_especialidades as $med_esp){
				$medico_especialidades[] = $med_esp->es_codigo;
			}
			$medico->medico_especialidades = $medico_especialidades;

			for($i=0; $i < 20; $i++){
				$datos = array(
					"ag_codigo" => $this->objAgenda->getLastId(),
					"ag_hora_pedido" => date("Y-m-d H:i:s"),
					"ag_hora_agendada" => date("Y-m-d", strtotime("+1 day")) . " " . $hora,
					"pa_codigo" => $pacientes[array_rand($pacientes, 1)]->codigo,
					"me_codigo" => $medico->codigo,
					"bx_codigo" => $boxs[array_rand($boxs, 1)]->codigo,
					"es_codigo" => $medico->medico_especialidades[array_rand($medico->medico_especialidades, 1)]
				);
				$this->objAgenda->insertar($datos);
				$hora = date("H:i:s", strtotime($hora) + 1800);
				if($hora > date("H:i:s", strtotime("20:00:00"))) $hora = "08:00:00";
			}
		}

		$endtime = microtime(true);
		$timediff = $endtime - $starttime;

		$this->layout->view('index', array("timediff" => $timediff));
	}
	
}