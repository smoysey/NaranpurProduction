<?php
Class Charts extends CI_Controller{

	function get_world_data(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lookup', 'Lookup', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('chart_model');
			$lookup = $this->input->post('lookup');
			$query = $this->chart_model->get_world_data($lookup); 
			$x = array();
			$y = array();

			foreach($query->result() as $row){
				array_push($x, $row->week);
				array_push($y, $row->$lookup);
			}

			echo json_encode(array('x' => $x, 'y' => $y));
		}
		else echo validation_errors();
	}

	function get_user_data(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lookup', 'Lookup', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('chart_model');
			$lookup = $this->input->post('lookup');
			$family_name = $this->session->userdata('family_name');
			$user_query = $this->chart_model->get_user_data($family_name, $lookup); 
			$avg_query = $this->chart_model->get_avg_data($lookup); 
			$user_x = array();
			$user_y = array();
			$avg_x = array();
			$avg_y = array();

			foreach($user_query->result() as $row){
				array_push($user_x, $row->week);
				array_push($user_y, $row->$lookup);
			}

			foreach($avg_query->result() as $row){
				array_push($avg_x, $row->week);
				array_push($avg_y, $row->$lookup);
			}

			echo json_encode(array(
				'user' => array('x' => $user_x, 'y' => $user_y),
				'avg' => array('x' => $avg_x, 'y' => $avg_y)
			));
		}
		else echo validation_errors();
	}



}
