<?php

class Transaction_model extends CI_Model{

	function create_transaction($listing_id, $bid_id){
		$bid_insert_data = array(
			'listing_id' => $listing_id,
			'bid_id' => $bid_id
		);

		return($this->db->insert('transaction', $bid_insert_data));
	}

	function get_all_transactions($offset){
    $query = $this->db->query("
      SELECT transaction.*
			FROM transaction
			LEFT JOIN listing ON transaction.listing_id = listing.id
			ORDER BY time DESC
      LIMIT 10 OFFSET $offset
    ");
    $count = $this->db->query("
      SELECT transaction.*
			FROM transaction
			LEFT JOIN listing ON transaction.listing_id = listing.id
			ORDER BY time DESC
    ");

    $data['query'] = $query;
    $data['total'] = $count->num_rows();
    return($data);
	}

	function get_specific_transactions($resource_id, $offset){
    $query = $this->db->query("
      SELECT transaction.*
			FROM transaction
			LEFT JOIN listing ON transaction.listing_id = listing.id
			WHERE listing.resource_id = $resource_id
			ORDER BY time DESC
      LIMIT 10 OFFSET $offset
    ");
    $count = $this->db->query("
      SELECT transaction.*
			FROM transaction
			LEFT JOIN listing ON transaction.listing_id = listing.id
			WHERE listing.resource_id = $resource_id
			ORDER BY time DESC
    ");

    $data['query'] = $query;
    $data['total'] = $count->num_rows();
    return($data);
	}


}
