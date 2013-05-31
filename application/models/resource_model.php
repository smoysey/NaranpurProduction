<?php
class Resource_model extends CI_Model{

	function get_resource($resource_id){
		$this->db->where('id', $resource_id);
		return($this->db->get('resource'));
	}

	function get_buy_price($resource_id){
		$this->db->where('id', $resource_id);
		return($this->db->get('resource')->row()->buyPrice);
	}

	function get_sell_price($resource_id){
		$this->db->where('id', $resource_id);
		return($this->db->get('resource')->row()->sellPrice);
	}

	function get_animals($family_name){
		$query = $this->db->query("
			SELECT inventory.quantity as quantity, resource.name as resource, resource.id as id
			FROM inventory
			LEFT JOIN resource ON resource.id = inventory.resource_id
			WHERE inventory.family_name = '$family_name'
			AND (resource.id = 2 OR resource.id = 12 OR resource.id = 13)
		");
		return($query);
	}

	function get_quantity($resource_id){
		$this->db->where('id', $resource_id);
		return($this->db->get('resource')->row()->quantity);
	}

	function update_resource_quantity($resource_id, $quantity){
		$this->db->where('id', $resource_id);
		$this->db->set('quantity', $quantity);
		return($this->db->update('resource'));
	}

}
