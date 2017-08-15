<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Medicos extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_medicos", "objMedico");
		$this->load->model("modelo_medicos_especialidades", "objRel");
		$this->load->model("especialidades/modelo_especialidad", "objEspecialidad");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 3;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Médicos');

		#Metas
		$this->layout->setMeta('title','Médicos');
		$this->layout->setMeta('description','Médicos');
		$this->layout->setMeta('keywords','Médicos');

		#js
		$this->layout->js('js/sistema/medicos/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "CONCAT(me_nombres, ' ', me_apellidos) like '%$q%' or me_rut like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'medicos/';
		$config['total_rows'] = count($this->objMedico->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/medicos'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objMedico->listar($where, $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('nombres', 'Nombres', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
			$this->form_validation->set_rules('estado', 'Estado', 'required');
			//$this->form_validation->set_rules('especialidad', 'Especialidad', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			if($this->objMedico->obtener(array("me_rut" => $this->input->post('rut')))){
				echo json_encode(array("result"=>false,"msg"=>"El RUT ya existe en el sistema"));
				exit;
			}

			if($this->objMedico->obtener(array("me_email" => $this->input->post('email')))){
				echo json_encode(array("result"=>false,"msg"=>"El Email ya existe en el sistema"));
				exit;
			}
			
			$datos = array(
				'me_codigo' => $this->objMedico->getLastId(),
				'me_rut' => $this->input->post('rut'),
				'me_nombres' => $this->input->post('nombres'),
				'me_apellidos' => $this->input->post('apellidos'),
				'me_email' => $this->input->post('email'),
				'me_estado' => $this->input->post('estado')
			);
			
			if($this->objMedico->insertar($datos)){
				$especialidades = array();
				foreach($this->input->post("especialidad") as $especialidad){
					if(!in_array($especialidad, $especialidades)){
						$rel = array(
							"me_codigo" => $datos["me_codigo"],
							"es_codigo" => $especialidad
						);
						$this->objRel->insertar($rel);
					}
					$especialidades[] = $especialidad;
				}
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Médico');

			#metas
			$this->layout->setMeta('title','Agregar Médico');
			$this->layout->setMeta('description','Agregar Médico');
			$this->layout->setMeta('keywords','Agregar Médico');

			#js
			$this->layout->js('js/sistema/medicos/agregar.js');

			#RUT
			$this->layout->js('js/jquery/validador-rut/jquery.Rut.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#nav
			$this->layout->nav(array("Médicos "=> "medicos", "Agregar Médico" =>"/"));

			$contenido["especialidades"] = $this->objEspecialidad->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){
			#validaciones
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('nombres', 'Nombres', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
			$this->form_validation->set_rules('estado', 'Estado', 'required');
			$this->form_validation->set_rules('especialidad', 'Especialidad', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$medico = $this->objMedico->obtener(array("me_codigo" => $codigo));

			if($medico->rut != $this->input->post('rut')){
				if($this->objMedico->obtener(array("me_rut" => $this->input->post('rut')))){
					echo json_encode(array("result"=>false,"msg"=>"El RUT ya existe en el sistema"));
					exit;
				}
			}

			if($medico->email != $this->input->post('email')){
				if($this->objMedico->obtener(array("me_email" => $this->input->post('email')))){
					echo json_encode(array("result"=>false,"msg"=>"El Email ya existe en el sistema"));
					exit;
				}
			}

			$datos = array(
				'me_rut' => $this->input->post('rut'),
				'me_nombres' => $this->input->post('nombres'),
				'me_apellidos' => $this->input->post('apellidos'),
				'me_email' => $this->input->post('email'),
				'me_estado' => $this->input->post('estado')
			);

			if($this->objMedico->actualizar($datos,array("me_codigo"=>$this->input->post('codigo')))){
				$especialidades = array();
				$this->objRel->eliminar(array("me_codigo" => $this->input->post('codigo')));
				foreach($this->input->post("especialidad") as $especialidad){
					if(!in_array($especialidad, $especialidades)){
						$rel = array(
							"me_codigo" => $this->input->post('codigo'),
							"es_codigo" => $especialidad
						);
						$this->objRel->insertar($rel);
					}
					$especialidades[] = $especialidad;
				}
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "medicos/");
			#js
			$this->layout->js('js/sistema/medicos/editar.js');

			#RUT
			$this->layout->js('js/jquery/validador-rut/jquery.Rut.js');

			#title
			$this->layout->title('Editar Médico');

			#metas
			$this->layout->setMeta('title','Editar Médico');
			$this->layout->setMeta('description','Editar Médico');
			$this->layout->setMeta('keywords','Editar Médico');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#contenido
			if($contenido['medico'] = $this->objMedico->obtener(array("me_codigo" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Médicos "=>"medicos", "Editar Médico" =>"/"));
			$contenido["especialidades"] = $this->objEspecialidad->listar();
			$contenido["medico_especialidades"] = $this->objRel->listar(array("me_codigo" => $codigo));
			$medico_especialidades = array();
			foreach($contenido["medico_especialidades"] as $med_esp){
				$medico_especialidades[] = $med_esp->es_codigo;
			}
			$contenido["medico_especialidades"] = $medico_especialidades;
			$this->layout->view('editar',$contenido);

		}
	}

	public function estados(){
		try{
			list($codigo,$estado) = explode('-',$this->input->post('codigo'));
			$this->objMedico->actualizar(array("me_estado"=>$estado),array("me_codigo"=>$codigo));
			echo json_encode(array("result"=>true));
		}
		catch(Exception $e){
			echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
		}
	}

	public function especialidades(){
		$especialidades = $this->objEspecialidad->listar();
		$html = "<select name='especialidad[]' class='form-control especialidad'><option selected>Seleccione</option>";
		foreach($especialidades as $especialidad){
			$html.= "<option value='" . $especialidad->codigo . "'>" . $especialidad->nombre . "</option>";
		}
		$html.= "</select>";
		echo json_encode(array("result"=>true, "html" => $html));
		exit;
	}
}
