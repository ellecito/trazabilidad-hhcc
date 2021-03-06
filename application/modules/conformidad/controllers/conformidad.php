<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Conformidad extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		$this->load->model("modelo_conformidad", "objConformidad");
		$this->load->model("motivo_conforme/modelo_motivo_conforme", "objMotivo");
		$this->layout->current = 2;
		$this->layout->subCurrent = 14;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Conformidad');

		#Metas
		$this->layout->setMeta('title','Conformidad');
		$this->layout->setMeta('description','Conformidad');
		$this->layout->setMeta('keywords','Conformidad');

		#js
		$this->layout->js('js/sistema/conformidad/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "co_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'conformidad/';
		$config['total_rows'] = count($this->objConformidad->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/conformidad'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objConformidad->listar($where, $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('paciente', 'Paciente', 'required');
			$this->form_validation->set_rules('motivo', 'Motivo', 'required');
			$this->form_validation->set_rules('detalle', 'Detalle', 'required');
			$this->form_validation->set_rules('cantidad', 'Cantidad', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'co_codigo' => $this->objConformidad->getLastId(),
				'co_fecha' => date("Y-m-d H:i:s"),
				'co_cantidad' => $this->input->post('cantidad'),
				'co_obs' => $this->input->post('detalle'),
				'pa_codigo' => $this->input->post('paciente'),
				'tc_codigo' => $this->input->post('motivo')
			);
			
			if($this->objConformidad->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Conformidad');

			#metas
			$this->layout->setMeta('title','Agregar Conformidad');
			$this->layout->setMeta('description','Agregar Conformidad');
			$this->layout->setMeta('keywords','Agregar Conformidad');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#js
			$this->layout->js('js/sistema/conformidad/agregar.js');

			#nav
			$this->layout->nav(array("Conformidad "=> "conformidad", "Agregar Conformidad" =>"/"));

			$contenido = array(
				"motivos" => $this->objMotivo->listar()
			);

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('paciente', 'Paciente', 'required');
			$this->form_validation->set_rules('motivo', 'Motivo', 'required');
			$this->form_validation->set_rules('detalle', 'Detalle', 'required');
			$this->form_validation->set_rules('cantidad', 'Cantidad', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'co_fecha' => date("Y-m-d H:i:s"),
				'co_cantidad' => $this->input->post('cantidad'),
				'co_obs' => $this->input->post('detalle'),
				'pa_codigo' => $this->input->post('paciente'),
				'tc_codigo' => $this->input->post('motivo')
			);

			if($this->objConformidad->actualizar($datos,array("co_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "conformidad/");

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#JS - Ajax multi select
			$this->layout->js('js/jquery/ajax-bootstrap-select-master/dist/js/ajax-bootstrap-select.js');
			$this->layout->css('js/jquery/ajax-bootstrap-select-master/dist/css/ajax-bootstrap-select.css');

			#js
			$this->layout->js('js/sistema/conformidad/editar.js');

			#title
			$this->layout->title('Editar Conformidad');

			#metas
			$this->layout->setMeta('title','Editar Conformidad');
			$this->layout->setMeta('description','Editar Conformidad');
			$this->layout->setMeta('keywords','Editar Conformidad');

			$contenido = array(
				"conformidad" => $this->objConformidad->obtener(array("co_codigo" => $codigo)),
				"motivos" => $this->objMotivo->listar()
			);

			$contenido["paciente"] = $this->objPaciente->obtener(array("pa_codigo" => $contenido["conformidad"]->pa_codigo));

			#contenido
			if($contenido['conformidad']){

			}else show_error('');

			#nav
			$this->layout->nav(array("Conformidad "=>"conformidad", "Editar Conformidad" =>"/"));
			$this->layout->view('editar',$contenido);

		}
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
	
}