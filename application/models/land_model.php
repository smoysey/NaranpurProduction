<?php
class Land_model extends CI_Model {
	function getvalues(){
		$x = $this->input->post('x');
		$y = $this->input->post('y');
		$res=$this->db->get('landunit');

		foreach($res->result_array() as $r):
			if($r['y2'] > $y){
				$y2=$r['y2'];	
				break;
			}
		endforeach;

		foreach($res->result_array() as $r):
			if($r['x2'] > $x){
				$x2=$r['x2'];	
				break;
			}
		endforeach;		

		$this->db->select('*');
		$this->db->from('landunit l');
		$this->db->where('l.x2', $x2);
		$this->db->where('l.y2', $y2);
		$data['result'] = $this->db->get();

		return $data['result']; 
	}
	
	function get_all_lmu() {
		$this->db->select('*');
		$this->db->from('lmu');
		$query = $this->db->get();
		return($query); 
	}

}
