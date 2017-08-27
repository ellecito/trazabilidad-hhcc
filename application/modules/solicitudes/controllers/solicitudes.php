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
		$this->load->model("unidades/modelo_unidades", "objUnidad");
		$this->layout->current = 3;
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

	public function buscar_paciente(){
		if($this->input->post()){
			$q = $this->input->post("q");
			$where = "CONCAT(pa_nombres, ' ', pa_apellidos) like '%$q%' or pa_rut like '%$q%' or pa_hhcc like '%$q%'";
			$pacientes = $this->objPaciente->listar($where, false, 15);
			echo json_encode($pacientes);
			exit;
		}else{
			redirect(base_url());
		}
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('fecha_entrega', 'Fecha Entrega', 'required');
			$this->form_validation->set_rules('paciente', 'Paciente', 'required');
			$this->form_validation->set_rules('medico', 'Medico', 'required');
			$this->form_validation->set_rules('motivo', 'Motivo', 'required');
			$this->form_validation->set_rules('detalle', 'Detalle', 'required');
			$this->form_validation->set_rules('telefono', 'Teléfono', 'required');
			$this->form_validation->set_rules('celular', 'Celular', 'required');
			$this->form_validation->set_rules('anexo', 'Anexo', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$motivo = $this->objMotivo->obtener(array("mo_codigo" => $this->input->post('motivo')));

			if($motivo->documento && $_FILES['documento']['error'] != 0){
				echo json_encode(array("result"=>false,"msg"=>"<div>Se requiero documento.</div>"));
				exit;
			}

			$fecha_asignada = date("Y-m-d",strtotime(str_replace("/","-",$this->input->post('fecha_entrega'))));

			$day_of_the_week = date("Y-m-d", strtotime($fecha_asignada . "+" . $motivo->dias . " days"));
			$day_of_the_week = date("N", strtotime($day_of_the_week));
			if($day_of_the_week > 5){
				$motivo->dias = $motivo->dias + (abs($day_of_the_week - 7)+1);

			}
			$fecha_entrega = date("Y-m-d", strtotime($fecha_asignada . "+" . $motivo->dias . " days"));

			if($_FILES['documento']['error'] == 0){

				if($_FILES['documento']['name']==''){
					echo json_encode(array("result"=>false,"msg"=>"Debes subir un archivo"));
					exit;
				}
				
				$uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/hospital/archivos/';
				if(!file_exists($uploads_dir)){
					mkdir($uploads_dir,0777);
				}
				$uploads_dir .= "solicitaciones/";
				if(!file_exists($uploads_dir))
					mkdir($uploads_dir,0777);

				$extension = explode(".",$_FILES['documento']['name']);
				$extension = array_pop($extension);
				$extension = strtolower($extension);
				$permitidas = array("pdf","png","jpg","jpeg"); #extensiones permitidas
				$name = 'solicitaciones_'.time();
				$tmp = $_FILES["documento"]["tmp_name"];
				
				if(!in_array($extension, $permitidas)){
					echo json_encode(array("result"=>false,"msg"=>"<div>Formato no permitido, solo se acepta pdf, png, jpeg y jpg.</div>"));
					exit;
				}
				
				move_uploaded_file($tmp, $uploads_dir.$name . "." . $extension);
				if(is_file($uploads_dir.$name . "." . $extension))
					chmod($uploads_dir.$name . "." . $extension, 0777);
				//$uploads_dir = base_url() . "archivos/solicitaciones/";
				$datos["so_documento"] = $uploads_dir.$name . "." . $extension;
			}

			$datos['so_codigo'] = $this->objSolicitud->getLastId();
			$datos['so_fecha_emision'] = date("Y-m-d H:i:s");
			$datos['so_fecha_asignada'] = $fecha_asignada;
			$datos['so_fecha_entrega'] = $fecha_entrega;
			$datos['so_detalle'] = $this->input->post('detalle');
			$datos['so_nombre_medico'] = $this->input->post('nombre');
			$datos['so_email_medico'] = $this->input->post('email');
			$datos['so_telefono'] = $this->input->post('telefono');
			$datos['so_anexo'] = $this->input->post('anexo');
			$datos['so_celular'] = $this->input->post('celular');
			$datos['fu_codigo'] = $this->session->userdata("usuario")->codigo;
			$datos['me_codigo'] = $this->input->post('medico');
			$datos['mo_codigo'] = $this->input->post('motivo');
			
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

			#JS - Formulario
			$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
			$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#js
			$this->layout->js('js/sistema/solicitudes/agregar.js');

			#nav
			$this->layout->nav(array("Solicitud "=> "solicitudes", "Agregar Solicitud" =>"/"));

			$contenido = array(
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
			$this->form_validation->set_rules('telefono', 'Teléfono', 'required');
			$this->form_validation->set_rules('celular', 'Celular', 'required');
			$this->form_validation->set_rules('anexo', 'Anexo', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$motivo = $this->objMotivo->obtener(array("mo_codigo" => $this->input->post('motivo')));
			$fecha_asignada = date("Y-m-d",strtotime(str_replace("/","-",$this->input->post('fecha_entrega'))));
			$day_of_the_week = date("Y-m-d", strtotime($fecha_asignada . "+" . $motivo->dias . " days"));
			$day_of_the_week = date("N", strtotime($day_of_the_week));
			if($day_of_the_week > 5){
				$motivo->dias = $motivo->dias + (abs($day_of_the_week - 7)+1);

			}
			$fecha_entrega = date("Y-m-d", strtotime($fecha_asignada . "+" . $motivo->dias . " days"));

			if($_FILES['documento']['error'] == 0){
				
				$uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/hospital/archivos/';
				if(!file_exists($uploads_dir)){
					mkdir($uploads_dir,0777);
				}
				$uploads_dir .= "solicitaciones/";
				if(!file_exists($uploads_dir))
					mkdir($uploads_dir,0777);

				$extension = explode(".",$_FILES['documento']['name']);
				$extension = array_pop($extension);
				$extension = strtolower($extension);
				$permitidas = array("pdf","png","jpg","jpeg"); #extensiones permitidas
				$name = 'solicitaciones_'.time();
				$tmp = $_FILES["documento"]["tmp_name"];
				
				if(!in_array($extension, $permitidas)){
					echo json_encode(array("result"=>false,"msg"=>"<div>Formato no permitido, solo se acepta pdf, png, jpeg y jpg.</div>"));
					exit;
				}
				
				move_uploaded_file($tmp, $uploads_dir.$name . "." . $extension);
				if(is_file($uploads_dir.$name . "." . $extension))
					chmod($uploads_dir.$name . "." . $extension, 0777);
				//$uploads_dir = base_url() . "archivos/solicitaciones/";
				$datos["so_documento"] = $uploads_dir.$name . "." . $extension;
			}

			$datos['so_fecha_asignada'] = $fecha_asignada;
			$datos['so_fecha_entrega'] = $fecha_entrega;
			$datos['so_detalle'] = $this->input->post('detalle');
			$datos['so_nombre_medico'] = $this->input->post('nombre');
			$datos['so_email_medico'] = $this->input->post('email');
			$datos['so_telefono'] = $this->input->post('telefono');
			$datos['so_anexo'] = $this->input->post('anexo');
			$datos['so_celular'] = $this->input->post('celular');
			$datos['fu_codigo'] = $this->session->userdata("usuario")->codigo;
			$datos['me_codigo'] = $this->input->post('medico');
			$datos['mo_codigo'] = $this->input->post('motivo');

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

			#JS - Formulario
			$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
			$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

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
				"medicos" => $this->objMedicos->listar(),
				"funcionarios" => $this->objFuncionario->listar(),
				"motivos" => $this->objMotivo->listar(),
				"solicitud_pacientes" => $this->objSolicitudPaciente->listar(array("so_codigo" => $codigo))
			);

			$solicitud_pacientes = array();
			foreach($contenido["solicitud_pacientes"] as $sol_pac){
				$solicitud_pacientes[] = $sol_pac->pa_codigo;
			}

			$contenido["pacientes"] = $this->objPaciente->listar("pa_codigo IN (" . implode(",", $solicitud_pacientes) . ")");
			#contenido
			if($contenido['solicitud']){

			}else show_error('');

			#nav
			$this->layout->nav(array("Solicitudes "=>"solicitudes", "Editar Solicitud" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function esp_ser(){
		if($this->input->post()){
			$medico_especialidades = $this->objRel->listar(array("me_codigo" => $this->input->post("codigo")));
			$especialidad = $this->objEspecialidad->obtener(array("es_codigo" => $medico_especialidades[0]->es_codigo));
			$servicio = $this->objServicio->obtener(array("se_codigo" => $especialidad->se_codigo));
			echo json_encode(array("result" => true, "especialidad" => $especialidad, "servicio" => $servicio));
			exit;
		}else{
			redirect(base_url());
		}
	}

	public function motivo(){
		if($this->input->post()){
			$motivo = $this->objMotivo->obtener(array("mo_codigo" => $this->input->post("codigo")));
			$fecha_asignada = date("Y-m-d",strtotime(str_replace("/","-",$this->input->post('fecha_entrega'))));
			
			$day_of_the_week = date("Y-m-d", strtotime($fecha_asignada . "+" . $motivo->dias . " days"));
			$day_of_the_week = date("N", strtotime($day_of_the_week));
			if($day_of_the_week > 5){
				$motivo->dias = $motivo->dias + (abs($day_of_the_week - 7)+1);

			}
			$motivo->fecha_devolucion = date("d/m/Y", strtotime($fecha_asignada . "+" . $motivo->dias . " days"));
			echo json_encode(array("result" => true, "motivo" => $motivo));
			exit;
		}else{
			redirect(base_url());
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
		$html.= "<img src='" . base_url() . "imagenes/template/logo.png' style='width: 10%;'/>";
		$html.= "<h3 style='text-align: center;'>SOLICITUD DE HISTORIAS CLINICAS</h3>";

		$html.="<table style='width: 100%;'>";
		$html.="<tr>";
		$html.="<td><b>PROFESIONAL:</b></td>";

		if($solicitud->medico){
			$html.="<td>" . $solicitud->medico->nombres . " " . $solicitud->medico->apellidos . "</td>";
		}else{
			$html.="<td>" . $solicitud->nombre_medico . "</td>";
		}
		
		$html.="<td><b>ANEXO:</b></td>";
		$html.="<td>" . $solicitud->anexo . "</td>";
		$html.="</tr>";

		$html.="<tr>";
		$html.="<td><b>ESPECIALIDAD:</b></td>";
		if($solicitud->medico){
			$solicitud->medico->especialidad = $this->objRel->obtener(array("me_codigo" => $solicitud->medico->codigo));
			$solicitud->medico->especialidad = $this->objEspecialidad->obtener(array("es_codigo" => $solicitud->medico->especialidad->es_codigo));
			$html.="<td>" . $solicitud->medico->especialidad->nombre . "</td>";
		}else{
			$html.="<td></td>";
		}
		$html.="<td><b>FONO:</b></td>";
		$html.="<td>" . $solicitud->telefono . "</td>";
		$html.="</tr>";

		$html.="<tr>";
		$html.="<td><b>SERVICIO:</b></td>";
		if($solicitud->medico){
			$solicitud->medico->servicio = $this->objServicio->obtener(array("se_codigo" => $solicitud->medico->especialidad->se_codigo));
			$html.="<td>" . $solicitud->medico->servicio->nombre . "</td>";
		}else{
			$html.="<td></td>";
		}
		$html.="<td><b>CELULAR:</b></td>";
		$html.="<td>" . $solicitud->celular . "</td>";
		$html.="</tr>";

		$html.="<tr>";
		$html.="<td><b>LUGAR FISICO HHCC:</b></td>";
		if($solicitud->medico){
			$solicitud->medico->unidad = $this->objUnidad->obtener(array("un_codigo" => $solicitud->medico->servicio->un_codigo));
			$html.="<td>" . $solicitud->medico->unidad->nombre . "</td>";
		}else{
			$html.="<td></td>";
		}
		$html.="<td><b>F. EMISION:</b></td>";
		$html.="<td>" . formatearFecha(substr($solicitud->fecha_emision, 0, 10)) . "</td>";
		$html.="</tr>";

		$html.="<tr>";
		$html.="<td><b>MOTIVO:</b></td>";
		$html.="<td>" . $solicitud->motivo->nombre . "</td>";
		$html.="<td><b>F. SOLICITUD:</b></td>";
		$html.="<td>" . formatearFecha(substr($solicitud->fecha_asignada, 0, 10)) . "</td>";
		$html.="</tr>";

		$html.="<tr>";
		$html.="<td><b>DETALLE:</b></td>";
		$html.="<td>" . $solicitud->detalle . "</td>";
		$html.="<td><b>F. ENTREGA:</b></td>";
		$html.="<td>" . formatearFecha(substr($solicitud->fecha_entrega, 0, 10)) . "</td>";
		$html.="</tr>";


		$html.="</table>";

		$html.= "<h3 style='text-align: center;'>PACIENTES</h3>";
		$html.="<table style='width: 100%; border-collapse: collapse; border: 1px solid black;'>";
		$html.="<tr>";
		$html.="<td style='border: 1px solid black;'>#</td>";
		$html.="<td style='border: 1px solid black;'><b>N PACIENTE</b></td>";
		$html.="<td style='border: 1px solid black;'><b>RUT PACIENTE</b></td>";
		$html.="<td style='border: 1px solid black;'><b>NOMBRE PACIENTE</b></td>";
		$html.="<td style='border: 1px solid black;'><b>OK</b></td>";
		$html.="</tr>";
		$i = 1;
		foreach($solicitud->pacientes as $paciente){
			$html.="<tr>";
			$html.="<td style='border: 1px solid black;'>" . $i . "</td>";
			$html.="<td style='border: 1px solid black;'>" . $paciente->hhcc . "</td>";
			$html.="<td style='border: 1px solid black;'>" . $paciente->rut . "</td>";
			$html.="<td style='border: 1px solid black;'>" . $paciente->nombres . " " . $paciente->apellidos . "</td>";
			$html.="<td style='border: 1px solid black;'></td>";
			$i++;
			$html.="</tr>";
		}
		$html.="</table>";
		$html.= "</div>";
		
		$rutaPdf = "/hospital/archivos/";
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
			mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
		$rutaPdf .= "pdf/";
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
			mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
			
		$nombrePdf = "pdf".time().'.pdf';
		
		ob_start();
		$mpdf = new mPDF('utf-8','','','',0,0,0,0,6,3); 
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetTitle('Solicitudes');
		$mpdf->SetAuthor('HOSPITAL CHILLAN');
		$mpdf->WriteHTML($html, 2);


		if($solicitud->documento){
			$mpdf->AddPage();
			$extension = explode(".",$solicitud->documento);
			$extension = array_pop($extension);
			$extension = strtolower($extension);
			if($extension == "pdf"){
				$mpdf->SetImportUse();
				$pagecount = $mpdf->SetSourceFile($solicitud->documento);
				for ($i=1; $i<=$pagecount; $i++){
			        $import_page = $mpdf->ImportPage($i);
			        $mpdf->UseTemplate($import_page);
			        if ($i < $pagecount) $mpdf->AddPage();
			    }
			}else{
				$html = "<div style='padding: 20px; font-size: small;'>";
				$html.="<img src='" . $solicitud->documento . "'>";
				$html.= "</div>";

				$mpdf->WriteHTML($html, 2);
			}
		}

		$mpdf->Output($_SERVER['DOCUMENT_ROOT'].$rutaPdf.$nombrePdf,'F');
		$rutaPdf = base_url() . "archivos/pdf/";
		redirect($rutaPdf.$nombrePdf);
	}
	
}