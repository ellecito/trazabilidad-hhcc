<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Motivo_conforme extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(batc_url());
		$this->load->model("modelo_motivo_conforme", "objMotivo");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 13;
	}

	public function index(){
		#Title
		$this->layout->title('Motivo Conforme');

		#Metas
		$this->layout->setMeta('title','Motivo Conforme');
		$this->layout->setMeta('description','Motivo Conforme');
		$this->layout->setMeta('keywords','Motivo Conforme');

		#js
		$this->layout->js('js/sistema/motivo_conforme/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "tc_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['batc_url'] = base_url() . 'motivo_conforme/';
		$config['total_rows'] = count($this->objMotivo->listar($where));
		$config['per_page'] = 15;
		$config['uri_segment'] = $segment = 3;
		$config['suffix'] = $url;
		$config['first_url'] = '/motivo_conforme'.$url;

		$this->pagination->initialize($config);
		$page = ($this->uri->segment($segment))?$this->uri->segment($segment)-1:0;

		$contenido['datos'] = $this->objMotivo->listar($where);

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

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'tc_codigo' => $this->objMotivo->getLastId(),
				'tc_nombre' => $this->input->post('nombre')
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
			$this->layout->title('Agregar Motivo Conforme');

			#metas
			$this->layout->setMeta('title','Agregar Motivo Conforme');
			$this->layout->setMeta('description','Agregar Motivo Conforme');
			$this->layout->setMeta('keywords','Agregar Motivo Conforme');

			#js
			$this->layout->js('js/sistema/motivo_conforme/agregar.js');

			#nav
			$this->layout->nav(array("Motivo Conforme "=> "motivo-conforme", "Agregar Motivo Conforme" =>"/"));

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
				'tc_nombre' => $this->input->post('nombre')
			);

			if($this->objMotivo->actualizar($datos,array("tc_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(batc_url() . "motivo-conforme/");
			#js
			$this->layout->js('js/sistema/motivo_conforme/editar.js');

			#title
			$this->layout->title('Editar Motivo Conforme');

			#metas
			$this->layout->setMeta('title','Editar Motivo Conforme');
			$this->layout->setMeta('description','Editar Motivo Conforme');
			$this->layout->setMeta('keywords','Editar Motivo Conforme');

			#contenido
			if($contenido['motivo'] = $this->objMotivo->obtener(array("tc_codigo" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Motivo Conforme "=>"motivo-conforme", "Editar Motivo Conforme" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}
}
