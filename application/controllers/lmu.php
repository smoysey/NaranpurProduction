<?php

class Lmu extends CI_Controller{

  function __construct(){   
    parent::__construct();
    if(!$this->session->userdata('logged_in'))
    {   
      redirect('family');
    }   
  }

	function index(){
		$this->load->model('lmu_model');
		$data['result'] = $this->lmu_model->get_lmus();
		$this->load->view('worldview2',$data);
	}

	function view($lmu_id = -1){
		$this->load->model('lmu_model');
		$family_name = $this->session->userdata('family_name');

		if($lmu_id == -1) $lmu_id = $this->input->post('lmu_id');

		if($this->lmu_model->valid_owner($family_name, $lmu_id)){
			$this->load->model('family_model');
			$this->load->model('crop_model');
			$this->load->model('water_model');
			$this->load->model('resource_model');
			$this->load->model('lmu_model');
			$data['planted_crops'] = $this->crop_model->get_planted_crops($lmu_id);
			$data['available_crops'] = $this->crop_model->get_available_crops($lmu_id);
			$data['water_methods'] = $this->water_model->get_methods($family_name);
			$data['well_options'] = $this->water_model->get_well_options();
			$data['animals'] = $this->resource_model->get_animals($family_name);
			$data['lmu_type'] = $this->lmu_model->get_lmu_type($lmu_id)->row()->type;
			$data['content'] = 'lmu_view';
			$data['name'] = $family_name;
			$data['acres'] = $this->lmu_model->get_acres($lmu_id);
			$data['lmu_id'] = $lmu_id;
			$data['family'] = $this->family_model->get_members($family_name);
			$percent_planted = 0;

			foreach($data['planted_crops']->result() as $pc){
				$percent_planted += $pc->land_percentage;
			}

			$data['percent_planted'] = $percent_planted;

			$this->load->view('includes/template', $data);
		}
		else echo "You do not own this LMU";
	}

	function plant_crop(){
		$this->load->model('crop_model');
		$this->load->model('inventory_model');
		$lmu_id = $this->input->post('lmu_id');
		$crop_id = $this->input->post('crop_id');
		$land_percentage = $this->input->post('land_percentage');
		$resource_id = $this->input->post('resource_id');
		$family_name = $this->session->userdata('family_name');
		$seed_req = $this->input->post('seed_req');

		if($this->crop_model->plant_crop($lmu_id, $crop_id, $land_percentage) && 
				$this->inventory_model->update_resource_quantity($resource_id, 
																												 $family_name,
																												 -$seed_req)){
			redirect("lmu/view/$lmu_id");
		}
		else{	echo "DB Error";	}
	}

	function validate_planting(){
		$this->load->model('inventory_model');
		$resource_id = $this->input->post('resource_id');
		$seed_req = $this->input->post('seed_req');
		$family_name = $this->session->userdata('family_name');
		$query = $this->inventory_model->get_resource($resource_id, $family_name);

		if($query->num_rows() == 0 || $query->row()->quantity < $seed_req){
			echo json_encode(array('success' => 0, 'fail' => 'seed'));	
		}
		else{
			$this->load->model('family_model');
			$this->load->model('lmu_model');
			$lmu_id = $this->input->post('lmu_id');
			$land_percentage = $this->input->post('land_percentage');
			$acres = $this->lmu_model->get_acres($lmu_id);
			$labor = $this->family_model->get_labor();

			if($labor['a'] - ($labor['u'] + ($acres * $land_percentage / 100)) < 0){
				echo json_encode(array('success' => 0, 'fail' => 'labor'));	
			}
			else echo json_encode(array('success' => 1));
		}
	}

	function cultivate_crop(){
		$this->load->model('crop_model');
		$this->load->model('family_model');
		$lmu_id = $this->input->post('lmu_id');
		$crop_id = $this->input->post('crop_id');
		$field = $this->input->post('field');

		if(!$this->crop_model->cultivate_crop($lmu_id, $crop_id, $field)) echo "DB Error";	
		
		$water_check = TRUE;
		$seed_check = TRUE;
		$checked = $this->crop_model->get_cultivation($lmu_id, $crop_id, $field);

		if($checked){
			if($field == 'irrigation'){
				$water = $this->get_water_status();
				if($water['a'] - $water['u'] < 0) $water_check = FALSE;
			}
			else if($field == 'collect_seeds'){
				$labor = $this->family_model->get_labor();
				if($labor['a'] - $labor['u'] < 0){
					$seed_check = FALSE;
					if(!$this->crop_model->cultivate_crop($lmu_id, $crop_id, $field)) echo "DB Error";	
					$checked = FALSE;
				}
			}
		}

		echo json_encode(array('water' => $water_check, 'seed' => $seed_check, 'checked' => $checked));
	}

	function get_water_status(){
		$this->load->model('family_model');
		$this->load->model('crop_model');
		$this->load->model('lmu_model');
		$this->load->model('water_model');
		$this->load->model('inventory_model');
		$family_name = $this->session->userdata('family_name');

		$family_query = $this->family_model->get_members($family_name);
		$crop_query = $this->crop_model->get_all_planted_crops($family_name);
		$water_query = $this->water_model->get_family_water($family_name);
		$well_query = $this->water_model->get_family_well_water($family_name);
		$available_water = $this->inventory_model->get_resource_quantity(17, $family_name);

		$num_members = $family_query->num_rows();

		$used_water = $num_members * 8;

		foreach($water_query->result() as $row){
			$available_water += $row->rate * $row->hours;
		}

		foreach($well_query->result() as $row){
			$available_water += $row->pumpingRate * $row->hours;
		}

		foreach($crop_query->result() as $row){
			$acres = $this->lmu_model->get_acres($row->lmu_id);
			if($row->irrigation){
				$used_water += $acres * $row->land_percentage * 50 / 100;
			}
		}

		return(array('u' => $used_water, 'a' => $available_water));

	}

}
