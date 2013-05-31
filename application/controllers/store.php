<?php
class Store extends CI_Controller{

	function __construct(){   
		parent::__construct();
		if(!$this->session->userdata('logged_in'))
		{   
			redirect('family');
		}  
	}

	function index(){
		$this->load->model("inventory_model");
		$family_name = $this->session->userdata('family_name');
		$data['buy_inventory'] = $this->inventory_model->get_store_inventory();
		$data['sell_inventory'] = $this->inventory_model->get_sell_inventory($family_name);
		$data['cash'] = $this->inventory_model->get_resource('4', $family_name)->row()->quantity;
		$data['content'] = 'store_view';
		$this->load->view('includes/template', $data);
	}

	function buy(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('buyItem', 'Resource', 'trim|required');
		$this->form_validation->set_rules('buyQuantity', 'Quantity', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('inventory_model');
			$this->load->model('resource_model');

			$family_name = $this->session->userdata('family_name');
			$resource_id = $this->input->post('buyItem');
			$quantity = $this->input->post('buyQuantity');

			$world_res = $this->resource_model->get_resource($resource_id);
			$player_res = $this->inventory_model->get_resource($resource_id, $family_name);

			$price = $world_res->row()->buyPrice;

			// Update player Cash
			$this->inventory_model->update_resource_quantity('4', $family_name, - ($price * $quantity));
			// Update global Resource Quantity
			$this->resource_model->update_resource_quantity($resource_id, ($world_res->row()->quantity - $quantity));
			// Update player Resource Quantity
			$this->inventory_model->update_resource_quantity($resource_id, $family_name, $quantity);
			redirect('store');
		}
		else echo "Form Error";
	
	}

	function sell(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('sellItem', 'Resource', 'trim|required');
		$this->form_validation->set_rules('sellQuantity', 'Quantity', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('inventory_model');
			$this->load->model('resource_model');

			$family_name = $this->session->userdata('family_name');
			$resource_id = $this->input->post('sellItem');
			$quantity = $this->input->post('sellQuantity');

			$world_res = $this->resource_model->get_resource($resource_id);
			$player_res = $this->inventory_model->get_resource($resource_id, $family_name);

			$price = $world_res->row()->sellPrice;

			// Update player Cash
			$this->inventory_model->update_resource_quantity('4', $family_name, ($price * $quantity));
			// Update player Resource Quantity
			$this->inventory_model->update_resource_quantity($resource_id, $family_name, -$quantity);
			// Update global Resource Quantity
			$this->resource_model->update_resource_quantity($resource_id, ($world_res->row()->quantity + $quantity));

			redirect('store');
		}
	
		else echo "Form Error";
	
	}
	

}
