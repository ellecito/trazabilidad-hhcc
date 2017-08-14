<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Perfil extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("inicio/modelo_funcionarios", "objFuncionario");
	}

	public function index(){

		if($this->input->post()){

			#validaciones
			$this->form_validation->set_rules('rut', 'Rut', 'required');
			$this->form_validation->set_rules('nombres', 'Nombres', 'required');
			$this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');


			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}

			if($this->session->userdata("usuario")->rut != $this->input->post('rut')){
				if($this->objFuncionario->obtener(array("fu_rut" => $this->input->post('rut')))){
					echo json_encode(array("result"=>false,"msg"=>"El RUT ya existe en el sistema"));
					exit;
				}
			}

			if($this->session->userdata("usuario")->email != $this->input->post('email')){
				if($this->objFuncionario->obtener(array("fu_email" => $this->input->post('email')))){
					echo json_encode(array("result"=>false,"msg"=>"El Email ya existe en el sistema"));
					exit;
				}
			}


			$datos = array(
				"fu_nombres" => $this->input->post('nombres'),
				"fu_rut" => $this->input->post('rut'),
				"fu_apellidos" => $this->input->post('apellidos'),
				"fu_email" => $this->input->post('email')
			);

			if($this->objFuncionario->actualizar($datos,array("fu_codigo"=>$this->session->userdata("usuario")->codigo))){
				$usuario = $this->objFuncionario->obtener(array("fu_codigo"=>$this->session->userdata("usuario")->codigo));
				$this->session->set_userdata('usuario',$usuario);
				echo json_encode(array("result"=>true));
				exit;
			}else{
				echo json_encode(array("result"=>false, "msg" => "Error al actualizar registros."));
				exit;
			}
		}else{

			#js
			$this->layout->js('js/sistema/perfil/index.js');

			#title
			$this->layout->title('Perfil');

			#metas
			$this->layout->setMeta('title','Perfil');
			$this->layout->setMeta('description','Perfil');
			$this->layout->setMeta('keywords','Perfil');
			
			#nav
			$this->layout->nav(array("Perfil"=>"/"));

			$this->layout->view('index');

		}
	}
	
	public function password(){

		if($this->input->post()){
			#validaciones
			$this->form_validation->set_rules('passactual', 'Contraseña Actual', 'required');
			$this->form_validation->set_rules('passnueva', 'Contraseña Nueva', 'required');
			$this->form_validation->set_rules('repetirpass', 'Repetir Contraseña', 'required');


			$this->form_validation->set_message('required', '* %s es obligatorio');
			$this->form_validation->set_error_delimiters('<div>','</div>');

			if(!$this->form_validation->run()){
				echo json_encode(array("result"=>false,"msg"=>validation_errors()));
				exit;
			}
			
			if(!$this->objFuncionario->obtener(array("fu_password" => md5($this->input->post('passactual'))))){
				echo json_encode(array("result"=>false,"msg"=>"<div>Contraseña Incorrecta.</div>"));
				exit;
			}
			
			if($this->input->post('passnueva') != $this->input->post('repetirpass')){
				echo json_encode(array("result"=>false,"msg"=>"<div>Contraseña Actual con Repetir Contraseña no coinciden.</div>"));
				exit;
			}
			
			$datos['fu_password'] = md5($this->input->post('passnueva'));
			$this->objFuncionario->actualizar($datos,array("fu_rut"=>$this->session->userdata("usuario")->rut));

			echo json_encode(array("result"=>true));
		}else{
			redirect("/");
		}
	}
}
