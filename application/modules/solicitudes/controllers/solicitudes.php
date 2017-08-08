<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Solicitudes extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		$this->load->model("inicio/modelo_funcionarios", "objFuncionario");
		$this->load->model("medicos/modelo_medicos", "objMedicos");
		$this->load->model("modelo_motivo_solicitud", "objMotivo");
		$this->load->model("modelo_solicitud", "objSolicitud");
		$this->layout->current = 2;
		$this->layout->subCurrent = 8;
	}

	public function index(){
		#Title
		$this->layout->title('Solicitudes');

		#Metas
		$this->layout->setMeta('title','Solicitudes');
		$this->layout->setMeta('description','Solicitudes');
		$this->layout->setMeta('keywords','Solicitudes');

		#js
		$this->layout->js('js/sistema/solicitudes/index.js');

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
		$config['base_url'] = base_url() . 'solicitudes/';
		$config['total_rows'] = count($this->objSolicitud->listar($where));
		$config['per_page'] = 15;
		$config['uri_segment'] = $segment = 3;
		$config['suffix'] = $url;
		$config['first_url'] = '/solicitudes'.$url;

		$this->pagination->initialize($config);
		$page = ($this->uri->segment($segment))?$this->uri->segment($segment)-1:0;

		$contenido['datos'] = $this->objSolicitud->listar($where);

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
			$this->form_validation->set_rules('paciente', 'Paciente', 'required');
			$this->form_validation->set_rules('medico', 'Medico', 'required');
			$this->form_validation->set_rules('funcionario', 'Funcionario', 'required');
			$this->form_validation->set_rules('fecha', 'Fecha', 'required');

			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			$datos = array(
				'so_codigo' => $this->objSolicitud->getLastId(),
				'so_fecha_emision' => date("Y-m-d H:i:s"),
				'so_fecha_asignada' => $this->input->post('fecha'),
				'fu_rut' => $this->input->post('funcionario'),
				'me_rut' => $this->input->post('medico'),
				'pa_rut' => $this->input->post('paciente'),
			);
			
			if($this->objSolicitud->insertar($datos)){
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false,"msg"=>"Error al guardar registro."));
				exit;
			}
		}else{
			#title
			$this->layout->title('Agregar Solicitud');

			#metas
			$this->layout->setMeta('title','Agregar Solicitud');
			$this->layout->setMeta('description','Agregar Solicitud');
			$this->layout->setMeta('keywords','Agregar Solicitud');

			#JS - Datepicker
			$this->layout->css('js/jquery/ui/1.10.4/ui-lightness/jquery-ui-1.10.4.custom.min.css');
			$this->layout->js('js/jquery/ui/1.10.4/jquery-ui-1.10.4.custom.min.js');
			$this->layout->js('js/jquery/ui/1.10.4/jquery.ui.datepicker-es.js');

			#JS - Multiple select boxes
			$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
			$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

			#js
			$this->layout->js('js/sistema/solicitud/agregar.js');

			#nav
			$this->layout->nav(array("Solicitud "=> "solicitudes", "Agregar Solicitud" =>"/"));

			$contenido = array(
				"pacientes" => $this->objPaciente->listar(),
				"medicos" => $this->objMedicos->listar(),
				"funcionarios" => $this->objFuncionario->listar(),
				"motivos" => $this->objMotivo->listar(),
				"objSolicitud" => $this->objMotivo->listar()
			);

			$this->layout->view('agregar', $contenido);
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
	
}