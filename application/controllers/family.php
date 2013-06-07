<?php
class Family extends CI_Controller {

	function index(){
		$this->login();
	}

	function login(){
    if($this->session->userdata('logged_in'))
    {   
      redirect('dashboard');
    }   
		else{
			$data['content'] = 'login_form';
			$this->load->view('includes/template', $data);
		}
	}

	function get_inventory(){
		$family_name = $this->session->userdata('family_name');
		$this->load->model('inventory_model');
		$query = $this->inventory_model->get_bid_inventory($family_name);

		$result = array();
		$i = 0;
		foreach($query->result_array() as $row){
			$result[$i] = $row;
			$i++;
		}
		echo json_encode($result);
	}

	function get_status(){
		$this->load->model('family_model');
		$this->load->model('crop_model');
		$this->load->model('lmu_model');
		$this->load->model('water_model');
		$this->load->model('animal_model');
		$family_name = $this->session->userdata('family_name');

		$family_query = $this->family_model->get_members($family_name);
		$crop_query = $this->crop_model->get_all_planted_crops($family_name);
		$water_query = $this->water_model->get_family_water($family_name);
		$well_query = $this->water_model->get_family_well_water($family_name);
		$animal_query = $this->animal_model->get_family_animals($family_name);

		$num_members = $family_query->num_rows();

		$available_labor = 0;
		$used_labor = 0;
		$grain = $num_members * 300;
		$milk = $num_members * 50;
		$used_water = $num_members * 8;
		$available_water = 0;

		foreach($water_query->result() as $row){
			$available_water += $row->rate * $row->hours;
			$used_labor += $row->hours / 10;
		}

		foreach($well_query->result() as $row){
			$available_water += $row->pumpingRate * $row->hours;
			$used_labor += $row->hours / 10;
		}

		foreach($crop_query->result() as $row){
			$acres = $this->lmu_model->get_acres($row->lmu_id);
			if($row->irrigation){
				$used_water += $acres * $row->land_percentage * 50 / 100;
			}
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

		$status = array(
			'grain' => $grain,
			'milk' => $milk,
			'used_water' => $used_water,
			'available_water' => $available_water,
			'used_labor' => $used_labor,
			'available_labor' => $available_labor
		);

		echo json_encode($status);
	}

	function get_date(){
		$this->load->model('family_model');
		$query = $this->family_model->get_date();
		echo json_encode($query->result_array());
	}

	function logout(){
		$this->session->sess_destroy();
		redirect('family');
	}

	function signup(){
		$data['content'] = 'signup_form';
		$this->load->view('includes/template', $data);
	}

	function validate_credentials(){
		$this->load->model('family_model');
		if($this->family_model->validate()){
			$this->session->set_userdata($this->family_model->get_session_data());
			redirect('dashboard');
		}
		else redirect('family');
	}

	function create_family(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Family Name', 'trim|required|min_length[4]|max_lenth[20]|is_unique[family.name]|alpha');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|max_length[50]|is_unique[family.email]');
		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|max_length[32]|alpha_dash');
		$this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password1]');

		if($this->form_validation->run()){
			$this->load->model('family_model');
			if($this->family_model->create_family()){
				$data['content'] = 'success';
				$data['message'] = 'Success!  Thank you for creating an account, please follow the link below to login.';
				$data['url'] = site_url("family/login");
				$data['button'] = "Login";
				$this->load->view('includes/template', $data);
			}
			else echo "Database Error!!!";
		}
		else{
			$data['content'] = 'error';
			$data['url'] = site_url("family/signup");;
			$this->load->view('includes/template', $data);
		}
	}

}
