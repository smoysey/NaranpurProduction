<?php
	$this->load->view('includes/header');
	if($content != 'login_form' && $content != 'signup_form')$this->load->view('includes/navbar'); 
	$this->load->view('inventory_view'); 
	$this->load->view('needs_view'); 
	$this->load->view('notifications_view'); 
	$this->load->view($content); 
	$this->load->view('includes/footer');
?>
