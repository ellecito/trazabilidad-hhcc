<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Inicio extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model("modelo_funcionarios", "objFuncionario");
		$this->load->model("modelo_email", "objEmail");
	}

	public function index(){
		if($this->session->userdata("usuario")) redirect("/pacientes/");
		#title
		$this->layout->title('Trazabilidad HHCC');
		
		#metas
		$this->layout->setMeta('title','Trazabilidad HHCC');
		$this->layout->setMeta('description','Trazabilidad HHCC');
		$this->layout->setMeta('keywords','Trazabilidad HHCC');
		
		$contenido['home_indicador'] = true;
		
		$this->layout->js('js/sistema/index/login.js');
		$this->layout->js('js/jquery/validador-rut/jquery.Rut.js');
		
		$this->layout->view('inicio',$contenido);
	}
	
	public function recuperar(){
		if($this->input->post("email")){
			$newpass = md5(rand());
			$this->objEmail->recuperar($newpass);
		}else{
			redirect('/');
		}
	}
	
	public function login(){
		
		if($this->input->post()){
			#validacion
			$this->form_validation->set_rules('rut', 'Email', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			$this->form_validation->set_message('required', '* %s es obligatorio');
			//$this->form_validation->set_message('valid_email', '* El email no es válido');
			$this->form_validation->set_error_delimiters('<div>','</div>');
			
			if(!$this->form_validation->run()){
				$error = validation_errors();
				echo json_encode(array("result"=>false,"msg"=>$error));
			}
			else
			{
				try{
					$where = array(
						"fu_rut" => $this->input->post('rut'),
						"fu_password" => md5($this->input->post('password')),
						"fu_estado" => 1
					);
					if($usuario = $this->objFuncionario->obtener($where)){
						$this->session->set_userdata('usuario',$usuario);
						echo json_encode(array("result"=>true));
					}else{
						echo json_encode(array("result"=>false,"msg"=>"Los datos ingresados no son validos."));
					}
				}
				catch(Exception $e){
					echo json_encode(array("result"=>false,"msg"=>$e->getMessage()));
				}
			}
		}else{
			redirect('/');
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('/');
	}

	public function reloj(){
		echo json_encode(array("result" => true, "html" => strftime("%A, %d de %B de %Y, %H:%M:%S", strtotime(date("Y-m-d H:i:s")))));
		exit;
	}
	
}