<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Especialidades extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_especialidad", "objEspecialidad");
		$this->load->model("servicios/modelo_servicios", "objServicio");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 7;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Especialidades');

		#Metas
		$this->layout->setMeta('title','Especialidades');
		$this->layout->setMeta('description','Especialidades');
		$this->layout->setMeta('keywords','Especialidades');

		#js
		$this->layout->js('js/sistema/especialidades/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "es_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'especialidades/';
		$config['total_rows'] = count($this->objEspecialidad->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/especialidades'.$url;

		$contenido['datos'] = $this->objEspecialidad->listar($where, $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('servicio', 'Servicio', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'es_codigo' => $this->objEspecialidad->getLastId(),
				'es_nombre' => $this->input->post('nombre'),
				'se_codigo' => $this->input->post('servicio')
			);
			
			if($this->objEspecialidad->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Especialidad');

			#metas
			$this->layout->setMeta('title','Agregar Especialidad');
			$this->layout->setMeta('description','Agregar Especialidad');
			$this->layout->setMeta('keywords','Agregar Especialidad');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#js
			$this->layout->js('js/sistema/especialidades/agregar.js');

			#nav
			$this->layout->nav(array("Especialidades "=> "especialidades", "Agregar Especialidad" =>"/"));

			$contenido["servicios"] = $this->objServicio->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('servicio', 'Servicio', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'es_nombre' => $this->input->post('nombre'),
				'se_codigo' => $this->input->post('servicio')
			);

			if($this->objEspecialidad->actualizar($datos,array("es_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "especialidades/");
			#js
			$this->layout->js('js/sistema/especialidades/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#title
			$this->layout->title('Editar Especialidad');

			#metas
			$this->layout->setMeta('title','Editar Especialidad');
			$this->layout->setMeta('description','Editar Especialidad');
			$this->layout->setMeta('keywords','Editar Especialidad');

			#contenido
			if($contenido['especialidad'] = $this->objEspecialidad->obtener(array("es_codigo" => $codigo)));
			else show_error('');

			$contenido["servicios"] = $this->objServicio->listar();

			#nav
			$this->layout->nav(array("Especialidades "=>"especialidades", "Editar Especialidad" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}
}
