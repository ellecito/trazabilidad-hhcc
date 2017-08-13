<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Nominas extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_nominas", "objNominas");
		$this->load->model("modelo_nomina_agenda", "objRel");
		$this->load->model("medicos/modelo_medicos_especialidades", "objRelE");
		$this->load->model("generar_agenda/modelo_agenda", "objAgenda");
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		$this->load->model("medicos/modelo_medicos", "objMedico");
		$this->load->model("box/modelo_box", "objBox");
		$this->load->model("especialidades/modelo_especialidad", "objEspecialidad");
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
			foreach($this->objMedico->listar($where_medico) as $medico){
				//Calculo de nomina por medico
				foreach($this->objRelE->listar($where_especialidades . " AND me_codigo =" . $medico->codigo) as $especialidad){
					$where = $where_boxs . " AND me_codigo = " . $medico->codigo . " AND " . $where_fecha . " AND es_codigo = " . $especialidad->es_codigo;
					if($agendas = $this->objAgenda->listar($where)){
						$nomina = new stdClass();
						$nomina->codigo = $this->objNominas->getLastId();
						$nomina->medico = $medico;
						$nomina->medico->especialidad = $this->objEspecialidad->obtener(array("es_codigo" => $especialidad->es_codigo));
						$nomina->agendas = $agendas;
						$nomina->fecha_creacion = date("Y-m-d H:i:s");
						$nomina->fecha_asignacion = date("Y-m-d H:i:s", strtotime("+1 day"));

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
						foreach($nomina->agendas as $agenda){
							$rel = array(
								"no_codigo" => $datos["no_codigo"],
								"ag_codigo" => $agenda->codigo
							);

							$this->objRel->insertar($rel);
							$paciente = $this->objPaciente->obtener(array("pa_codigo" => $agenda->pa_codigo));
							$paciente->box = $this->objBox->obtener(array("bx_codigo" => $agenda->bx_codigo));
							$pacientes[] = $paciente;
						}

						$nomina->pacientes = $pacientes;
						$nominas[] = $nomina;
					}

				}
				
			}

			$endtime = microtime(true);

			$contenido = array(
				"timediff" => $endtime - $starttime,
				"nominas" => $nominas
			);

			$this->layout->view('nominas', $contenido);
		}else{
			redirect("/");
		}
		
	}

	/*public function pdf(){

		$nominas = array();
		foreach($this->objMedico->listar(array("me_estado" => 1)) as $medico){
			//Calculo de nomina por medico para manana.
			$nomina = new stdClass();
			$nomina->medico = $medico;
			$nomina->agendas = $this->objAgenda->listar("me_codigo = " . $medico->codigo . " and ag_hora_agendada >= '" . date("Y-m-d", strtotime("+1 day")) . " 00:00:00'");
			$nomina->fecha_creacion = date("Y-m-d H:i:s");
			$nomina->fecha_asignacion = date("Y-m-d H:i:s", strtotime("+1 day"));
			
			$nomina->codigo = $this->objNominas->getLastId();

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
			foreach($nomina->agendas as $agenda){
				$rel = array(
					"no_codigo" => $datos["no_codigo"],
					"ag_codigo" => $agenda->codigo
				);

				$this->objRel->insertar($rel);
				$paciente = $this->objPaciente->obtener(array("pa_codigo" => $agenda->pa_codigo));
				$paciente->box = $this->objBox->obtener(array("bx_codigo" => $agenda->bx_codigo));
				$pacientes[] = $paciente;
			}
			$nomina->pacientes = $pacientes;
			$nominas[] = $nomina;
			
		}
		
		$html = "";
		foreach($nominas as $nomina){
			$html.= "<h1>NOMINA: " . $nomina->codigo . "</h1>";
			$html.= "<h3>" . $nomina->medico->nombres . " " . $nomina->medico->apellidos . "</h3>";
			$html.= "<p>FEC. CREACION " . formatearFecha(substr($nomina->fecha_creacion, 0, 10)) . " " . substr($nomina->fecha_creacion, 10, 6) . "</p>";
			$html.= "<p>FEC. DESPACHO " . formatearFecha(substr($nomina->fecha_asignacion, 0, 10)) . " 08:00:00" . "</p>";

			$html .= "<table>
				<tr>
					<th>HHCC</th>
					<th>PACIENTE</th>
					<th>BOX</th>
				</tr>";
			foreach($nomina->pacientes as $paciente){
			$html.= "<tr>
				<td>" . $paciente->hhcc . "</td>
				<td>" . $paciente->nombres . " " . $paciente->apellidos . "</td>
				<td>" . $paciente->box->nombre . "</td>
			</tr>";
			}
			$html.= "</table>";
		}
		$rutaPdf = base_url() . "archivos/";
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
			mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
		$rutaPdf .= "pdf/";
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
			mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
		
		$nombrePdf = "pdf".time().'.pdf';	 	 
		require APPPATH."/libraries/mpdf/mpdf.php";
		
		$mpdf->use_embeddedfonts_1252 = true; // false is default
		
		ob_start();
		$mpdf=new mPDF('utf-8','A4','','',0,0,0,0,6,3); 
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetTitle('Nominas');
		$mpdf->SetAuthor('HOSPITAL CHILLAN');
		$mpdf->WriteHTML(file_get_contents(APPPATH . "/css/bootstrap.css"), 1);
		$mpdf->WriteHTML($html, 2);
		$mpdf->Output($_SERVER['DOCUMENT_ROOT'].$rutaPdf.$nombrePdf,'F');
		redirect($rutaPdf.$nombrePdf);
	}*/
	
}