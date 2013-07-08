<?php
class Listing extends CI_Controller{

	function __construct(){   
		parent::__construct();
		if(!$this->session->userdata('logged_in')){   
			redirect('family');
		}  
	}

	function index(){
		redirect('listing/view_all_listings');
	}

	function view_all_listings($resource_id = -1, $offset = 0){
		$this->load->model("listing_model");
		$this->load->model("inventory_model");

		$this->load->model('update_model');
		$family_name = $this->session->userdata('family_name');
		$this->update_model->clear_updates($family_name, 'bid');

		if($resource_id == -1){
			$data['listings'] = $this->listing_model->get_all_listings($offset);
		}
		else{
			$data['listings'] = $this->listing_model->get_select_listings($resource_id, $offset);
		}
		$data['total'] = $this->listing_model->get_listing_count($resource_id);
		$data['prev'] = $offset - 10;
		$data['next'] = $offset + 10;
		$data['res_id'] = $resource_id;
		$data['resources'] = $this->inventory_model->get_store_inventory();
		$family_name = $this->session->userdata('family_name');
		$data['listing_inventory'] = $this->inventory_model->get_sell_inventory($family_name);
		$data['content'] = 'all_listings_view';
		$this->load->view('includes/template', $data);
	}

	function my_listings($resource_id = -1, $offset = 0){
		$this->load->model("listing_model");
		$this->load->model("inventory_model");
		$family_name = $this->session->userdata('family_name');
		if($resource_id == -1){
			$data['listings'] = $this->listing_model->get_family_listings($family_name, $offset);
		}
		else{
			$data['listings'] = $this->listing_model->get_select_family_listings($family_name, $resource_id, $offset);
		}
		$data['total'] = $this->listing_model->get_listing_count($resource_id);
		$data['prev'] = $offset - 10;
		$data['next'] = $offset + 10;
		$data['res_id'] = $resource_id;
		$data['resources'] = $this->inventory_model->get_store_inventory();
		$data['listing_inventory'] = $this->inventory_model->get_sell_inventory($family_name);
		$data['content'] = 'all_listings_view';
		$this->load->view('includes/template', $data);
	}

	function view_listing($listing_id){
		$this->load->model("listing_model");
		$listing = $this->listing_model->get_listing($listing_id);
		if($listing->num_rows() != 1)	echo "Not a valid listing";
		else{
			$this->load->model("bid_model");
			$data['bids'] = $this->bid_model->get_bids($listing_id);
			$data['family_name'] = $this->session->userdata('family_name');
			$data['listing'] = $listing;
			$data['content'] = 'view_listing';
			$this->load->view('includes/template', $data);
		}
	}

	function load_create_bid($listing_id){
		$this->load->model("listing_model");
		$family_name = $this->session->userdata('family_name');
		$listing_query = $this->listing_model->get_listing($listing_id);
		if($listing_query->num_rows() != 1 || $listing_query->row()->family_name == $family_name){
			echo "Not a valid listing";
		}
		else{
			$this->load->model("inventory_model");
			$data['listing'] = $listing_query;
			$data['listing_id'] = $listing_id;
			$data['bid_inventory'] = $this->inventory_model->get_bid_inventory($family_name);
			$data['content'] = 'create_bid_view';
			$this->load->view('includes/template', $data);
		}
	}

	function create_bid(){
		$this->load->model("bid_model");
		$resource_id = $this->input->post('resource_id');
		$listing_id = $this->input->post('listing_id');
		$quantity = $this->input->post('quantity');
		$family_name = $this->session->userdata('family_name');
		$message = $this->input->post('message');

		if($this->bid_model->create_bid($resource_id, $quantity, $listing_id, $family_name, $message)){
			$this->load->model('listing_model');
			$this->load->model('update_model');
			$seller = $this->listing_model->get_seller($listing_id);
			$this->update_model->create_notification($seller, 'bid');
			redirect('listing');
		}
		else echo "Database Error";
	}

	function create_listing(){
		$this->load->model("listing_model");
		$this->load->model("inventory_model");
		$resource_id = $this->input->post('resource_id');
		$quantity = $this->input->post('quantity');
		$message = $this->input->post('message');
		$family_name = $this->session->userdata('family_name');

		$actual_res = $this->inventory_model->get_resource_quantity($resource_id, $family_name);
		if($actual_res < $quantity) echo "You do not have the inventory to process this transaction.";
		else{
			$this->inventory_model->update_resource_quantity(
				$resource_id,
				$family_name,
				-$quantity
			);

			if($this->listing_model->create_listing($resource_id, $quantity, $family_name, $message)){
				redirect('listing');
			}
			else echo "Database Error";
		}
	}

	function accept_bid(){
		$this->load->model("listing_model");
		$this->load->model("bid_model");
		$this->load->model("inventory_model");

		$listing_id = $this->input->post('listing_id');
		$bid_id = $this->input->post('bid_id');

		$listing = $this->listing_model->get_listing($listing_id);
		$bid = $this->bid_model->get_bid($bid_id);

		if(!$this->inventory_model->check_resource($bid->row()->resource_id,
																									 $bid->row()->family_name,
																									 $bid->row()->quantity)){
				echo "The bidder no longer has the inventory for this transaction";
				$this->bid_model->delete_bid($bid->row()->id);
		}
		else{
			// Update the listers inventory
			$this->inventory_model->update_resource_quantity(
				$bid->row()->resource_id,
				$listing->row()->family_name,
				$bid->row()->quantity
			);

			// Update the bidders inventory
			$this->inventory_model->update_resource_quantity(
				$listing->row()->resource_id,
				$bid->row()->family_name,
				$listing->row()->quantity
			);
			$this->inventory_model->update_resource_quantity(
				$bid->row()->resource_id,
				$bid->row()->family_name,
				-$bid->row()->quantity
			);

			$this->listing_model->end_listing($listing->row()->id, 0);
			$this->load->model('transaction_model');
			$this->transaction_model->create_transaction($listing_id, $bid_id);

			$this->load->model('update_model');
			$this->update_model->create_notification($bid->row()->family_name, 'win');

			redirect('listing');
		}

	}

	function delete_listing($listing_id){
		$this->load->model("listing_model");
		$this->load->model("inventory_model");
		$listing = $this->listing_model->get_listing($listing_id);

		$this->inventory_model->update_resource_quantity(
			$listing->row()->resource_id,
			$listing->row()->family_name,
			$listing->row()->quantity
		);

		$this->listing_model->end_listing($listing_id, 2);
		redirect('listing');
	}
}
