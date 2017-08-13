<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Funcionarios extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("inicio/modelo_funcionarios", "objFuncionario");
		$this->load->model("modelo_tipo_funcionario", "objTipo");
		#current
		$this->layout->current = 2;
		$this->layout->subCurrent = 2;
	}

	public function index(){
		#Title
		$this->layout->title('Funcionarios');

		#Metas
		$this->layout->setMeta('title','Funcionarios');
		$this->layout->setMeta('description','Funcionarios');
		$this->layout->setMeta('keywords','Funcionarios');

		#js
		$this->layout->js('js/sistema/funcionarios/index.js');

		#filtros
		$where = $contenido['q_f'] = '';
		if($this->input->get('q')){
			$contenido['q_f'] = $q = $this->input->get('q');
			$where = "CONCAT(fu_nombres, ' ', fu_apellidos) like '%$q%' or fu_rut like '%$q%'";
		}

		#url
		$url = explode('?',$_SERVER['REQUEST_URI']);
		if(isset($url[1]))
			$contenido['url'] = $url = '/?'.$url[1];
		else
			$contenido['url'] = $url = '/';

		#paginacion
		$config['base_url'] = base_url() . 'funcionarios/';
		$config['total_rows'] = count($this->objFuncionario->listar($where));
		$config['per_page'] = 15;
		$config['uri_segment'] = $segment = 3;
		$config['suffix'] = $url;
		$config['first_url'] = '/funcionarios'.$url;

		$this->pagination->initialize($config);
		$page = ($this->uri->segment($segment))?$this->uri->segment($segment)-1:0;

		$contenido['datos'] = $this->objFuncionario->listar($where);

		$contenido["tipos"] = $this->objTipo->listar();

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
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('nombres', 'Nombres', 'required');
			$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
			$this->form_validation->set_rules('estado', 'Estado', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			if($this->objFuncionario->obtener(array("fu_rut" => $this->input->post('rut')))){
				echo json_encode(array("result"=>false,"msg"=>"El RUT ya existe en el sistema"));
				exit;
			}

			if($this->objFuncionario->obtener(array("fu_email" => $this->input->post('email')))){
				echo json_encode(array("result"=>false,"msg"=>"El Email ya existe en el sistema"));
				exit;
			}
			
			$datos = array(
				'fu_codigo' => $this->objFuncionario->getLastId(),
				'fu_rut' => $this->input->post('rut'),
				'fu_nombres' => $this->input->post('nombres'),
				'fu_apellidos' => $this->input->post('apellidos'),
				'fu_email' => $this->input->post('email'),
				'fu_password' => md5($this->input->post('password')),
				'ti_codigo' => $this->input->post('tipo'),
				'fu_estado' => $this->input->post('estado')
			);
			
			if($this->objFuncionario->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Funcionario');

			#metas
			$this->layout->setMeta('title','Agregar Funcionario');
			$this->layout->setMeta('description','Agregar Funcionario');
			$this->layout->setMeta('keywords','Agregar Funcionario');

			#js
			$this->layout->js('js/sistema/funcionarios/agregar.js');

			#RUT
			$this->layout->js('js/jquery/validador-rut/jquery.Rut.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#nav
			$this->layout->nav(array("Funcionarios "=> "funcionarios", "Agregar Funcionario" =>"/"));

			$contenido["tipos"] = $this->objTipo->listar();

			$this->layout->view('agregar', $contenido);
		}
	}

	public function editar($codigo = false){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('rut', 'RUT', 'required');
			$this->form_validation->set_rules('nombres', 'Nombres', 'required');
			$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
			$this->form_validation->set_rules('estado', 'Estado', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			$funcionario = $this->objFuncionario->obtener(array("fu_codigo" => $codigo));

			if($funcionario->rut != $this->input->post('rut')){
				if($this->objFuncionario->obtener(array("fu_rut" => $this->input->post('rut')))){
					echo json_encode(array("result"=>false,"msg"=>"El RUT ya existe en el sistema"));
					exit;
				}
			}

			if($funcionario->email != $this->input->post('email')){
				if($this->objFuncionario->obtener(array("fu_email" => $this->input->post('email')))){
					echo json_encode(array("result"=>false,"msg"=>"El Email ya existe en el sistema"));
					exit;
				}
			}

			$datos = array(
				'fu_rut' => $this->input->post('rut'),
				'fu_nombres' => $this->input->post('nombres'),
				'fu_apellidos' => $this->input->post('apellidos'),
				'fu_email' => $this->input->post('email'),
				'ti_codigo' => $this->input->post('tipo'),
				'fu_estado' => $this->input->post('estado')
			);

			if($this->objFuncionario->actualizar($datos,array("fu_codigo"=>$this->input->post('codigo')))){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al actualizar registro."));
				exit;
			}
		}else{
			if(!$codigo) redirect(base_url() . "funcionarios/");

			#js
			$this->layout->js('js/sistema/funcionarios/editar.js');

			#RUT
			$this->layout->js('js/jquery/validador-rut/jquery.Rut.js');

			#title
			$this->layout->title('Editar Funcionario');

			#metas
			$this->layout->setMeta('title','Editar Funcionario');
			$this->layout->setMeta('description','Editar Funcionario');
			$this->layout->setMeta('keywords','Editar Funcionario');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#contenido
			if($contenido['funcionario'] = $this->objFuncionario->obtener(array("fu_codigo" => $codigo)));
			else show_error('');

			#nav
			$this->layout->nav(array("Funcionarios "=>"funcionarios", "Editar Funcionario" =>"/"));
			$contenido["tipos"] = $this->objTipo->listar();
			$this->layout->view('editar',$contenido);

		}
	}

	public function estados(){
		try{
			list($codigo,$estado) = explode('-',$this->input->post('codigo'));
			$this->objFuncionario->actualizar(array("fu_estado"=>$estado),array("fu_codigo"=>$codigo));
			echo json_encode(array("result"=>true));
		}
		catch(Exception $e){
			echo json_encode(array("result"=>false,"msg"=>"Ha ocurrido un error inesperado. Por favor, inténtelo nuevamente."));
		}
	}
}
