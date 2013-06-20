<?php
class Transaction extends CI_Controller{

	function __construct(){   
		parent::__construct();
		if(!$this->session->userdata('logged_in')){   
			redirect('family');
		}  
	}

	function index(){
		$this->view_all_transactions();
	}

	function view_all_transactions($resource_id = -1, $offset = 0){
		$this->load->model("transaction_model");
		$this->load->model("listing_model");
		$this->load->model("bid_model");
		$this->load->model("inventory_model");

		$this->load->model('update_model');
		$family_name = $this->session->userdata('family_name');
		$this->update_model->clear_updates($family_name, 'win');

		if($resource_id == -1) $trans = $this->transaction_model->get_all_transactions($offset);
		else $trans = $this->transaction_model->get_specific_transactions($resource_id, $offset);

		$i = 0;
		if($trans['query']->num_rows() == 0) $res = 0;
		else{
			foreach($trans['query']->result() as $t){
				$res[$i]['time'] = $t->time;
				$res[$i]['listing'] = $this->listing_model->get_completed_listing($t->listing_id);
				$res[$i]['bid'] = $this->bid_model->get_bid($t->bid_id);
				$i++;
			}
		}

		$data['trans'] = $res;
		$data['next'] = $offset + 10;
		$data['prev'] = $offset - 10;
		$data['res_id'] = $resource_id;
		$data['total'] = $trans['total']; 
		$data['resources'] = $this->inventory_model->get_store_inventory();
		$data['content'] = 'all_transactions_view';
		$this->load->view('includes/template', $data);
	}

	function my_transactions($resource_id = -1){
		$this->load->model("listing_model");
		$this->load->model("bid_model");
		$this->load->model("inventory_model");
		$family_name = $this->session->userdata('family_name');
		$data['resources'] = $this->inventory_model->get_store_inventory();
		$data['content'] = 'all_transactions_view';
		$this->load->view('includes/template', $data);
	}


}
