<?php 
 class Facility_model extends CI_Model
 {
	public function get($obj)
	{
	 $this->load->model('session_model');
	 $status = $this->session_model->validate_accesstoken($obj['accesstoken']);
	 if($status)
	 {
		if($obj['case']=='fac')
		$sql = "SELECT id,name FROM facility WHERE service_location != 0";
		elseif($obj['case']=='bill')
		$sql = 'SELECT id,name FROM facility WHERE billing_location = 1';
		else
		return json_encode(array('msg'=>0,'status'=>'Failure'));
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
