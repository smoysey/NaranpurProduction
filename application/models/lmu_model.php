<?php
class Lmu_model extends CI_Model{

	function valid_owner($family_name, $lmu_id){
		$this->db->where('family_name', $family_name);
		$this->db->where('id', $lmu_id);
		$query = $this->db->get('lmu');
		return($query->num_rows() == 1);
	}

	function get_acres($lmu_id){
		$query = $this->db->query("
			SELECT COUNT(*) as acres
			FROM land_unit
			WHERE land_unit.lmu_id = $lmu_id
		");
		return($query->row()->acres);
	}

	function get_owners(){
		$this->db->select('id, family_name');
		return($this->db->get('lmu'));
	}

	function get_lmus(){
		return($this->db->get('lmu'));
	}

	function get_lmu_type($lmu_id){
		$this->db->select('type');
		$this->db->where('id', $lmu_id);
		return($this->db->get('lmu'));
	}

	function get_paths(){
		$this->db->order_by('lmu_id', 'ASC');
		$this->db->order_by('pos', 'ASC');
		return($this->db->get('lmu_paths'));
	}

}
