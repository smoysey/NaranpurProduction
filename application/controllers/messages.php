<?php
class Messages extends CI_Controller{

	function __construct(){   
		parent::__construct();
		if(!$this->session->userdata('logged_in'))
		{   
			redirect('family');
		}  
	}

	function index(){
		$this->inbox();
	}

	function inbox($sort_by = 'sent_date', $sort_order = 'desc', $offset = 0){
		$this->load->model('update_model');
		$family_name = $this->session->userdata('family_name');
		$this->update_model->clear_updates($family_name, 'mess');
		$this->box_pag($sort_by, $sort_order, $offset, 'inbox');
	}
	
	function outbox($sort_by = 'sent_date', $sort_order = 'desc', $offset = 0){
		$this->box_pag($sort_by, $sort_order, $offset, 'outbox');
	}

	function box_pag($sort_by, $sort_order, $offset, $box){
		$data['content'] = 'box';
		$data['box'] = $box;
		$this->load->model('messages_model');
		$limit = 10;
		$data['fields'] = array(
														'sender_name'  => 'From',
														'reciever_name'  => 'To',
														'subject'   => 'Subject',
														'sent_date'    => 'Date'
														);
		$data['sort_by'] = $sort_by;
		$data['sort_order'] = $sort_order;

		$model_data = $this->messages_model->box_pagination($limit, $offset, $sort_by, $sort_order, $box);

    $this->load->library('pagination');
		$config['base_url'] = site_url("messages/$box/$sort_by/$sort_order");
    $config['per_page'] = $limit;
    $config['num_links'] = 5;
		$config['total_rows'] = $model_data['total_rows'];
		$config['uri_segment'] = 5;
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['messages'] = $model_data['messages'];
		$this->load->view('includes/template', $data);
	}

	function compose(){
		$data['content'] = 'compose';
		$this->load->view('includes/template', $data);
	}

	function create_message(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('reciever_name', 'Recipient', 'trim|required|min_length[4]|max_lenth[20]|callback_valid_family');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required|max_length[80]');
		$this->form_validation->set_rules('body', 'Body', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('messages_model');

			$sender_name = $this->session->userdata('family_name');
			$reciever_name = $this->input->post('reciever_name');
			$subject = $this->input->post('subject');
			$body = $this->input->post('body');

			if($this->messages_model->send_message($sender_name,
																						 $reciever_name,
																						 $subject,
																						 $body)){
				$this->load->model('update_model');
				$this->update_model->create_notification($reciever_name, 'mess');
				redirect('messages');
			}
			else{	echo "Send Error.";	}
		}
		else{	echo "Form Error.";	}
	}

	function valid_family($family_name){
		$this->load->model('family_model');
		return($this->family_model->get_family($family_name)->num_rows == 1);
	}

	function view_message($id){
		$data['content'] = 'message_view';
		$this->load->model('messages_model');
		$query = $this->messages_model->get_message($id);
		if(!$query) $this->inbox();
		$data['message'] = $query;
		$this->load->view('includes/template', $data);
	}

	function delete_messages(){
		$this->load->model('messages_model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('msg[]', 'Messages', 'required');
		$box = $this->input->post('box');
		$seg = $this->input->post('seg');
		
		if($this->form_validation->run())
			$box =	$this->messages_model->remove_messages($this->input->post('msg'), $box);
		redirect($seg);
	}

}
