<?php

class Water_model extends CI_Model{

	function get_method($family_name, $method_id){
		if(!$this->check_method($family_name, $method_id)){
			$this->create_method($family_name, $method_id);
		}

		$query = $this->db->query("
			SELECT water_decision.hours, water_method.* 
			FROM water_decision
			LEFT JOIN water_method ON water_method.id = water_decision.water_method_id
			WHERE water_method.id = $method_id
			AND water_decision.family_name =  '$family_name'
		");

		return($query);
	}

	function get_family_water($family_name){
		$query = $this->db->query("
			SELECT *
			FROM water_method
			LEFT JOIN water_decision ON water_method.id = water_decision.water_method_id
			WHERE water_decision.family_name = '$family_name'
		");
		return($query);
	}

	function get_family_well_water($family_name){
		$query = $this->db->query("
			SELECT *
			FROM well_type
			LEFT JOIN well ON well.well_type_id = well_type.id
			LEFT JOIN lmu ON well.lmu_id = lmu.id
			WHERE lmu.family_name = '$family_name'
		");
		return($query);
	}

	function update_method($family_name, $method_id, $hours){
		$this->db->where('family_name', $family_name);
		$this->db->where('water_method_id', $method_id);
		return($this->db->update('water_decision', array('hours' => $hours)));
	}

	function get_methods($family_name){
		$this->load->model('inventory_model');
		$query = $this->inventory_model->get_resource(13, $family_name);
		if(!$query->num_rows())	$this->db->where_not_in('id', 2);
		return($this->db->get('water_method'));
	}

	function get_well_options(){
		$query = $this->db->query("
			SELECT *
			FROM well_type
			WHERE id != 4
		");
		return($query);
	}

	function create_method($family_name, $method_id, $hours = 0){
		$data = array(
			'family_name' => $family_name,
			'water_method_id' => $method_id,
			'hours' => $hours
		);

		return($this->db->insert('water_decision', $data));
	}

	function check_method($family_name, $method_id){
		$this->db->where('family_name', $family_name);
		$this->db->where('water_method_id', $method_id);
		$query = $this->db->get('water_decision');
		return($query->num_rows() == 1);
	}

	function get_well($lmu){
		$query = $this->db->query("
			SELECT well.*, well_type.*
			FROM well
			LEFT JOIN well_type ON well.well_type_id = well_type.id
			WHERE well.lmu_id = $lmu
		");
		return($query);
	}

	function buy_well($lmu_id, $well_type_id){
		$this->db->where('lmu_id', $lmu_id);
		$this->db->update('well', array('well_type_id' => $well_type_id)); 
	}

	function update_well_hours($lmu_id, $hours){
		$this->db->where('lmu_id', $lmu_id);
		$this->db->update('well', array('hours' => $hours)); 
	}
}
