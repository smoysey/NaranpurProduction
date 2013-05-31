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
