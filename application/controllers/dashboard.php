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
		$this->load->view('includes/template', $data);
	}

	function reports(){
		$data['content'] = 'reports_view';
		$this->load->view('includes/template', $data);
	}

	function help(){
		$data['content'] = 'help_view';
		$this->load->view('includes/template', $data);
	}

}
