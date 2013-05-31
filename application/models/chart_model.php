<?php
class Chart_model extends CI_Model {
	function get_world_data($lookup){
		$this->db->select("week, $lookup");
		$this->db->order_by('week','desc');
		$this->db->limit('5');
		return($this->db->get('historic_data'));
	}

	function get_user_data($family_name, $lookup){
		$this->db->select("week, $lookup");
		$this->db->where('family_name', $family_name);
		$this->db->order_by('week','desc');
		$this->db->limit('5');
		return($this->db->get('historic_data_user'));
	}

	function get_avg_data($lookup){
		$query = $this->db->query("
			SELECT week, AVG($lookup) as $lookup
			FROM historic_data_user 
			GROUP BY week
			ORDER BY week DESC
			LIMIT 5
		");
		return($query);
	}

}
