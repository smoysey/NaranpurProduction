<?php
class Discussion_model extends CI_Model {
	function submit_topic(){
		$insert_topic = array(
    	                    'name' => $this->session->userdata('family_name'),
      	                  'subject' => $this->input->post('subject'),
        	                'content' => $this->input->post('content')
												 );
		return($this->db->insert('discussion', $insert_topic));
	}	

	function submit_comment(){
  	$insert_topic = array(
													'diss_id' => $this->input->post('diss_id'),
													'name' => $this->session->userdata('family_name'),
													'comment' => $this->input->post('content')
												 );
		$this->db->insert('comments', $insert_topic);
		return($this->input->post('diss_id'));
	}

	function get_all_topics() {
		return $this->db->get('discussion');
	}

	function get_all_comments($diss_id) {
		$this->db->select('c.comment, c.timestamp,d.id, c.name');
		$this->db->from('comments c');
		$this->db->join('discussion d', 'd.id = c.diss_id'); //this joins the comments table to discussion
		$this->db->where('d.id', $diss_id);
		return $this->db->get();
	}

	function get_topics($sort_by, $sort_order, $offset){
		$sort_order = ($sort_order == 'ASC') ? 'ASC' : 'DESC';
		$sort_columns = array('timestamp', 'subject', 'name', 'comments');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'timestamp';
		$offset = ($offset % 10 == 0) ? $offset : 0;

		$query = $this->db->query("
      SELECT discussion.*, COUNT(comments.diss_id) as comments
      FROM discussion
      LEFT JOIN comments ON comments.diss_id = discussion.id
      GROUP BY discussion.id
      ORDER BY $sort_by $sort_order
      LIMIT 10
			OFFSET $offset
		");

		return($query);
	}

	function get_comments($diss_id, $sort_by, $sort_order, $offset){
		$sort_order = ($sort_order == 'ASC') ? 'ASC' : 'DESC';
		$sort_columns = array('timestamp', 'name');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'timestamp';
		$offset = ($offset % 10 == 0) ? $offset : 0;

		$query = $this->db->query("
      SELECT comments.* 
      FROM comments 
			WHERE diss_id = $diss_id
      ORDER BY $sort_by $sort_order
      LIMIT 10
			OFFSET $offset
		");

		return($query);
	}

	function get_discussion($id){
		$this->db->where('id', $id);
		return($this->db->get('discussion'));
	}

}
?>
