<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Anaqueles extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_anaqueles", "objAnaquel");
		$this->load->model("bodegas/modelo_bodegas", "objBodega");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 5;
	}

	public function index($pagina = 1){
		#Title
		$this->layout->title('Anaqueles');

		#Metas
		$this->layout->setMeta('title','Anaqueles');
		$this->layout->setMeta('description','Anaqueles');
		$this->layout->setMeta('keywords','Anaqueles');

		#js
		$this->layout->js('js/sistema/anaqueles/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "an_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'anaqueles/';
		$config['total_rows'] = count($this->objAnaquel->listar($where));
		$config['per_page'] = 15;
		$config['suffix'] = $url;
		$config['first_url'] = base_url() . '/anaqueles'.$url;

		$this->pagination->initialize($config);

		$contenido['datos'] = $this->objAnaquel->listar($where, $pagina, $config['per_page']);

		$contenido['pagination'] = $this->pagination->create_links();

		#La vista siempre,  debe ir cargada al final de la función
		$this->layout->view('index', $contenido);
	}

	public function agregar(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('bodega', 'Bodega', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'an_codigo' => $this->objAnaquel->getLastId(),
				'an_nombre' => $this->input->post('nombre'),
				'bo_codigo' => $this->input->post('bodega')
			);
			
			if($this->objAnaquel->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Anaquel');

			#metas
			$this->layout->setMeta('title','Agregar Anaquel');
			$this->layout->setMeta('description','Agregar Anaquel');
			$this->layout->setMeta('keywords','Agregar Anaquel');

			#js
			$this->layout->js('js/sistema/anaqueles/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#nav
			$this->layout->nav(array("Anaqueles "=> "anaqueles", "Agregar Anaquel" =>"/"));

			$contenido["bodegas"] = $this->objBodega->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('bodega', 'Bodega', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$datos = array(
				'an_nombre' => $this->input->post('nombre'),
				'bo_codigo' => $this->input->post('bodega')
			);

			if($this->objAnaquel->actualizar($datos,array("an_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "anaqueles/");

			#js
			$this->layout->js('js/sistema/anaqueles/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#title
			$this->layout->title('Editar Anaquel');

			#metas
			$this->layout->setMeta('title','Editar Anaquel');
			$this->layout->setMeta('description','Editar Anaquel');
			$this->layout->setMeta('keywords','Editar Anaquel');

			#contenido
			if($contenido['anaquel'] = $this->objAnaquel->obtener(array("an_codigo" => $codigo)));
			else show_error('');

			$contenido["bodegas"] = $this->objBodega->listar();

			#nav
			$this->layout->nav(array("Anaqueles "=>"anaqueles", "Editar Anaquel" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}

	public function estados(){
		try{
			list($rut,$estado) = explode('_',$this->input->post('rut'));
			$this->objAnaquel->actualizar(array("an_estado"=>$estado),array("an_rut"=>$rut));
			echo json_encode(array("result"=>true));
		}
		catch(Exception $e){
			echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
		}
	}
}
