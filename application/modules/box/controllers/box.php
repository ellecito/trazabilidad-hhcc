<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Box extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_box", "objBox");
		$this->load->model("unidades/modelo_unidades", "objUnidad");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 11;
	}

	public function index(){
		#Title
		$this->layout->title('Box');

		#Metas
		$this->layout->setMeta('title','Box');
		$this->layout->setMeta('description','Box');
		$this->layout->setMeta('keywords','Box');

		#js
		$this->layout->js('js/sistema/box/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "bx_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'box/';
		$config['total_rows'] = count($this->objBox->listar($where));
		$config['per_page'] = 15;
		$config['uri_segment'] = $segment = 3;
		$config['suffix'] = $url;
		$config['first_url'] = '/box'.$url;

		$this->pagination->initialize($config);
		$page = ($this->uri->segment($segment))?$this->uri->segment($segment)-1:0;

		$contenido['datos'] = $this->objBox->listar($where);

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
			$this->form_validation->set_rules('unidad', 'Unidad', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'bx_codigo' => $this->objBox->getLastId(),
				'bx_nombre' => $this->input->post('nombre'),
				'un_codigo' => $this->input->post('unidad')
			);
			
			if($this->objBox->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Box');

			#metas
			$this->layout->setMeta('title','Agregar Box');
			$this->layout->setMeta('description','Agregar Box');
			$this->layout->setMeta('keywords','Agregar Box');

			#js
			$this->layout->js('js/sistema/box/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#nav
			$this->layout->nav(array("Box "=> "box", "Agregar Box" =>"/"));

			$contenido["unidades"] = $this->objUnidad->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('unidad', 'Unidad', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'bx_nombre' => $this->input->post('nombre'),
				'un_codigo' => $this->input->post('unidad')
			);

			if($this->objBox->actualizar($datos,array("bx_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "box/");

			#js
			$this->layout->js('js/sistema/box/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#title
			$this->layout->title('Editar Box');

			#metas
			$this->layout->setMeta('title','Editar Box');
			$this->layout->setMeta('description','Editar Box');
			$this->layout->setMeta('keywords','Editar Box');

			#contenido
			if($contenido['box'] = $this->objBox->obtener(array("bx_codigo" => $codigo)));
			else show_error('');

			$contenido["unidades"] = $this->objUnidad->listar();

			#nav
			$this->layout->nav(array("Box "=>"box", "Editar Box" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}
}
