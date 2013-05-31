<?php

class Messages_model extends CI_Model{

	function send_message(){
		$message_insert_data = array(
			'sender_name' => $this->session->userdata('family_name'),
			'reciever_name' => $this->input->post('reciever_name'),
			'subject' => $this->input->post('subject'),
			'body' => $this->input->post('body')
		);

		return($this->db->insert('message', $message_insert_data));
	}

	function box_pagination($limit, $offset, $sort_by, $sort_order, $box){
		$sort_order = ($sort_order == 'asc') ? 'asc' : 'desc';
		$sort_columns = array('sender_name','reciever_name', 'sent_date', 'subject', 'body');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'sent_date';
		$userName = $this->session->userdata('family_name');

    if($box == 'inbox') {
      $field = 'reciever_name';
      $vis=2;
    } else { 
      $field = 'sender_name';
      $vis=1;
    }   

    $query0 = "SELECT * FROM message
              WHERE $field='$userName'
              AND (vis=3 OR vis=$vis)";

    $query1 = "SELECT * FROM message
              WHERE $field='$userName'
              AND (vis=3 OR vis=$vis)
              ORDER BY $sort_by $sort_order
              LIMIT $limit
              OFFSET $offset";

    $result = 

    $data['total_rows'] = $this->db->query($query0)->num_rows();
    $data['messages'] = $this->db->query($query1);

    return($data);
	}

	function get_message($id){
		$this->db->where('id', $id);
		$this->db->select('id, sender_name, reciever_name, sent_date, subject, body, vis');
		$query = $this->db->get('message');
		if($query->num_rows() != 1) return(FALSE);
		else return($query);
	}

	function remove_messages($messages, $box){
		if($box == 'outbox'){
			foreach($messages as $id):
				$msg = $this->get_message($id)->row();
				$this->db->where('id', $msg->id);
				$this->db->update('message', array('vis' => ($msg->vis == 3 ? 2 : 0))); 
			endforeach;
		}
		else{
			foreach($messages as $id):
				$msg = $this->get_message($id)->row();
				$this->db->where('id', $msg->id);
				$this->db->update('message', array('vis' => ($msg->vis == 3 ? 1 : 0))); 
			endforeach;
		}
	}

}
