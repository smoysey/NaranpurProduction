<?php
class Update_model extends CI_Model{

	function create_notification($family_name, $type){
		$update_data = array('family_name' => $family_name, 'update_type' => $type);
		return($this->db->insert('updates', $update_data));
	}

	function clear_updates($family_name, $type){
		return($this->db->delete('updates', array('family_name' => $family_name, 
																						 'update_type' => $type)));
	}

	function get_updates($family_name){
		$query = $this->db->query("
			SELECT (
		    SELECT COUNT(*)
		    FROM updates
		    WHERE update_type = 'mess' AND family_name = '$family_name'
			) AS mess, (
		    SELECT COUNT(*)
		    FROM notification
		    WHERE seen = 0 AND family_name = '$family_name'
			) AS notif, (
		    SELECT COUNT(*)
		    FROM updates
    		WHERE update_type = 'bid' AND family_name = '$family_name'
			) AS bid, (
    		SELECT COUNT(*)
    		FROM updates
    		WHERE update_type = 'win' AND family_name = '$family_name'
			) AS win
		");
		return($query);
	}

}
