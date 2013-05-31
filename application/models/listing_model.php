<?php

class Listing_model extends CI_Model{

	function create_listing($resource_id, $quantity, $family_name, $message){
		$listing_insert_data = array(
			'resource_id' => $resource_id,
			'quantity' => $quantity,
			'family_name' => $family_name,
			'message' => $message
		);

		return($this->db->insert('listing', $listing_insert_data));
	}

	function get_listing_count($resource_id){
		if($resource_id == -1){
			$query = $this->db->query("
				SELECT *
				FROM listing
				WHERE active = 1
			");
		}
		else{
			$query = $this->db->query("	
				SELECT *
				FROM listing
				LEFT JOIN resource ON resource.id = listing.resource_id
				WHERE listing.active = 1 AND listing.resource_id = $resource_id
			");
		}

		return($query->num_rows());
	}

	function get_all_listings($offset){
		$query = $this->db->query("
			SELECT listing.*, resource.name as resource_name, COUNT(bid.listing_id) as bids
			FROM listing
			LEFT JOIN resource ON resource.id = listing.resource_id
			LEFT JOIN bid ON bid.listing_id = listing.ID
			WHERE listing.active = 1
			GROUP BY listing.id
			ORDER BY id DESC 
      LIMIT 10 OFFSET $offset
		");
		return($query);
	}

	function get_select_listings($resource_id, $offset){
		$query = $this->db->query("
			SELECT listing.*, resource.name as resource_name, COUNT(bid.listing_id) as bids
			FROM listing
			LEFT JOIN resource ON resource.id = listing.resource_id
			LEFT JOIN bid ON bid.listing_id = listing.ID
			WHERE listing.active = 1 AND listing.resource_id = $resource_id
			GROUP BY listing.id
			ORDER BY id DESC 
      LIMIT 10 OFFSET $offset
		");
		return($query);
	}

	function get_family_listings($family_name, $offset){
		$query = $this->db->query("
			SELECT listing.*, resource.name as resource_name, COUNT(bid.listing_id) as bids
			FROM listing
			LEFT JOIN resource ON resource.id = listing.resource_id
			LEFT JOIN bid ON bid.listing_id = listing.ID
			WHERE listing.family_name = '$family_name' AND listing.active = 1
			GROUP BY listing.id
			ORDER BY id DESC 
      LIMIT 10 OFFSET $offset
		");
		return($query);
	}

	function get_select_family_listings($family_name, $resource_id, $offset){
		$query = $this->db->query("
			SELECT listing.*, resource.name as resource_name, COUNT(bid.listing_id) as bids
			FROM listing
			LEFT JOIN resource ON resource.id = listing.resource_id
			LEFT JOIN bid ON bid.listing_id = listing.ID
			WHERE listing.family_name = '$family_name' AND listing.active = 1 AND listing.resource_id = $resource_id
			GROUP BY listing.id
			ORDER BY id DESC 
      LIMIT 10 OFFSET $offset
		");
		return($query);
	}

	function get_listing($listing_id){
		$query = $this->db->query("
			SELECT listing.*, resource.name as resource_name
			FROM listing
			LEFT JOIN resource ON resource.id = listing.resource_id
			WHERE listing.id = $listing_id AND listing.active = 1
		");
		return($query);
	}

	function get_completed_listing($listing_id){
		$query = $this->db->query("
			SELECT listing.*, resource.name as resource_name
			FROM listing
			LEFT JOIN resource ON resource.id = listing.resource_id
			WHERE listing.id = $listing_id AND listing.active = 0
		");
		return($query);
	}

	function end_listing($listing_id, $active){
		$data = array('active' => $active);
		$this->db->where('id', $listing_id);
		$this->db->update('listing', $data); 
	}

	
}
