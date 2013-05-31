<?php
class Inventory_model extends CI_Model{

	function get_store_inventory(){
		$this->db->where_not_in('quantity', 0);
		$this->db->where_not_in('name', 'cash');
		$this->db->order_by('name');
		$this->db->select('id, name, buyPrice, sellPrice, quantity');
		return($this->db->get('resource'));
	}

	function get_sell_inventory($family_name){
		$query = $this->db->query("SELECT resource.name as name, 
																			resource.sellPrice as sellPrice, 
																			resource.buyPrice as buyPrice, 
																			resource.id as id, 
																			resource.category as cat, 
																			inventory.quantity as quantity
															 FROM resource
															 INNER JOIN inventory
															 ON resource.id = inventory.resource_id
															 WHERE inventory.family_name = '$family_name'
															 AND resource.id != 4
															 ORDER BY name
		");
		return($query);
	}

	function get_bid_inventory($family_name){
		$query = $this->db->query("SELECT resource.name as name, 
																			resource.sellPrice as sellPrice, 
																			resource.buyPrice as buyPrice, 
																			resource.id as id, 
																			inventory.quantity as quantity
															 FROM resource
															 INNER JOIN inventory
															 ON resource.id = inventory.resource_id
															 WHERE inventory.family_name = '$family_name'
															 ORDER BY name
														 ");
		return($query);
	}


	function get_resource($resource_id, $family_name){
		$this->db->where('family_name', $family_name);
		$this->db->where('resource_id', $resource_id);
		return($this->db->get('inventory'));
	}

	function check_resource($resource_id, $family_name, $quantity){
		$query = $this->get_resource($resource_id, $family_name);
		if($query->num_rows() == 0) return(FALSE);
		else return($query->row()->quantity >= $quantity);
	}

	function update_resource_quantity($resource_id, $family_name, $quantity){
		$query = $this->get_resource($resource_id, $family_name);
		if($query->num_rows() == 0 && $quantity > 0){
			return($this->add_resource($resource_id, $family_name, $quantity));
		}
		else if(($query->row()->quantity + $quantity) == 0){
			return($this->remove_resource($resource_id, $family_name));
		}
		else{
			$newAmount = $query->row()->quantity + $quantity;
			$this->db->where('family_name', $family_name);
			$this->db->where('resource_id', $resource_id);
			$this->db->set('quantity', $newAmount);
			return($this->db->update('inventory'));
		}
	}

	function add_resource($resource_id, $family_name, $quantity){
		$data = array(
						'family_name' => $family_name,
						'resource_id' => $resource_id,
						'quantity' => $quantity
						);
		return($this->db->insert('inventory', $data));
	}

	function remove_resource($resource_id, $family_name){
		$this->db->where('family_name', $family_name);
		$this->db->where('resource_id', $resource_id);
		$this->db->delete('inventory');	
	}

	function plant_crop($family_name, $crop_name, $seed_req){
		$this->db->where('name', $crop_name);
		$resource_id = $this->db->get('resource')->row()->id;
		$seed = $this->get_resource($resource_id, $family_name);
		if($seed->num_rows() == 0 || $seed->row()->quantity < $seed_req) return(0);
		else{
			$this->update_resource_quantity($resource_id, $family_name, ($seed->row()->quantity - $seed_req));
			return(1);
		}
	}	

}
