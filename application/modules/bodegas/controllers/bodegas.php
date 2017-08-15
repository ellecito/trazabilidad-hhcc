<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Bodegas extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_bodegas", "objBodega");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 4;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Bodegas');

		#Metas
		$this->layout->setMeta('title','Bodegas');
		$this->layout->setMeta('description','Bodegas');
		$this->layout->setMeta('keywords','Bodegas');

		#js
		$this->layout->js('js/sistema/bodegas/index.js');

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
		$config['base_url'] = base_url() . 'bodegas/';
		$config['total_rows'] = count($this->objBodega->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/bodegas'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objBodega->listar($where, $pagina, $config['per_page']);

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
				'bo_codigo' => $this->objBodega->getLastId(),
				'bo_nombre' => $this->input->post('nombre')
			);
			
			if($this->objBodega->insertar($datos)){
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
			$this->layout->js('js/sistema/bodegas/agregar.js');

			#nav
			$this->layout->nav(array("Bodegas "=> "bodegas", "Agregar Bodega" =>"/"));

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
				'bo_nombre' => $this->input->post('nombre')
			);

			if($this->objBodega->actualizar($datos,array("bo_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "bodegas/");
			#js
			$this->layout->js('js/sistema/bodegas/editar.js');

			#title
			$this->layout->title('Editar Bodega');

			#metas
			$this->layout->setMeta('title','Editar Bodega');
			$this->layout->setMeta('description','Editar Bodega');
			$this->layout->setMeta('keywords','Editar Bodega');

			#contenido
			if($contenido['bodega'] = $this->objBodega->obtener(array("bo_codigo" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Bodegas "=>"bodegas", "Editar Bodega" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function estados(){
		try{
			list($rut,$estado) = explode('_',$this->input->post('rut'));
			$this->objBodega->actualizar(array("bo_estado"=>$estado),array("bo_rut"=>$rut));
			echo json_encode(array("result"=>true));
		}
		catch(Exception $e){
			echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
		}
	}
}
