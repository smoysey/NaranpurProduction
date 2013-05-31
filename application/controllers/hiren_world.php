<?php
Class World extends CI_Controller{
	function index(){
		$this->load->model('Land_model');
		//$data['content'] = 'worldview';
		$content = 'worldview';
		$data['result'] = $this->Land_model->get_all_lmu();
	//	$this->load->view('includes/template', $data);
 

	$this->load->view('includes/header');
	if($content != 'login_form' && $content != 'signup_form')$this->load->view('includes/navbar'); 
	$this->load->view('inventory_view'); 
//	$this->load->view($content); 
	$this->load->view('frontpage',$data);
	$this->load->view('includes/footer');
	 }

	function getcoord(){
		$this->load->view('landunit');
 	 }

	function display_lmu($family_name, $type){
		
		if(strcmp($this->session->userdata('family_name'),$family_name)!=0)
		{
			$this->load->model('land_model');
			$data['result'] = $this->land_model->get_all_lmu();
//			$data['content'] = 'worldview';
			$content = 'worldview';
		//	$this->load->view('includes/template', $data);
	$this->load->view('includes/header');
	if($content != 'login_form' && $content != 'signup_form')$this->load->view('includes/navbar'); 
	$this->load->view('inventory_view'); 
//	$this->load->view($content); 
	$this->load->view('frontpage',$data);
	$this->load->view('includes/footer');
		}
		else {

		$data['type']=$type;
		$this->load->view('lmu_view',$data);
 	 	}	
	}
	function getvalues(){
		$this->load->model('land_model');
		$data['result'] = $this->land_model->getvalues();
		$this->load->view('view_values',$data);
	}
}
