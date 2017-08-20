<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Nominas extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		require APPPATH."/libraries/mpdf/mpdf.php";
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_nominas", "objNominas");
		$this->load->model("modelo_nomina_agenda", "objRel");
		$this->load->model("medicos/modelo_medicos_especialidades", "objRelE");
		$this->load->model("generar_agenda/modelo_agenda", "objAgenda");
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		$this->load->model("medicos/modelo_medicos", "objMedico");
		$this->load->model("box/modelo_box", "objBox");
		$this->load->model("especialidades/modelo_especialidad", "objEspecialidad");
		$this->load->model("servicios/modelo_servicios", "objServicio");
		$this->load->model("unidades/modelo_unidades", "objUnidad");
		$this->load->model("inicio/modelo_funcionarios", "objFuncionario");
		$this->load->model("divisiones/modelo_divisiones", "objDivision");
		$this->load->model("bodegas/modelo_bodegas", "objBodega");
		$this->layout->current = 4;
	}

	public function index(){

		#title
		$this->layout->title('Generar Nominas');
		
		#metas
		$this->layout->setMeta('title','Generar Nominas');
		$this->layout->setMeta('description','Generar Nominas');
		$this->layout->setMeta('keywords','Generar Nominas');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		#JS - Datepicker
		$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
		$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

		$this->layout->js('js/jquery/jquery-redirect/jquery.redirect.js');

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		$this->layout->js('js/sistema/nominas/index.js');



		$contenido = array(
			"medicos" => $this->objMedico->listar(array("me_estado" => 1)),
			"boxs" => $this->objBox->listar(),
			"especialidades" => $this->objEspecialidad->listar()
		);

		$this->layout->view('index', $contenido);
	}

	public function calculo(){
		if($this->input->post()){

			$this->layout->title('Nominas');
		
			#metas
			$this->layout->setMeta('title','Nominas');
			$this->layout->setMeta('description','Nominas');
			$this->layout->setMeta('keywords','Nominas');

			$starttime = microtime(true); //Calculo de tiempo, toma inicial

			//Filtros
			$params = array();
			parse_str($this->input->post("formData"), $params);
			$where_medico = "me_estado = 1 AND me_codigo IN (" . implode(",", $params["medicos"]) . ")";
			$where_especialidades = "es_codigo IN (" . implode(",", $params["especialidades"]) . ")";
			$where_boxs = "bx_codigo IN (" . implode(",", $params["boxs"]) . ")";
			$where_fecha = "ag_hora_agendada >= '" . date("Y-m-d", strtotime(str_replace("/", "-", $params["fecha"]))) . " 00:00:00'";

			//Armado de nominas
			$nominas = array();
			$vouchers = array();
			$hhcc = array();
			foreach($this->objMedico->listar($where_medico) as $medico){
				//Calculo de nomina por medico
				foreach($this->objRelE->listar($where_especialidades . " AND me_codigo =" . $medico->codigo) as $especialidad){
					$where = $where_boxs . " AND me_codigo = " . $medico->codigo . " AND " . $where_fecha . " AND es_codigo = " . $especialidad->es_codigo;
					if($agendas = $this->objAgenda->listar($where)){
						$nomina = new stdClass();
						$nomina->codigo = $this->objNominas->getLastId();
						$nomina->medico = $medico;
						$nomina->medico->especialidad = $this->objEspecialidad->obtener(array("es_codigo" => $especialidad->es_codigo));
						$nomina->medico->servicio = $this->objServicio->obtener(array("se_codigo" => $nomina->medico->especialidad->se_codigo));
						$nomina->ubicacion = $this->objUnidad->obtener(array("un_codigo" => $nomina->medico->servicio->un_codigo));
						$nomina->agendas = $agendas;
						$nomina->fecha_creacion = date("Y-m-d H:i:s");
						$nomina->fecha_asignacion = date("Y-m-d", strtotime(str_replace("/", "-", $params["fecha"]))) . " 08:00:00";

						//Insertar en la BD
						$datos = array(
							"no_codigo" => $nomina->codigo,
							"no_fecha_asignada" => $nomina->fecha_asignacion,
							"no_fecha_creada" => $nomina->fecha_creacion,
							"me_codigo" => $nomina->medico->codigo
						);

						$this->objNominas->insertar($datos);

						//Relacion Nomina-Agenda
						$pacientes = array();
						$boxs = array();
						$hora_asignacion = strtotime("08:00:00");
						foreach($nomina->agendas as $agenda){
							$rel = array(
								"no_codigo" => $datos["no_codigo"],
								"ag_codigo" => $agenda->codigo
							);
							$hora_agendada = strtotime(substr($agenda->hora_agendada, 10, 6));
							if($hora_agendada < $hora_asignacion) $hora_asignacion = $hora_agendada;
							$nomina->fecha_asignacion = date("Y-m-d", strtotime(str_replace("/", "-", $params["fecha"]))) . " " . date("H:i:s", $hora_asignacion);
							$this->objRel->insertar($rel);
							$paciente = $this->objPaciente->obtener(array("pa_codigo" => $agenda->pa_codigo));
							$paciente->hora = $agenda->hora_agendada;
							$paciente->box = $this->objBox->obtener(array("bx_codigo" => $agenda->bx_codigo));
							$pacientes[] = $paciente;
							$hc = new stdClass();
							$hc->hhcc = $paciente->hhcc;
							$hc->nomina = $nomina->codigo;
							$hc->medico = $nomina->medico;
							$hhcc[] = $hc;
						}
						
						$nomina->pacientes = $pacientes;
						$nominas[] = $nomina;
					}
				}
			}

			//Vouchers
			$divisiones = $this->objDivision->listar();
			foreach($divisiones as $division){
				$voucher = new stdClass();
				$voucher->division = $division;
				$voucher->bodega = $this->objBodega->obtener(array("bo_codigo" => $division->anaquel->bo_codigo));
				$voucher->hhcc = array();
					foreach($hhcc as $hc){
						if($hc->hhcc>=$division->rango_min and $hc->hhcc<=$division->rango_max){
							$voucher->hhcc[] = $hc;
						}
					}
				$voucher->funcionario = $this->objFuncionario->obtener(array("fu_codigo" => $division->fu_codigo));
				if($voucher->hhcc) $vouchers[] = $voucher;
			}

			$endtime = microtime(true);
			$contenido = array(
				"timediff" => $endtime - $starttime,
				"nominas" => $nominas,
				"vouchers" => $vouchers,
				"pdf" => $this->pdf_nominas($nominas),
				"pdf_voucher" => $this->pdf_vouchers($vouchers)
			);

			$this->layout->view('nominas', $contenido);
		}else{
			redirect("/");
		}
		
	}

	private function pdf_nominas($nominas){

		$html = '';
		foreach($nominas as $nomina){
			$html.= '<div style="padding: 20px;"><center><h3>NOMINA HHCC</h3></center><table style="width: 100%;"><tr><td><b>NOMINA</b></td><td>' . $nomina->codigo . '</td></tr><tr><td><b>FEC. DESPACHO</b></td><td>' . formatearFecha(substr($nomina->fecha_asignacion, 0, 10)) . " " . substr($nomina->fecha_asignacion, 10, 6) . '</td><td><b>LUGAR ENTREGA</b></td><td>' . $nomina->ubicacion->codigo . '</td><td>' . $nomina->ubicacion->nombre . '</td><td><b>APROBADAS</b></td><td>' . count($nomina->pacientes) . '</td></tr><tr><td><b>FEC. CREACION</b></td><td>' . formatearFecha(substr($nomina->fecha_creacion, 0, 10)) . " " . substr($nomina->fecha_creacion, 10, 6) . '</td><td><b>SERVICIO</b></td><td>' . $nomina->medico->servicio->codigo . '</td><td>' . $nomina->medico->servicio->nombre . '</td><td><b>RECHAZADAS</b></td><td>0</td></tr><tr><td><b>TIPO ATENCION</b></td><td>AMB</td><td><b>ESPECIALIDAD</b></td><td>' . $nomina->medico->especialidad->codigo . '</td><td>' . $nomina->medico->especialidad->nombre . '</td><td><b>DEVUELTAS</b></td><td>0</td></tr><tr><td><b></b></td><td></td><td><b>PROFESIONAL</b></td><td>' . $nomina->medico->codigo . '</td><td>' . $nomina->medico->nombres . " " . $nomina->medico->apellidos . '</td><td><b>TOTAL</b></td><td>' .count($nomina->pacientes) . '</td></tr><tr style="border: 1px;"><td><b>HHCC</b></td><td><b>NOMBRE PACIENTE</b></td><td></td><td><b>LUGAR USO</b></td><td><b>HOR. DEV.</b></td><td><b>ULT. UBICACION</b></td><td></td></tr>';

			foreach($nomina->pacientes as $paciente){
				$html.= '<tr><td>' . $paciente->hhcc . '</td><td>' . $paciente->nombres . " " . $paciente->apellidos . '</td><td></td><td>LUGAR USO</td><td> ' . substr($paciente->hora, 10, 6) . '</td><td>---</td><td></td></tr>';
			}

			$html.= '</table></div>';
			if($nomina !== $nominas[count($nominas)-1]) $html.= '<pagebreak>';
		}

		$rutaPdf = "/hospital/archivos/";
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
			mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
		$rutaPdf .= "pdf/";
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
			mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
				
		$nombrePdf = "pdf".time().'.pdf';
		
		$firma = '<div style="padding:10px; text-align: center;">Nombre: _____________________ | Firma: _____________________ | Fecha: ____/____/________<div>';
		ob_start();
		$mpdf=new mPDF('utf-8','','','',0,0,0,0,6,3);
		//$mpdf->use_embeddedfonts_1252 = true; // false is default
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetTitle('NOMINAS');
		$mpdf->SetAuthor('HOSPITAL CHILLAN');
		$mpdf->SetHTMLFooter($firma);
		$mpdf->WriteHTML(file_get_contents(base_url() . "css/nomina.css"), 1);
		$mpdf->WriteHTML($html, 2);

		$mpdf->Output($_SERVER['DOCUMENT_ROOT'].$rutaPdf.$nombrePdf,'F');
		return $rutaPdf.$nombrePdf;
	}

	public function pdf_vouchers($vouchers){
		$html = '';
		foreach($vouchers as $voucher){
			$html.= '<div style="padding: 20px;"><center><h3>VOUCHER</h3></center>';
			$html.= '<table style="width: 100%;">';
			$html.= '<tr>';
			$html.= '<td><b>FUNCIONARIO:</b></td>';
			$html.= '<td>' . $voucher->funcionario->nombres . ' ' .  $voucher->funcionario->apellidos . '</td>';
			$html.= '<td><b>UBICACION:</b></td>';
			$html.= '<td>' . $voucher->division->nombre . ' | ' . $voucher->division->anaquel->nombre . ' | ' . $voucher->bodega->nombre . '</td>';
			$html.= '</tr>';
			$html.= '<tr>';
			$html.= '<td><b>HHCC<b></td>';
			$html.= '<td><b>MEDICO<b></td>';
			$html.= '<td><b>ESPECIALIDAD<b></td>';
			$html.= '<td><b>NOMINA</b></td>';
			$html.= '</tr>';
			foreach($voucher->hhcc as $hhcc){
				$html.= '<tr>';
				$html.= '<td>' . $hhcc->hhcc . '</td>';
				$html.= '<td>' . $hhcc->medico->nombres . ' ' . $hhcc->medico->apellidos . '</td>';
				$html.= '<td>' . $hhcc->medico->especialidad->nombre . '</td>';
				$html.= '<td>' . $hhcc->nomina . '</td>';
				$html.= '</tr>';
			}
			$html.= '</table></div><pagebreak>';
			if($voucher !== $vouchers[count($vouchers)-1]) $html.= '<pagebreak>';
		}

		$rutaPdf = "/hospital/archivos/";
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
			mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
		$rutaPdf .= "pdf/";
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
			mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
				
		$nombrePdf = "pdf".time().'.pdf';

		ob_start();
		$mpdf=new mPDF('utf-8','','','',0,0,0,0,6,3);
		//$mpdf->use_embeddedfonts_1252 = true; // false is default
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetTitle('NOMINAS');
		$mpdf->SetAuthor('HOSPITAL CHILLAN');
		$mpdf->WriteHTML(file_get_contents(base_url() . "css/nomina.css"), 1);
		$mpdf->WriteHTML($html, 2);

		$mpdf->Output($_SERVER['DOCUMENT_ROOT'].$rutaPdf.$nombrePdf,'F');
		return $rutaPdf.$nombrePdf;
	}
	
}