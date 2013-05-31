<?php

class Bid_model extends CI_Model{

	function create_bid($resource_id, $quantity, $listing_id, $family_name, $message){
		$bid_insert_data = array(
			'resource_id' => $resource_id,
			'quantity' => $quantity,
			'listing_id' => $listing_id,
			'family_name' => $family_name,
			'message' => $message
		);
		return($this->db->insert('bid', $bid_insert_data));
	}

	function get_bids($listing_id){
		$query = $this->db->query("
			SELECT bid.*, resource.name as resource_name
			FROM bid
			LEFT JOIN resource ON resource.id = bid.resource_id
			WHERE bid.listing_id = $listing_id
		");
		return($query);
	}

	function get_bid($bid_id){
		$query = $this->db->query("
			SELECT bid.*, resource.name as resource_name
			FROM bid 
			LEFT JOIN resource ON resource.id = bid.resource_id
			WHERE bid.id = $bid_id
		");
		return($query);
	}
	
	function delete_bid($bid_id){
		$this->db->where('id', $bid_id);
		$this->db->delete('bid'); 
	}


}
