<?php
class Modelo_conformidad extends CI_Model {
	private $tabla;
	private $prefijo;
	
	function __construct(){
		$this->tabla = "conformidad";
		$this->prefijo = substr($this->tabla, 0, 2) . "_";
		$this->load->model("pacientes/modelo_pacientes", "objPaciente");
		$this->load->model("motivo_conforme/modelo_motivo_conforme", "objMotivo");
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
	
	public function listar($where = false){
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
				$obj->motivo = $this->objMotivo->obtener(array("tc_codigo" => $obj->tc_codigo));
				$obj->paciente = $this->objPaciente->obtener(array("pa_codigo" => $obj->pa_codigo));
				unset($obj->tc_codigo);
				unset($obj->pa_codigo);
				$listado[] = $obj;
			}
			return $listado;
        }else {
			return false;
        }
    }
}