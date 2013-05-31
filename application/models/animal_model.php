<?php

class Animal_model extends CI_Model{

	function get_animal_policy($family_name, $animal_id){
		if(!$this->check_animal_policy($family_name, $animal_id)){
			$this->create_animal_policy($family_name, $animal_id);
		}

		$query = $this->db->query("
			SELECT resource.name AS animal, feed_method.name AS method, animal_policy.collect_manure AS manure, animal_policy.feed_method_id AS id
			FROM animal_policy
			LEFT JOIN resource ON resource.id = animal_policy.animal_id
			LEFT JOIN feed_method ON feed_method.id = animal_policy.feed_method_id
			WHERE animal_policy.family_name =  '$family_name'
			AND animal_policy.animal_id =  $animal_id
		");

		return($query);
	}

	function get_feed_method($id){
		$query = $this->db->query("
			SELECT resource.name as resource, feed_resources.quantity as quantity, feed_method.name as method
			FROM feed_resources
			LEFT JOIN feed_method ON feed_method.id = feed_resources.method_id
			LEFT JOIN resource ON resource.id = feed_resources.resource_id
			WHERE feed_resources.method_id = $id
		");

		return($query);
	}

	function get_feed_methods(){
		return($this->db->get('feed_method'));
	}

	function update_animal_policy($family_name, $animal_id, $feed_method_id){
		$this->db->where('family_name', $family_name);
		$this->db->where('animal_id', $animal_id);
		return($this->db->update('animal_policy', array('feed_method_id' => $feed_method_id)));
	}

	function update_manure($family_name, $animal_id, $collect_manure){
		$this->db->where('family_name', $family_name);
		$this->db->where('animal_id', $animal_id);
		return($this->db->update('animal_policy', array('collect_manure' => $collect_manure)));
	}

	function create_animal_policy($family_name, $animal_id, $feed_method_id = 7){
		$data = array(
			'family_name' => $family_name,
			'animal_id' => $animal_id,
			'feed_method_id' => $feed_method_id
		);

		return($this->db->insert('animal_policy', $data));
	}

	function check_animal_policy($family_name, $animal_id){
		$this->db->where('family_name', $family_name);
		$this->db->where('animal_id', $animal_id);
		$query = $this->db->get('animal_policy');
		return($query->num_rows() == 1);
	}

}
