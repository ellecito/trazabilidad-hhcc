<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout {
    private $obj;
    private $layout_view;
    private $title = '';
    private $titleDefault = 'Hospital Clínico Herminda Martín';
    private $css_list = array(), $js_list = array();
	private $metas = '';
	private $navegacion = array();
	public $current = '';
	public $subCurrent = '';

    function Layout() {
	
		#obj
        $this->obj =& get_instance();
        $this->layout_view = "layout/default.php";
		
		#CSS		
		//$this->css('https://fonts.googleapis.com/css?family=Titillium+Web:400,400italic,600,600italic,700,700italic');
		$this->css('css/bootstrap.css');
		$this->css('css/sb-admin.css');
		$this->css('css/fonts/font-awesome/css/font-awesome.min.css');
		$this->css('css/hoja-estilos.css');
		
		#js
		$this->js('js/jquery/1.9.1/jquery-1.9.1.min.js');
		$this->js('js/jquery/bootstrap/bootstrap.js');
		
		#notificaciones
		$this->js('js/jquery/noty/packaged/jquery.noty.packaged.js');
		
		$this->css("js/jquery/validation-engine/css/validationEngine.jquery.css");
		$this->js("js/jquery/validation-engine/js/jquery.validationEngine.js");
		$this->js("js/jquery/validation-engine/js/languages/jquery.validationEngine-es.js");
		
        #layout
        if(isset($this->obj->layout_view))
			$this->layout_view = $this->obj->layout_view;
    }

    function view($view, $data = null, $return = false) {
        
		#render template
        $data['content_for_layout'] = $this->obj->load->view($view, $data, true);
		
        #template
        $this->block_replace = true;
        $output = $this->obj->load->view($this->layout_view, $data, $return);
		
        return $output;
    }

    /**
     * Agregar title a la pagina actual
     *
     * @param $title
     */
    function title($title) {
        $this->title = $title.' - '.$this->titleDefault;
    }
	
	function getTitle(){
        return $this->title;
	}

    /**
     * Agregar Javascript a la pagina actual
     * @param $item
     */
    function js($item){
        $this->js_list[] = $item;
    }
	
	function getJs(){
		$js = '';
		if($this->js_list){
			foreach ($this->js_list as $aux){
				$js .= '<script type="text/javascript" src="'. base_url() .$aux.'"></script>
		';
			}
		}
		return $js;
    }

    /**
     * Agregar CSS a la pagina actual
     * @param $item
     */
    function css($item){
        $this->css_list[] = $item;
    }
	
	function getCss(){
		$css = '';
		if($this->css_list){
			foreach ($this->css_list as $aux){
				$css .= '<link rel="stylesheet" type="text/css"  href="'. base_url() . $aux.'" />
		';
			}
		}
		return $css;
    }
	
	/**
     * Agregar Metas a la pagina actual
     * @param $name, $content
     */
    function setMeta($name,$content){
		$meta = new stdClass();
        $meta->name = $name;
        $meta->content = $content;
		$this->metas[] = $meta;
    }
	
	function headMeta() {
		$metas = '';
		if($this->metas){
			foreach($this->metas as $aux){
				$metas .= '<meta name="'.$aux->name.'" content="'.$aux->content.'" />
		';
			}
		}
        return $metas;
    }
	
	/**
     * Agregar Navegacion a la pagina actual
     * @param $nav
     */
    function nav($nav) {
		$this->navegacion = $nav;
    }
	
	function getNav() {
		$html = '';
		if($this->navegacion){
			$html = '<ol class="breadcrumb">';
			$i = 1;
			$ruta_master = '/';
			foreach($this->navegacion as $nombre=>$ruta)
			{
				$ruta_master = base_url() . $ruta."/";
				$html .= ($i==count($this->navegacion))? '<li class="active">'.$nombre.'</li>':'<li><a href="'.$ruta_master.'">'.$nombre.'</a></li>';
				$i++;
			}
			
			 $html .='</ol>';
		}
		return $html;
	}
	
}