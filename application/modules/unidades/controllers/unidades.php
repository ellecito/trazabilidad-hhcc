<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Unidades extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_unidades", "objUnidad");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 10;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Unidades');

		#Metas
		$this->layout->setMeta('title','Unidades');
		$this->layout->setMeta('description','Unidades');
		$this->layout->setMeta('keywords','Unidades');

		#js
		$this->layout->js('js/sistema/unidades/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "un_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'unidades/';
		$config['total_rows'] = count($this->objUnidad->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/unidades'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objUnidad->listar($where, $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'un_codigo' => $this->objUnidad->getLastId(),
				'un_nombre' => $this->input->post('nombre')
			);
			
			if($this->objUnidad->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Unidad');

			#metas
			$this->layout->setMeta('title','Agregar Unidad');
			$this->layout->setMeta('description','Agregar Unidad');
			$this->layout->setMeta('keywords','Agregar Unidad');

			#js
			$this->layout->js('js/sistema/unidades/agregar.js');

			#nav
			$this->layout->nav(array("Unidades "=> "unidades", "Agregar Unidad" =>"/"));

			$this->layout->view('agregar');
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'un_nombre' => $this->input->post('nombre')
			);

			if($this->objUnidad->actualizar($datos,array("un_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "unidades/");
			#js
			$this->layout->js('js/sistema/unidades/editar.js');

			#title
			$this->layout->title('Editar Unidad');

			#metas
			$this->layout->setMeta('title','Editar Unidad');
			$this->layout->setMeta('description','Editar Unidad');
			$this->layout->setMeta('keywords','Editar Unidad');

			#contenido
			if($contenido['unidad'] = $this->objUnidad->obtener(array("un_codigo" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Unidades "=>"unidades", "Editar Unidad" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}
}
