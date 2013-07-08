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

	function set_session_data(){
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

	function get_all_families($family_name){
		$query = $this->db->query("
			SELECT family.name
			FROM family
			WHERE family.name !=  '$family_name'
		");
		return($query);
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

	function get_labor(){
		$this->load->model('crop_model');
		$this->load->model('lmu_model');
		$this->load->model('water_model');
		$this->load->model('animal_model');

		$family_name = $this->session->userdata('family_name');

		$family_query = $this->get_members($family_name);
		$crop_query = $this->crop_model->get_all_planted_crops($family_name);
		$water_query = $this->water_model->get_family_water($family_name);
		$well_query = $this->water_model->get_family_well_water($family_name);
		$animal_query = $this->animal_model->get_family_animals($family_name);

		$num_members = $family_query->num_rows();

		$available_labor = 0;
		$used_labor = 0;

		foreach($water_query->result() as $row){
			$used_labor += $row->hours / 10;
		}

		foreach($well_query->result() as $row){
			$used_labor += $row->hours / 10;
		}

		foreach($crop_query->result() as $row){
			$acres = $this->lmu_model->get_acres($row->lmu_id);
			if($row->collect_seeds){
				$used_labor += $acres * $row->land_percentage / 100 * .5;
			}
			$used_labor += $acres * $row->land_percentage / 100;
		}

		foreach($animal_query->result() as $row){
			$used_labor += $row->quantity * .5;
			if($row->manure)	$used_labor += $row->quantity * .5;
		}

		foreach($family_query->result() as $row){
			if($row->age > 12 && $row->age < 16){
				$available_labor += .5 * $row->health / 100;
			}
			else if($row->age > 16){
				$available_labor +=  $row->health / 100;
			}
		}
			return(array('u' => $used_labor, 'a' => $available_labor));
	}
	
}
