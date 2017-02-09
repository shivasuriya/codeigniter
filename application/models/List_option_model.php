<?php 
 class List_option_model extends CI_Model
 {
	public function appt_status($obj)
	{
	 $this->load->model('session_model');
	 $status = $this->session_model->validate_accesstoken($obj['accesstoken']);
	 if($status)
	 {
		$sql = "SELECT option_id,title FROM list_options WHERE list_id='apptstat' ORDER BY seq";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(count($result)>0)
		{
		 $res['msg'] = $result;
		 $res['status'] = "Success";
		}
		else
		{
		 $res['status'] = "Failure";
		 $res['msg'] = "0";
		}
	 }
	 else
	 {
		$res['status'] = "Failure";
		$res['msg'] = "Session Expired";
	 }
	 return json_encode($res);
	}
 }
?>
