<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Servicios extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_servicios", "objServicio");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 12;
	}

	public function index(){
		#Title
		$this->layout->title('Servicios');

		#Metas
		$this->layout->setMeta('title','Servicios');
		$this->layout->setMeta('description','Servicios');
		$this->layout->setMeta('keywords','Servicios');

		#js
		$this->layout->js('js/sistema/servicios/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "se_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'servicios/';
		$config['total_rows'] = count($this->objServicio->listar($where));
		$config['per_page'] = 15;
		$config['uri_segment'] = $segment = 3;
		$config['suffix'] = $url;
		$config['first_url'] = '/servicios'.$url;

		$this->pagination->initialize($config);
		$page = ($this->uri->segment($segment))?$this->uri->segment($segment)-1:0;

		$contenido['datos'] = $this->objServicio->listar($where);

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
				'se_codigo' => $this->objServicio->getLastId(),
				'se_nombre' => $this->input->post('nombre')
			);
			
			if($this->objServicio->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Bodega');

			#metas
			$this->layout->setMeta('title','Agregar Bodega');
			$this->layout->setMeta('description','Agregar Bodega');
			$this->layout->setMeta('keywords','Agregar Bodega');

			#js
			$this->layout->js('js/sistema/servicios/agregar.js');

			#nav
			$this->layout->nav(array("Servicios "=> "servicios", "Agregar Bodega" =>"/"));

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
				'se_nombre' => $this->input->post('nombre')
			);

			if($this->objServicio->actualizar($datos,array("se_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "servicios/");
			#js
			$this->layout->js('js/sistema/servicios/editar.js');

			#title
			$this->layout->title('Editar Bodega');

			#metas
			$this->layout->setMeta('title','Editar Bodega');
			$this->layout->setMeta('description','Editar Bodega');
			$this->layout->setMeta('keywords','Editar Bodega');

			#contenido
			if($contenido['bodega'] = $this->objServicio->obtener(array("se_codigo" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Servicios "=>"servicios", "Editar Bodega" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function estados(){
		try{
			list($rut,$estado) = explode('_',$this->input->post('rut'));
			$this->objServicio->actualizar(array("se_estado"=>$estado),array("se_rut"=>$rut));
			echo json_encode(array("result"=>true));
		}
		catch(Exception $e){
			echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
		}
	}
}
