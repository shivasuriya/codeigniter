<?php 
 class Calendar_category_model extends CI_Model
 {
	public function get($obj)
	{
	 $this->load->model('session_model');
	 $status = $this->session_model->validate_accesstoken($obj['accesstoken']);
	 if($status)
	 {
		$sql = "SELECT pc_catid, pc_catname, pc_recurrtype, pc_duration, pc_end_all_day FROM openemr_postcalendar_categories WHERE pc_cattype=0 ORDER BY pc_catname";
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
