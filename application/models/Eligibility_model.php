<?php 
 class Eligibility_model extends CI_Model
 {
	public function get($obj)
	{
	 $this->load->model('session_model');
	 $status = $this->session_model->validate_accesstoken($obj['accesstoken']);
	 if($status)
	 {
		$sql = "SELECT eligr.response_description as ResponseMessage,DATE_FORMAT(eligv.eligibility_check_date, '%d %M %Y') as VerificationDate,eligv.copay, eligv.deductible, eligv.deductiblemet,if(eligr.response_status = 'A','Active','Inactive') as Status, insd.pid, insc.name FROM eligibility_verification eligv INNER JOIN  eligibility_response eligr on eligr.response_id = eligv.response_id INNER JOIN insurance_data insd on insd.id = eligv.insurance_id INNER JOIN insurance_companies insc on insc.id = insd.provider WHERE insd.pid = '".$obj['pid']."' AND eligr.response_status = 'A' AND eligv.eligibility_check_date = (SELECT max(eligibility_check_date)  FROM eligibility_verification WHERE insurance_id = eligv.insurance_id)";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(count($result)>0)
		{
		 $result = $result[0];
		 $res['msg'] = array('name'=>($result['name']?$result['name']:'N/A'),'status'=>($result['ResponseMessage']?$result['ResponseMessage']:'N/A'),'verDate'=>($result['VerificationDate']?$result['VerificationDate']:'N/A'),'copay'=>($result['copay']?$result['copay']:'N/A'),'ded'=>($result['deductible']?$result['deductible']:'N/A'),'dedMet'=>($result['deductiblemet']?($result['deductiblemet']=='Y'?'YES':'NO'):'N/A'));
		 $res['status'] = "Success";
		}
		else
		{
		 $res['status'] = "Success";
		 $res['msg'] = array('name'=>'N/A','status'=>'N/A','verDate'=>'N/A','copay'=>'N/A','ded'=>'N/A','dedMet'=>'N/A');
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
