<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Divisiones extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("modelo_divisiones", "objDivision");
		$this->load->model("anaqueles/modelo_anaqueles", "objAnaquel");
		$this->load->model("inicio/modelo_funcionarios", "objFuncionario");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 6;
	}

	public function index(){
		#Title
		$this->layout->title('Divisiones');

		#Metas
		$this->layout->setMeta('title','Divisiones');
		$this->layout->setMeta('description','Divisiones');
		$this->layout->setMeta('keywords','Divisiones');

		#js
		$this->layout->js('js/sistema/divisiones/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "di_nombre like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'divisiones/';
		$config['total_rows'] = count($this->objDivision->listar($where));
		$config['per_page'] = 15;
		$config['uri_segment'] = $segment = 3;
		$config['suffix'] = $url;
		$config['first_url'] = '/divisiones'.$url;

		$this->pagination->initialize($config);
		$page = ($this->uri->segment($segment))?$this->uri->segment($segment)-1:0;

		$contenido['datos'] = $this->objDivision->listar($where);

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
			$this->form_validation->set_rules('rango_min', 'Rango Mínimo', 'required');
			$this->form_validation->set_rules('rango_max', 'Rango Máximo', 'required');
			$this->form_validation->set_rules('anaquel', 'Anaquel', 'required');
			$this->form_validation->set_rules('funcionario', 'Funcionario', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			if($this->input->post('rango_min') >= $this->input->post('rango_max')){
				echo json_encode(array("result"=>false,"msg"=>"Rango Mínimo debe ser mayor a Rango Máximo"));
				exit;
			}
			
			$datos = array(
				'di_codigo' => $this->objDivision->getLastId(),
				'di_nombre' => $this->input->post('nombre'),
				'di_rango_min' => $this->input->post('rango_min'),
				'di_rango_max' => $this->input->post('rango_max'),
				'an_codigo' => $this->input->post('anaquel'),
				'fu_codigo' => $this->input->post('funcionario')
			);
			
			if($this->objDivision->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar División');

			#metas
			$this->layout->setMeta('title','Agregar División');
			$this->layout->setMeta('description','Agregar División');
			$this->layout->setMeta('keywords','Agregar División');

			#js
			$this->layout->js('js/sistema/divisiones/agregar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#nav
			$this->layout->nav(array("Divisiones "=> "divisiones", "Agregar División" =>"/"));

			$contenido["anaqueles"] = $this->objAnaquel->listar();

			$contenido["funcionarios"] = $this->objFuncionario->listar(array("fu_estado" => 1));

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('nombre', 'Nombre', 'required');
			$this->form_validation->set_rules('rango_min', 'Rango Mínimo', 'required');
			$this->form_validation->set_rules('rango_max', 'Rango Máximo', 'required');
			$this->form_validation->set_rules('anaquel', 'Anaquel', 'required');
			$this->form_validation->set_rules('funcionario', 'Funcionario', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			if($this->input->post('rango_min') >= $this->input->post('rango_max')){
				echo json_encode(array("result"=>false,"msg"=>"Rango Mínimo debe ser mayor a Rango Máximo"));
				exit;
			}

			$datos = array(
				'di_nombre' => $this->input->post('nombre'),
				'di_rango_min' => $this->input->post('rango_min'),
				'di_rango_max' => $this->input->post('rango_max'),
				'an_codigo' => $this->input->post('anaquel'),
				'fu_codigo' => $this->input->post('funcionario')
			);

			if($this->objDivision->actualizar($datos,array("di_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "divisiones/");

			#js
			$this->layout->js('js/sistema/divisiones/editar.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#title
			$this->layout->title('Editar División');

			#metas
			$this->layout->setMeta('title','Editar División');
			$this->layout->setMeta('description','Editar División');
			$this->layout->setMeta('keywords','Editar División');

			#contenido
			if($contenido['division'] = $this->objDivision->obtener(array("di_codigo" => $codigo)));
			else show_error('');

			$contenido["anaqueles"] = $this->objAnaquel->listar();

			$contenido["funcionarios"] = $this->objFuncionario->listar(array("fu_estado" => 1));

			#nav
			$this->layout->nav(array("Divisiones "=>"divisiones", "Editar División" =>"/"));
			$this->layout->view('editar',$contenido);

		}
	}
}
