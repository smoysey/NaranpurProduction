<?php

class Dashboard extends CI_Controller{

  function __construct(){   
    parent::__construct();
    if(!$this->session->userdata('logged_in'))
    {   
      redirect('family');
    }   
  }

	function index(){
		$data['content'] = 'dashboard_view';
		$data['name'] = $this->session->userdata('family_name');
		$data['id'] = $this->session->userdata('family_id');
		$this->load->view('includes/template', $data);
	}

}
