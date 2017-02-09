<?php 
 class Patient_model extends CI_Model
 {
	public function get($obj)
	{
	 $this->load->model('session_model');
	 $status = $this->session_model->validate_accesstoken($obj['accesstoken']);
	 if($status)
	 {
		if($obj['id']!='')
		$sql = "SELECT fname,lname FROM patient_data WHERE pid='".$obj['id']."'";
		else
		$sql = "SELECT fname,lname FROM patient_data";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(count($result)>0)
		{
		 $res['status'] = "Success";
		 $res['msg'] = $result;
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

	public function get_data($obj)
	{
	 $this->load->model('session_model');
	 $status = $this->session_model->validate_accesstoken($obj['accesstoken']);
	 if($status)
	 {
		if($obj['tbl']=='emp')
		$sql = "SELECT p.occupation,e.name,e.street,e.postal_code,e.city,e.state,e.country FROM employer_data AS e JOIN patient_data AS p WHERE p.pid = e.pid AND p.pid = '".$obj['pid']."'";
		else
		$sql = "SELECT ".$obj['flds']." FROM patient_data WHERE pid = '".$obj['pid']."'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(count($result)>0)
		{
		 $res['status'] = "Success";
		 $res['msg'] = $result[0];
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
