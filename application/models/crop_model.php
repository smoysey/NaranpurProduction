<?php
class Crop_model extends CI_Model{

	function plant_crop($lmu_id, $crop_id, $land_percentage){
		$data = array(
			'lmu_id' => $lmu_id,
			'crop_id' => $crop_id,
			'health' => '100',
			'yield' => '0',
			'land_percentage' => $land_percentage,
			'irrigation' => 'FALSE',
			'fertilizer' => 'FALSE',
			'pesticide' => 'FALSE'
		);

		return($this->db->insert('crop', $data)); 

	}

	function get_planted_crops($lmu_id){
		$query = $this->db->query("
			SELECT crop.*, available_crop.*
			FROM crop
			JOIN available_crop ON available_crop.id = crop.crop_id
			WHERE crop.lmu_id = $lmu_id
		");

		return($query);
	}

	function get_available_crops($lmu_id){
		return($this->db->query("
			SELECT  *
			FROM available_crop
			WHERE id NOT IN (
				SELECT crop_id
				FROM crop
				WHERE lmu_id = $lmu_id
				)
			"));
	}

	function cultivate_crop($lmu_id, $crop_id, $field){
		return($this->db->query("
			UPDATE crop
   		SET $field  = !$field
 			WHERE lmu_id = $lmu_id AND crop_id = $crop_id
		"));
	}

}
