<?php
class Modelo_solicitud extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "solicitud";
		$this->prefijo = substr($this->tabla, 0, 2) . "_";
		$this->load->model("medicos/modelo_medicos", "objMedicos");
		$this->load->model("modelo_motivo_solicitud", "objMotivo");
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		parent::__construct();
	}
	
	public function getLastId(){
		$this->db->select_max("{$this->prefijo}codigo","maximo");
		$sql = $this->db->get($this->tabla);
		return $sql->row()->maximo+1;
	}
	
	public function insertar($datos){
		return $this->db->insert($this->tabla, $datos);
	}
	
	public function actualizar($datos, $where){
		$this->db->where($where);
		return $this->db->update($this->tabla, $datos);
	}
	
	public function obtener($where){
		$sql = $this->db->select('*')
				->from($this->tabla)
				->where($where)
				->limit(1)
				->get();
				
        $resultado = $sql->row();
		
        if($resultado){
			$obj = new stdClass();
			foreach(get_object_vars($resultado) as $key => $val){
				$obj->{str_replace($this->prefijo, "", $key)} = $resultado->{$key};
			}
			return $obj;
        }else{
			return false;
        }
	}
	
	public function listar($where = false, $pagina = false, $cantidad = false){

		if($pagina && $cantidad){
			$desde = ($pagina - 1) * $cantidad;
			$this->db->limit($cantidad, $desde);
		}

		if($cantidad){
			$this->db->limit($cantidad);
		}
		
		if($where) $this->db->where($where);
		$sql = $this->db->select('*')
				->from($this->tabla)
				->get();
				
        $result = $sql->result();
        if($result){
			$listado = array();
			foreach($result as $resultado){
				$obj = new stdClass();
				foreach(get_object_vars($resultado) as $key => $val){
					$obj->{str_replace($this->prefijo, "", $key)} = $resultado->{$key};
				}
				$obj->paciente = $this->objPaciente->obtener(array("pa_codigo" => $obj->pa_codigo));
				$obj->medico = $this->objMedicos->obtener(array("me_codigo" => $obj->me_codigo));
				$obj->motivo = $this->objMotivo->obtener(array("mo_codigo" => $obj->mo_codigo));
				unset($obj->pa_codigo); unset($obj->me_codigo); unset($obj->mo_codigo);
				$listado[] = $obj;
			}
			return $listado;
        }else {
			return false;
        }
    }
}