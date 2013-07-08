<?php
class Notifications_model extends CI_Model{

	function get_notifications($family_name){
		$this->db->where('family_name', $family_name);
		return($this->db->get('notification'));
	}

	function clear_notifications($family_name){
		$this->db->where('family_name', $family_name);
		return($this->db->update('notification', array('seen' => 1)));
	}

	function delete_notification($id){
		return($this->db->delete('notification', array('id' => $id)));
	}	
}
