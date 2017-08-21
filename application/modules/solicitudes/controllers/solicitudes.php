<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Solicitudes extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		$this->load->model("inicio/modelo_funcionarios", "objFuncionario");
		$this->load->model("medicos/modelo_medicos", "objMedicos");
		$this->load->model("modelo_motivo_solicitud", "objMotivo");
		$this->load->model("modelo_solicitud", "objSolicitud");
		$this->load->model("modelo_solicitud_paciente", "objSolicitudPaciente");
		$this->load->model("especialidades/modelo_especialidad", "objEspecialidad");
		$this->load->model("servicios/modelo_servicios", "objServicio");
		$this->load->model("medicos/modelo_medicos_especialidades", "objRel");
		$this->layout->current = 2;
		$this->layout->subCurrent = 8;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Solicitudes');

		#Metas
		$this->layout->setMeta('title','Solicitudes');
		$this->layout->setMeta('description','Solicitudes');
		$this->layout->setMeta('keywords','Solicitudes');

		#js
		$this->layout->js('js/sistema/solicitudes/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "bo_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'solicitudes/';
		$config['total_rows'] = count($this->objSolicitud->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/solicitudes'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objSolicitud->listar($where, $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('fecha_entrega', 'Fecha Entrega', 'required');
			//$this->form_validation->set_rules('fecha_retorno', 'Fecha Retorno', 'required');
			$this->form_validation->set_rules('paciente', 'Paciente', 'required');
			$this->form_validation->set_rules('medico', 'Medico', 'required');
			$this->form_validation->set_rules('motivo', 'Motivo', 'required');
			$this->form_validation->set_rules('detalle', 'Detalle', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$motivo = $this->objMotivo->obtener(array("mo_codigo" => $this->input->post('motivo')));
			$fecha_asignada = date("Y-m-d",strtotime(str_replace("/","-",$this->input->post('fecha_entrega'))));
			$fecha_entrega = date("Y-m-d", strtotime($fecha_asignada . "+" . $motivo->dias . " days"));
			$datos = array(
				'so_codigo' => $this->objSolicitud->getLastId(),
				'so_fecha_emision' => date("Y-m-d H:i:s"),
				'so_fecha_asignada' => $fecha_asignada,
				'so_fecha_entrega' => $fecha_entrega,
				'fu_codigo' => $this->session->userdata("usuario")->codigo,
				'me_codigo' => $this->input->post('medico'),
				'mo_codigo' => $this->input->post('motivo'),
				'so_detalle' => $this->input->post('detalle'),
				'so_nombre_medico' => $this->input->post('nombre'),
				'so_email_medico' => $this->input->post('email'),
				'so_telefono_medico' => $this->input->post('telefono')
			);
			
			if($this->objSolicitud->insertar($datos)){
				foreach($this->input->post('paciente') as $paciente){
					$rel = array(
						"so_codigo" => $datos["so_codigo"],
						"pa_codigo" => $paciente
					);
					$this->objSolicitudPaciente->insertar($rel);
				}
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Solicitud');

			#metas
			$this->layout->setMeta('title','Agregar Solicitud');
			$this->layout->setMeta('description','Agregar Solicitud');
			$this->layout->setMeta('keywords','Agregar Solicitud');

			#JS - Datepicker
			$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
			$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
			$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#js
			$this->layout->js('js/sistema/solicitudes/agregar.js');

			#nav
			$this->layout->nav(array("Solicitud "=> "solicitudes", "Agregar Solicitud" =>"/"));

			$contenido = array(
				"pacientes" => $this->objPaciente->listar(),
				"medicos" => $this->objMedicos->listar(),
				"funcionarios" => $this->objFuncionario->listar(),
				"motivos" => $this->objMotivo->listar(),
				"objSolicitud" => $this->objMotivo->listar()
			);

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('fecha_entrega', 'Fecha Entrega', 'required');
			$this->form_validation->set_rules('paciente', 'Paciente', 'required');
			$this->form_validation->set_rules('medico', 'Medico', 'required');
			$this->form_validation->set_rules('motivo', 'Motivo', 'required');
			$this->form_validation->set_rules('detalle', 'Detalle', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$fecha_asignada = date("Y-m-d",strtotime(str_replace("/","-",$this->input->post('fecha_entrega'))));
			$fecha_entrega = date("Y-m-d", strtotime($fecha_asignada . "+" . $motivo->dias . " days"));

			$datos = array(
				'so_fecha_asignada' => $fecha_asignada,
				'so_fecha_entrega' => $fecha_entrega,
				'fu_codigo' => $this->session->userdata("usuario")->codigo,
				'me_codigo' => $this->input->post('medico'),
				'mo_codigo' => $this->input->post('motivo'),
				'so_detalle' => $this->input->post('detalle'),
				'so_nombre_medico' => $this->input->post('nombre'),
				'so_email_medico' => $this->input->post('email'),
				'so_telefono_medico' => $this->input->post('telefono')
			);

			if($this->objSolicitud->actualizar($datos,array("so_codigo"=>$this->input->post('codigo')))){
				$this->objSolicitudPaciente->eliminar(array("so_codigo" => $this->input->post('codigo')));
				foreach($this->input->post('paciente') as $paciente){
					$rel = array(
						"so_codigo" => $this->input->post('codigo'),
						"pa_codigo" => $paciente
					);
					$this->objSolicitudPaciente->insertar($rel);
				}
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "solicitudes/");

			#JS - Datepicker
			$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
			$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
			$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#js
			$this->layout->js('js/sistema/solicitudes/editar.js');

			#title
			$this->layout->title('Editar Solicitud');

			#metas
			$this->layout->setMeta('title','Editar Solicitud');
			$this->layout->setMeta('description','Editar Solicitud');
			$this->layout->setMeta('keywords','Editar Solicitud');

			$contenido = array(
				"solicitud" => $this->objSolicitud->obtener(array("so_codigo" => $codigo)),
				"pacientes" => $this->objPaciente->listar(),
				"medicos" => $this->objMedicos->listar(),
				"funcionarios" => $this->objFuncionario->listar(),
				"motivos" => $this->objMotivo->listar(),
				"solicitud_pacientes" => $this->objSolicitudPaciente->listar(array("so_codigo" => $codigo))
			);
			$solicitud_pacientes = array();
			foreach($contenido["solicitud_pacientes"] as $sol_pac){
				$solicitud_pacientes[] = $sol_pac->pa_codigo;
			}
			$contenido["solicitud_pacientes"] = $solicitud_pacientes;
			#contenido
			if($contenido['solicitud']){

			}else show_error('');

			#nav
			$this->layout->nav(array("Solicitudes "=>"solicitudes", "Editar Solicitud" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function descargar($codigo = false){
		if(!$codigo) redirect(base_url());

		$solicitud = $this->objSolicitud->obtener(array("so_codigo" => $codigo));
		$solicitud->pacientes = $this->objSolicitudPaciente->listar(array("so_codigo" => $codigo));
		$solicitud_pacientes = array();
		foreach($solicitud->pacientes as $sol_pac){
			$solicitud_pacientes[] = $this->objPaciente->obtener(array("pa_codigo" => $sol_pac->pa_codigo));
		}
		$solicitud->pacientes = $solicitud_pacientes;
		$html = "<div style='padding: 20px; font-size: small;'>";
		$html.= "<img src='" . base_url() . "imagenes/template/minsal.png' style='width: 10%;'/>";
		$html.= "<h3 style='text-align: center;'>SOLICITUD DE HISTORIAS CLINICAS</h3>";

		if($solicitud->medico){
			$solicitud->medico->especialidad = $this->objRel->obtener(array("me_codigo" => $solicitud->medico->codigo));
			$solicitud->medico->especialidad = $this->objEspecialidad->obtener(array("es_codigo" => $solicitud->medico->especialidad->es_codigo));
			$solicitud->medico->servicio = $this->objServicio->obtener(array("se_codigo" => $solicitud->medico->especialidad->se_codigo));
			$html.= "<p><b>PROFESIONAL:</b> " . $solicitud->medico->nombres . " " . $solicitud->medico->apellidos . "</p>";
			$html.= "<p><b>ESPECIALIDAD:</b> " . $solicitud->medico->especialidad->nombre . "</p>";
			$html.= "<p><b>SERVICIO:</b> " . $solicitud->medico->servicio->nombre . "</p>";
		}else{
			$html.= "<p><b>PROFESIONAL EXTERNO:</b> " . $solicitud->nombre_medico . "</p>";
			$html.= "<p><b>TELEFONO:</b> " . $solicitud->telefono_medico . "</p>";
			$html.= "<p><b>EMAIL:</b> " . $solicitud->email_medico . "</p>";
		}

		$html.= "<p><b>FECHA EMISION:</b> " . formatearFecha(substr($solicitud->fecha_emision, 0, 10)) . "</p>";
		$html.= "<p><b>FECHA SOLICITUD:</b> " . formatearFecha(substr($solicitud->fecha_asignada, 0, 10)) . "</p>";
		$html.= "<p><b>FECHA ENTREGA:</b> " . formatearFecha(substr($solicitud->fecha_entrega, 0, 10)) . "</p>";
		$html.= "<p><b>DETALLES:</b> " . $solicitud->detalle . "</p>";
		
		
		$html.= "<p><b>LUGAR FISICO HHCC:</b> POR DEFINIR (TRAZABILIDAD)</p>";
		$html.= "<p><b>MOTIVO:</b> " . $solicitud->motivo->nombre . "</p>";


		$html.="<p><b>PACIENTES:</b> </p>";
		$html.="<table style='width: 100%;'>";
		$html.="<tr>";
		$html.="<td><b>HHCC</b></td>";
		$html.="<td><b>RUT</b></td>";
		$html.="<td><b>NOMBRE</b></td>";
		$html.="</tr>";
		$html.= "/<div>";
		foreach($solicitud->pacientes as $paciente){
			$html.="<tr>";
			$html.="<td>" . $paciente->hhcc . "</td>";
			$html.="<td>" . $paciente->rut . "</td>";
			$html.="<td>" . $paciente->nombres . " " . $paciente->apellidos . "</td>";
			$html.="</tr>";
		}
		$html.="</table>";
		$rutaPdf = "/hospital/archivos/";
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
			mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
		$rutaPdf .= "pdf/";
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
			mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
			
		$nombrePdf = "pdf".time().'.pdf';	 	 
		require APPPATH."/libraries/mpdf/mpdf.php";
		
		ob_start();
		$mpdf=new mPDF('utf-8','','','',0,0,0,0,6,3); 
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetTitle('Solicitudes');
		$mpdf->SetAuthor('HOSPITAL CHILLAN');
		$mpdf->WriteHTML(file_get_contents(base_url() . "css/nomina.css"), 1);
		$mpdf->WriteHTML($html, 2);
		$mpdf->Output($_SERVER['DOCUMENT_ROOT'].$rutaPdf.$nombrePdf,'F');
		$rutaPdf = base_url() . "archivos/pdf/";
		redirect($rutaPdf.$nombrePdf);
	}
	
}