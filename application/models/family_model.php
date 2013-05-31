<?php

class Family_model extends CI_Model{

	function validate(){
		$this->db->where('name', $this->input->post('family_name'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('family');
		return($query->num_rows() == 1);
	}

	function create_family(){
		$family_insert_data = array(
			'email' => $this->input->post('email_address'),
			'name' => $this->input->post('name'),
			'password' => md5($this->input->post('password2'))
		);

		return($this->db->insert('family', $family_insert_data));
	}

	function get_session_data(){
		$this->db->where('name', $this->input->post('family_name'));
		$this->db->select('name, id');
		$query = $this->db->get('family');
		$row = $query->row();
 		$session_data = array('family_name' => $row->name,'logged_in' => true, 'family_id' => $row->id);
		return($session_data);
	}

	function get_family($name){
		$this->db->where('name', $name);
		return($this->db->get('family'));
	}

	function get_members($family_name){
		$query = $this->db->query("
			SELECT age, sex, health 
			FROM member
			WHERE family_name = '$family_name'
			AND health > 0
			ORDER BY age DESC
		");
		return($query);
	}

	function get_date(){
		$this->db->select('year, month, week, day');
		$this->db->order_by('year', 'DESC');
		$this->db->order_by('month', 'DESC');
		$this->db->order_by('week', 'DESC');
		$this->db->order_by('day', 'DESC');
		$this->db->limit(1);
		return($this->db->get('game_params'));
	}

	
}
