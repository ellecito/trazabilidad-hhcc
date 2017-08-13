<?php if ( ! defined('BASEPATH')) exit('No puede acceder a este archivo');

class Barra extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		if(!$this->session->userdata("usuario")) redirect(base_url());
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		$this->layout->current = 1;
	}

	public function index(){
		#title
		$this->layout->title('Trazabilidad HHCC');
		
		#metas
		$this->layout->setMeta('title','Trazabilidad HHCC');
		$this->layout->setMeta('description','Trazabilidad HHCC');
		$this->layout->setMeta('keywords','Trazabilidad HHCC');

		#JS - Multiple select boxes
		$this->layout->css('js/jquery/bootstrap-multi-select/dist/css/bootstrap-select.css');
		$this->layout->js('js/jquery/bootstrap-multi-select/js/bootstrap-select.js');

		$this->layout->js('js/sistema/barra/index.js');

		$pacientes = $this->objPaciente->listar();
		
		$this->layout->view('index', array("pacientes" => $pacientes));
	}

	public function imprimir(){
		if($this->input->post()){

			$where = "";
			$and = "";
			if($this->input->post("paciente") != "all"){
				$where = $and . "pa_codigo = " . $this->input->post("paciente");
				$and = " AND ";
			}

			if($this->input->post("estado") != "all"){
				$where = $and . "pa_estado = " . $this->input->post("estado");
			}

			$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

			$html = "";
			$pacientes = $this->objPaciente->listar($where);
			foreach($pacientes as $paciente){
				$html.= "<div style='text-align: center; padding-top: 15px;'>";
				$html.= '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($paciente->hhcc, $generator::TYPE_CODE_128)) . '"></br>';
				$html.= "<p>" . $paciente->rut . "</p>";
				$html.= "</div>";
				if($pacientes[count($pacientes) - 1] !== $paciente){
					$html.= "<pagebreak>";
				}
			}

			$rutaPdf = "/hospital/archivos/";
			if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
				mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
			$rutaPdf .= "pdf/";
			if(!file_exists($_SERVER['DOCUMENT_ROOT'].$rutaPdf))
				mkdir($_SERVER['DOCUMENT_ROOT'].$rutaPdf, 0777);
			
			$nombrePdf = "pdf".time().'.pdf';	 	 
			require APPPATH."/libraries/mpdf/mpdf.php";
			$mpdf->use_embeddedfonts_1252 = true; // false is default
			
			ob_start();
			$mpdf=new mPDF('utf-8',array(50,25),'','',0,0,0,0,6,3); 
			$mpdf->SetDisplayMode('fullpage');
			$mpdf->SetTitle('Nominas');
			$mpdf->SetAuthor('HOSPITAL CHILLAN');
			//$mpdf->WriteHTML(file_get_contents(APPPATH . "/css/bootstrap.css"), 1);
			$mpdf->WriteHTML($html, 2);
			$mpdf->Output($_SERVER['DOCUMENT_ROOT'].$rutaPdf.$nombrePdf,'F');
			echo json_encode(array("result"=>true,"url"=>$rutaPdf.$nombrePdf));
			exit;
			//redirect($rutaPdf.$nombrePdf);
		}else{
			redirect("/");
		}
	}
	
}