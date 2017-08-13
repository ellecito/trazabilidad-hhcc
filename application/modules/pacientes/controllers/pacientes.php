<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Pacientes extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_pacientes", "objPaciente");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 1;
	}

	public function index(){
		#Title
		$this->layout->title('Pacientes');

		#Metas
		$this->layout->setMeta('title','Pacientes');
		$this->layout->setMeta('description','Pacientes');
		$this->layout->setMeta('keywords','Pacientes');

		#js
		$this->layout->js('js/sistema/pacientes/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "CONCAT(pa_nombres, ' ', pa_apellidos) like '%$q%' or pa_rut like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'pacientes/';
		$config['total_rows'] = count($this->objPaciente->listar($where));
		$config['per_page'] = 15;
		$config['uri_segment'] = $segment = 3;
		$config['suffix'] = $url;
		$config['first_url'] = '/pacientes'.$url;

		$this->pagination->initialize($config);
		$page = ($this->uri->segment($segment))?$this->uri->segment($segment)-1:0;

		$contenido['datos'] = $this->objPaciente->listar($where);

		$contenido['pagination'] = $this->pagination->create_links();

		#JS - pagination
		#$this->layout->js('/js/jquery/rpage-master/responsive-paginate.js');
		#$this->layout->js('/js/jquery/rpage-master/paginate-init.js');

		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('nombres', 'Nombres', 'required');
			$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
			$this->form_validation->set_rules('estado', 'Estado', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			if($this->objPaciente->obtener(array("pa_rut" => $this->input->post('rut')))){
				echo json_encode(array("result"=>false,"msg"=>"El RUT ya existe en el sistema"));
				exit;
			}

			if($this->objPaciente->obtener(array("pa_hhcc" => $this->input->post('hhcc')))){
				echo json_encode(array("result"=>false,"msg"=>"El HHCC ya existe en el sistema"));
				exit;
			}
			
			$datos = array(
				'pa_codigo' => $this->objPaciente->getLastId(),
				'pa_rut' => $this->input->post('rut'),
				'pa_hhcc' => $this->input->post('hhcc'),
				'pa_nombres' => $this->input->post('nombres'),
				'pa_apellidos' => $this->input->post('apellidos'),
				'pa_estado' => $this->input->post('estado')
			);
			
			if($this->objPaciente->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Paciente');

			#metas
			$this->layout->setMeta('title','Agregar Paciente');
			$this->layout->setMeta('description','Agregar Paciente');
			$this->layout->setMeta('keywords','Agregar Paciente');

			#js
			$this->layout->js('js/sistema/pacientes/agregar.js');

			#RUT
			$this->layout->js('js/jquery/validador-rut/jquery.Rut.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#nav
			$this->layout->nav(array("Pacientes "=> "pacientes", "Agregar Paciente" =>"/"));

			$this->layout->view('agregar');
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('nombres', 'Nombres', 'required');
			$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
			$this->form_validation->set_rules('estado', 'Estado', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$paciente = $this->objPaciente->obtener(array("pa_codigo" => $codigo));

			if($paciente->rut != $this->input->post('rut')){
				if($this->objPaciente->obtener(array("pa_rut" => $this->input->post('rut')))){
					echo json_encode(array("result"=>false,"msg"=>"El RUT ya existe en el sistema"));
					exit;
				}
			}

			if($paciente->hhcc != $this->input->post('hhcc')){
				if($this->objPaciente->obtener(array("pa_hhcc" => $this->input->post('hhcc')))){
					echo json_encode(array("result"=>false,"msg"=>"El HHCC ya existe en el sistema"));
					exit;
				}
			}

			$datos = array(
				'pa_rut' => $this->input->post('rut'),
				'pa_hhcc' => $this->input->post('hhcc'),
				'pa_nombres' => $this->input->post('nombres'),
				'pa_apellidos' => $this->input->post('apellidos'),
				'pa_estado' => $this->input->post('estado')
			);

			if($this->objPaciente->actualizar($datos,array("pa_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "pacientes/");
			#js
			$this->layout->js('js/sistema/pacientes/editar.js');

			#title
			$this->layout->title('Editar Administrador');

			#metas
			$this->layout->setMeta('title','Editar Administrador');
			$this->layout->setMeta('description','Editar Administrador');
			$this->layout->setMeta('keywords','Editar Administrador');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#RUT
			$this->layout->js('js/jquery/validador-rut/jquery.Rut.js');

			#contenido
			if($contenido['paciente'] = $this->objPaciente->obtener(array("pa_codigo" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Pacientes "=>"pacientes", "Editar Paciente" =>"/"));

			$this->layout->view('editar',$contenido);

		}
	}

	public function estados(){
		try{
			list($codigo,$estado) = explode('-',$this->input->post('codigo'));
			$this->objPaciente->actualizar(array("pa_estado"=>$estado),array("pa_codigo"=>$codigo));
			echo json_encode(array("result"=>true));
		}
		catch(Exception $e){
			echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
		}
	}
}
