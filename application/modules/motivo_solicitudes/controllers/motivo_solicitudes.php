<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Motivo_solicitudes extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_motivo_solicitudes", "objMotivo");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 9;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Motivo Solicitudes');

		#Metas
		$this->layout->setMeta('title','Motivo Solicitudes');
		$this->layout->setMeta('description','Motivo Solicitudes');
		$this->layout->setMeta('keywords','Motivo Solicitudes');

		#js
		$this->layout->js('js/sistema/motivo_solicitudes/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "mo_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'motivo-solicitudes/';
		$config['total_rows'] = count($this->objMotivo->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/motivo-solicitudes'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objMotivo->listar($where, $pagina, $config['per_page']);

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
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('dias', 'Días', 'required');
			$this->form_validation->set_rules('documento', 'Documento', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'mo_codigo' => $this->objMotivo->getLastId(),
				'mo_nombre' => $this->input->post('nombre'),
				'mo_dias' => $this->input->post('dias'),
				"mo_documento" => $this->input->post('documento')
			);
			
			if($this->objMotivo->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Motivo Solicitud');

			#metas
			$this->layout->setMeta('title','Agregar Motivo Solicitud');
			$this->layout->setMeta('description','Agregar Motivo Solicitud');
			$this->layout->setMeta('keywords','Agregar Motivo Solicitud');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#js
			$this->layout->js('js/sistema/motivo_solicitudes/agregar.js');

			#nav
			$this->layout->nav(array("Motivo Solicitudes "=> "motivo-solicitudes", "Agregar Motivo Solicitud" =>"/"));

			$this->layout->view('agregar');
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('dias', 'Días', 'required');
			$this->form_validation->set_rules('documento', 'Documento', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'mo_nombre' => $this->input->post('nombre'),
				'mo_dias' => $this->input->post('dias'),
				"mo_documento" => $this->input->post('documento')
			);

			if($this->objMotivo->actualizar($datos,array("mo_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "motivo-solicitudes/");

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#js
			$this->layout->js('js/sistema/motivo_solicitudes/editar.js');

			#title
			$this->layout->title('Editar Motivo Solicitud');

			#metas
			$this->layout->setMeta('title','Editar Motivo Solicitud');
			$this->layout->setMeta('description','Editar Motivo Solicitud');
			$this->layout->setMeta('keywords','Editar Motivo Solicitud');

			#contenido
			if($contenido['motivo'] = $this->objMotivo->obtener(array("mo_codigo" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Motivo Solicitudes "=>"motivo-solicitudes", "Editar Motivo Solicitud" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}
}
