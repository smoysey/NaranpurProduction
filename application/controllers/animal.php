<?php

class Animal extends CI_Controller{

  function __construct(){   
    parent::__construct();
    if(!$this->session->userdata('logged_in'))
    {   
      redirect('family');
    }   
  }

	function get_feed_methods(){
		$this->load->model('animal_model');

		$query = $this->animal_model->get_feed_methods();

		$array = $query->result_array();

		echo json_encode($array);
	}

	function get_animal_policy(){
		$this->load->model('animal_model');

		$family_name = $this->session->userdata('family_name');
		$animal_id = $this->input->post('animal_id');

		$query = $this->animal_model->get_animal_policy($family_name, $animal_id);		

		echo json_encode($query->result_array());
	}

	function update_animal_policy(){
		$this->load->model('animal_model');

		$family_name = $this->session->userdata('family_name');
		$animal_id = $this->input->post('animal_id');
		$feed_method_id = $this->input->post('feed_method_id');

		$success = $this->animal_model->update_animal_policy($family_name, $animal_id, $feed_method_id);
		echo json_encode(array('success' => $success));
	}

	function toggle_manure(){
		$this->load->model('animal_model');
		$family_name = $this->session->userdata('family_name');
		$animal_id = $this->input->post('animal_id');
		$manure = $this->input->post('manure');

		$this->animal_model->toggle_manure($family_name, $animal_id, $manure);

		if($this->animal_model->get_manure($family_name, $animal_id)){
			$this->load->model('family_model');
			$labor = $this->family_model->get_labor();

			if($labor['a'] - $labor['u'] < 0){
				$this->animal_model->toggle_manure($family_name, $animal_id, $manure);
				echo json_encode(array('success' => 0, 'manure' => FALSE));
			}
			else echo json_encode(array('success' => 1, 'manure' => TRUE));
		}
		else echo json_encode(array('success' => 1, 'manure' => FALSE));

	}

	function get_feed_method(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('id', 'Feed Method', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('animal_model');

			$id = $this->input->post('id');

			$query = $this->animal_model->get_feed_method($id);

			echo json_encode($query->result_array());
		}
		else echo validation_errors();
	}

}
