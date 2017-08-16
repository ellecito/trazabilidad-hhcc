<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Generar extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		//if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		$this->load->model("medicos/modelo_medicos", "objMedico");
		$this->load->model("servicios/modelo_servicios", "objServicio");
		$this->load->model("inicio/modelo_funcionarios", "objFuncionario");
		$this->load->model("funcionarios/modelo_tipo_funcionario", "objTipoFuncionario");
		$this->load->model("bodegas/modelo_bodegas", "objBodega");
		$this->load->model("anaqueles/modelo_anaqueles", "objAnaquel");
		$this->load->model("divisiones/modelo_divisiones", "objDivision");
		$this->load->model("unidades/modelo_unidades", "objUnidad");
		$this->load->model("box/modelo_box", "objBox");
		$this->load->model("especialidades/modelo_especialidad", "objEspecialidad");
		$this->load->model("medicos/modelo_medicos_especialidades", "objRelE");
		$this->load->model("motivo_conforme/modelo_motivo_conforme", "objMotivoConforme");
		$this->load->model("motivo_solicitudes/modelo_motivo_solicitudes", "objMotivoSolicitud");
	}

	public function index(){
		#title
		$this->layout->title('Generar');
		
		#metas
		$this->layout->setMeta('title','Generar');
		$this->layout->setMeta('description','Generar');
		$this->layout->setMeta('keywords','Generar');

		$logs = array();
		$logs[] = $this->base();
		$logs[] = $this->servicios();
		$logs[] = $this->especialidades();
		$logs[] = $this->pacientes();
		$logs[] = $this->medicos();
		$logs[] = $this->bodegas();
		$logs[] = $this->anaqueles();
		$logs[] = $this->funcionarios();
		$logs[] = $this->divisiones();
		$logs[] = $this->unidades();
		$logs[] = $this->boxs();
		$this->layout->view('index', array("logs" => $logs));
	}

	private function base(){
		//Tipos de funcionario
		$tipo_funcionario = array(
			"ti_codigo" => 1,
			"ti_nombre" => "NORMAL",
		);
		$this->objTipoFuncionario->insertar($tipo_funcionario);
		$tipo_funcionario = array(
			"ti_codigo" => 2,
			"ti_nombre" => "ADMIN",
		);
		$this->objTipoFuncionario->insertar($tipo_funcionario);

		//Funcionarios de desarrollado
		$funcionario = array(
			"fu_codigo" => $this->objFuncionario->getLastId(),
			"fu_rut" => "18.433.269-8",
			"fu_nombres" => "VICTOR ADRIAN",
			"fu_apellidos" => "JARPA HERMOSILLA",
			"fu_email" => "contacto@victorjarpa.cl",
			"fu_password" => md5("vjarpa"),
			"fu_estado" => 1,
			"ti_codigo" => 2,
		);

		$this->objFuncionario->insertar($funcionario);

		$funcionario = array(
			"fu_codigo" => $this->objFuncionario->getLastId(),
			"fu_rut" => "11.111.111-1",
			"fu_nombres" => "PRUEBA PRUEBA",
			"fu_apellidos" => "PRUEBA PRUEBA",
			"fu_email" => "prueba@prueba.cl",
			"fu_password" => md5("prueba"),
			"fu_estado" => 1,
			"ti_codigo" => 2,
		);

		$this->objFuncionario->insertar($funcionario);

		//Tipos de Conformidad
		$tipo_conforme = array(
			"tc_codigo" => 1,
			"tc_nombre" => "Lentes"
		);

		$this->objMotivoConforme->insertar($tipo_conforme);

		$tipo_conforme = array(
			"tc_codigo" => 2,
			"tc_nombre" => "Audifonos"
		);

		$this->objMotivoConforme->insertar($tipo_conforme);

		//Tipos de Solicitud
		$tipo_solicitud = array(
			"mo_codigo" => 1,
			"mo_nombre" => "Autopsia"
		);

		$this->objMotivoSolicitud->insertar($tipo_solicitud);

		$tipo_solicitud = array(
			"mo_codigo" => 2,
			"mo_nombre" => "Operacion"
		);

		$this->objMotivoSolicitud->insertar($tipo_solicitud);

		return "Se generaron los tipos de funcionario y los funcionarios de desarrollo";
	}

	private function funcionarios($cantidad = 18){

		for($i = 1; $i<=$cantidad; $i++){
			$funcionario = array(
				"fu_codigo" => $this->objFuncionario->getLastId(),
				"fu_rut" => rand(1,30) . "." . rand(100,999) . "." . rand(100,999) . "-" . rand(1,9),
				"fu_nombres" => "FUNCIONARIO DE",
				"fu_apellidos" => "PRUEBA " . $i,
				"fu_email" => "prueba" . $i . "@prueba.cl",
				"fu_password" => md5(rand()),
				"fu_estado" => 1,
				"ti_codigo" => 1
			);
			$this->objFuncionario->insertar($funcionario);
		}
		return "Se generaron " . $cantidad . " funcionarios";
	}

	private function pacientes($cantidad = 200){

		for($i = 1; $i<=$cantidad; $i++){
			$paciente = array(
				"pa_codigo" => $this->objPaciente->getLastId(),
				"pa_rut" => rand(1,30) . "." . rand(100,999) . "." . rand(100,999) . "-" . rand(1,9),
				"pa_nombres" => "PACIENTE DE",
				"pa_apellidos" => "PRUEBA " . $i,
				"pa_estado" => 1,
				"pa_hhcc" => $i
			);
			$this->objPaciente->insertar($paciente);
		}
		return "Se generaron " . $cantidad . " pacientes";
	}

	private function medicos($cantidad = 200){
		$especialidades = $this->objEspecialidad->listar();
		$k = 0;
		for($i = 1; $i<=$cantidad; $i++){
			$medico = array(
				"me_codigo" => $this->objMedico->getLastId(),
				"me_rut" => rand(1,30) . "." . rand(100,999) . "." . rand(100,999) . "-" . rand(1,9),
				"me_nombres" => "MEDICO DE",
				"me_apellidos" => "PRUEBA " . $i,
				"me_estado" => 1,
				"me_email" => "prueba" . $i . "@prueba.cl"
			);
			$this->objMedico->insertar($medico);
			$cantidad_esp = rand(1,2);
			$total_esp = count($especialidades);
			for($j = 1; $j <= $cantidad_esp; $j++){
				$rel = array(
					"me_codigo" => $medico["me_codigo"],
					"es_codigo" => $especialidades[$k]->codigo
				);
				$this->objRelE->insertar($rel);
				if($k == $total_esp-1){
					$k = 0;
				}else{
					$k++;
				}
			}
		}

		return "Se generaron " . $cantidad . " medicos";
	}

	private function servicios($cantidad = 20){
		for($i = 1; $i<=$cantidad; $i++){
			$servicio = array(
				"se_codigo" => $this->objServicio->getLastId(),
				"se_nombre" => "Servicio " . $i
			);
			$this->objServicio->insertar($servicio);
		}
		return "Se generaron " . $cantidad . " servicios";
	}

	private function especialidades($cantidad = 20){
		$servicios = $this->objServicio->listar();
		for($i = 1; $i<=$cantidad; $i++){
			$especialidad = array(
				"es_codigo" => $this->objEspecialidad->getLastId(),
				"es_nombre" => "Especialidad " . $i,
				"se_codigo" => $servicios[array_rand($servicios,1)]->codigo
			);
			$this->objEspecialidad->insertar($especialidad);
		}
		return "Se generaron " . $cantidad . " especialidades";
	}

	private function bodegas($cantidad = 20){
		for($i = 1; $i<=$cantidad; $i++){
			$bodega = array(
				"bo_codigo" => $this->objBodega->getLastId(),
				"bo_nombre" => "Bodegas " . $i
			);
			$this->objBodega->insertar($bodega);
		}
		return "Se generaron " . $cantidad . " bodegas";
	}

	private function anaqueles($cantidad = 20){
		$bodegas = $this->objBodega->listar();
		for($i = 1; $i<=$cantidad; $i++){
			$anaquel = array(
				"an_codigo" => $this->objAnaquel->getLastId(),
				"an_nombre" => "Anaquel " . $i,
				"bo_codigo" => $bodegas[array_rand($bodegas,1)]->codigo
			);
			$this->objAnaquel->insertar($anaquel);
		}
		return "Se generaron " . $cantidad . " anaqueles";
	}

	private function divisiones($cantidad = 20){
		$anaqueles = $this->objAnaquel->listar();
		$funcionarios = $this->objFuncionario->listar(array("fu_estado" => 1));
		$min = 1;
		$max = 10;
		for($i = 1; $i<=$cantidad; $i++){
			$division = array(
				"di_codigo" => $this->objDivision->getLastId(),
				"di_nombre" => "D " . $i,
				"di_rango_min" => $min,
				"di_rango_max" => $max,
				"an_codigo" => $anaqueles[array_rand($anaqueles,1)]->codigo,
				"fu_codigo" => $funcionarios[$i-1]->codigo,
			);
			$min = $max + $min;
			$max = $max + $max;
			$this->objDivision->insertar($division);
		}
		return "Se generaron " . $cantidad . " divisiones";
	}

	private function unidades($cantidad = 20){
		for($i = 1; $i<=$cantidad; $i++){
			$unidad = array(
				"un_codigo" => $this->objUnidad->getLastId(),
				"un_nombre" => "Unidad " . $i
			);
			$this->objUnidad->insertar($unidad);
		}
		return "Se generaron " . $cantidad . " unidades";
	}

	private function boxs($cantidad = 20){
		$unidades = $this->objUnidad->listar();
		for($i = 1; $i<=$cantidad; $i++){
			$box = array(
				"bx_codigo" => $this->objBox->getLastId(),
				"bx_nombre" => "Box " . $i,
				"un_codigo" => $unidades[array_rand($unidades,1)]->codigo
			);
			$this->objBox->insertar($box);
		}
		return "Se generaron " . $cantidad . " boxs";
	}
	
}