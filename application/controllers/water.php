<?php

class Water extends CI_Controller{

  function __construct(){   
    parent::__construct();
    if(!$this->session->userdata('logged_in'))
    {   
      redirect('family');
    }   
  }

	function update_method(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('method_id', 'Water Collection Method', 'trim|required');
		$this->form_validation->set_rules('hours', 'Updated Hours', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('water_model');

			$family_name = $this->session->userdata('family_name');
			$method_id = $this->input->post('method_id');
			$hours = $this->input->post('hours');
			$json = array('success' => 
				$this->water_model->update_method($family_name, $method_id, $hours));

			echo json_encode($json);
		}
		else echo validation_errors();
	}

	function get_method(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('method_id', 'Water Collection Method', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('water_model');

			$family_name = $this->session->userdata('family_name');
			$method_id = $this->input->post('method_id');

			$query = $this->water_model->get_method($family_name, $method_id);

			echo json_encode($query->result_array());
		}
		else echo validation_errors();
	}

	function get_well(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('lmu_id', 'LMU ID', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('water_model');

			$lmu_id = $this->input->post('lmu_id');

			$query = $this->water_model->get_well($lmu_id);

			echo json_encode($query->result_array());
		}
		else echo validation_errors();
	}

	function buy_well(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('lmu_id', 'LMU ID', 'trim|required');
		$this->form_validation->set_rules('well_type_id', 'Well Type', 'trim|required');
		$this->form_validation->set_rules('cost', 'Cost', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('water_model');
			$this->load->model('inventory_model');

			$family_name = $this->session->userdata('family_name');
			$price = $this->input->post('cost');
			$lmu_id = $this->input->post('lmu_id');
			$well_type_id = $this->input->post('well_type_id');

			if($this->inventory_model->get_resource('4', $family_name)->row()->quantity < $price){
				echo json_encode(array('success' => 0));
			}
			else{
				$this->inventory_model->update_resource_quantity('4', $family_name, -$price);
				$this->water_model->buy_well($lmu_id, $well_type_id);
				echo json_encode(array('success' => 1));
			}
		}
		else echo validation_errors();
	}

	function update_well_hours(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('lmu_id', 'LMU ID', 'trim|required');
		$this->form_validation->set_rules('hours', 'Hours', 'trim|required|numeric');

		if($this->form_validation->run()){
			$this->load->model('water_model');

			$lmu_id = $this->input->post('lmu_id');
			$hours = $this->input->post('hours');

			$this->water_model->update_well_hours($lmu_id, $hours);

			echo json_encode(array('success' => 1));
		}
		else echo validation_errors();
	}

	function check_hours(){
		$this->load->library('form_validation');
		$this->load->model('family_model');
		$labor = $this->family_model->get_labor();
		$hours = $this->input->post('hours');
		$this->form_validation->set_rules('hours', 'Hours', 'trim|required|numeric');

		if($this->form_validation->run()){
			if($hours != 0 && $labor['a']  - ($labor['u'] + $hours) < 0){
				echo json_encode(array('success' => 0, 'fail' => 'labor'));	
			}
			else echo json_encode(array('success' => 1));
		}
		else{
			echo json_encode(array('success' => 0, 'fail' => 'form'));
		}
	}

}
