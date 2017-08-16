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

		#JS - Formulario
		$this->layout->js('js/jquery/file-input/jquery.nicefileinput.min.js');
		$this->layout->js('js/jquery/file-input/nicefileinput-init.js');

		$this->layout->js('js/sistema/barra/index.js');
		$this->layout->js('js/sistema/barra/file.js');

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

	public function importar(){
		if($_FILES['archivo']['error'] == 0){
			require APPPATH."libraries/PHPExcel/PHPExcel.php";

			if($_FILES['archivo']['name']==''){
				echo json_encode(array("result"=>false,"msg"=>"Debes subir un archivo"));
				exit;
			}
			
			$uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/archivos/';
			if(!file_exists($uploads_dir)){
				mkdir($uploads_dir,0777);
			}
			$uploads_dir .= "importaciones/";
			if(!file_exists($uploads_dir))
				mkdir($uploads_dir,0777);

			$extension = strtolower((array_pop(explode(".",$_FILES['archivo']['name']))));
			$permitidas = array("xls","xlsx"); #extensiones permitidas
			$name = 'barras_'.time();
			$tmp = $_FILES["archivo"]["tmp_name"];
			
			if(!in_array($extension, $permitidas)){
				echo json_encode(array("result"=>false,"msg"=>"<div>Formato no permitido, solo se acepta xls y xlsx</div>"));
				exit;
			}
			
			move_uploaded_file($tmp, $uploads_dir.$name);
			if(is_file($uploads_dir.$name))
				chmod($uploads_dir.$name, 0777);

			$ext = "Excel5";
			if($extension == "xlsx")
				$ext = "Excel2007";
			
			$objReader = PHPExcel_IOFactory::createReader($ext);
			$objReader->setReadDataOnly(true);
			if(!is_readable($uploads_dir.$name)) {
				echo json_encode(array("result"=>false,"msg"=>"<div>El archivo esta corrupto.</div>"));
				exit;
			}
			$objPHPExcel = $objReader->load($uploads_dir.$name);
			$letra = 'A';
			$i = 2;
			$barras = array();
			while(true){
				$rut = $objPHPExcel->getActiveSheet()->getCell($letra.$i)->getValue();
				$hhcc = $objPHPExcel->getActiveSheet()->getCell($letra++.$i)->getValue();
				$letra = 'A';
				$i++;
				if($rut == "" || $hhcc == "") break;
				$barra = new stdClass();
				$barra->rut = $rut;
				$barra->hhcc = $hhcc;
				$barras[] = $barra;
			}

			$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
			$html = "";
			foreach($barras as $paciente){
				$html.= "<div style='text-align: center; padding-top: 15px;'>";
				$html.= '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($paciente->hhcc, $generator::TYPE_CODE_128)) . '"></br>';
				$html.= "<p>" . $paciente->rut . "</p>";
				$html.= "</div>";
				if($barras[count($barras) - 1] !== $paciente){
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
			echo json_encode(array("result"=>false,"msg"=>"<div>Error.</div>"));
			exit;
		}
	}

	public function ejemplo(){
		

		#libreria PHPExcel en libraries
		require APPPATH."libraries/PHPExcel/PHPExcel.php";
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->
			getProperties()
				->setCreator("Hospital Chillan")
				->setLastModifiedBy("Hospital Chillan")
				->setTitle("Ejemplo Exportar Barra")
				->setSubject("Ejemplo Exportar Barra")
				->setDescription("Ejemplo Exportar Barra")
				->setKeywords("Ejemplo Exportar Barra")
				->setCategory("ejemplo");


		$styleArray = array(
			   'borders' => array(
					 'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
					 ),
			   ),
			    'font'    => array(
				 'bold'      => true,
				 'italic'    => false,
				 'strike'    => false,
			 ),
			'alignment' => array(
					'wrap'       => true,
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'BABDBB')
			),
		);
		
		$styleArraInfo = array(
				'font'    => array(
				 'bold'      => false,
				 'italic'    => false,
				 'strike'    => false,
				 'size' => 10
				 ),
				 'borders' => array(
					 'outline' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('argb' => '000000'),
					 ),
			   ),
			   'alignment' => array(
					'wrap'       => true,
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			  )
		);
		
		
		$styleFont = array(
			 'font'    => array(
				 'bold'      => true,
				 'italic'    => false,
				 'strike'    => false,
			 ),
			'alignment' => array(
					'wrap'       => true,
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
		);

		$objPHPExcel->getActiveSheet()->getStyle('1:3')->applyFromArray($styleFont);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Pedidos');
		
		$i=2;
		$letra = 'A';
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'RUT');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth(35);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, 'HHCC');
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArray);
		
		$i++;

		$letra = "A";
			
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, "18.433.269-8");
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);
			
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letra.$i, "1993000001");
		$objPHPExcel->getActiveSheet()->getStyle($letra++.$i)->applyFromArray($styleArraInfo);

		$objPHPExcel->getActiveSheet()->setTitle("Ejemplo ".date("d-m-Y"));

		$objPHPExcel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Ejemplo_Barras - '.date('d/m/Y').'.xls"');
		header('Cache-Control: max-age=0');
		 
		$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save('php://output');
		exit;
		
	}
	
}