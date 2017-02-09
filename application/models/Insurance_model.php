<?php 
 class Insurance_model extends CI_Model
 {
	public function get($obj)
	{
	 $this->load->model('session_model');
	 $status = $this->session_model->validate_accesstoken($obj['accesstoken']);
	 if($status)
	 {
		$sql = "SELECT name FROM insurance_companies WHERE id = '".$obj['id']."'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(count($result)>0)
		{
		 $res['msg'] = $result[0];
		 $res['status'] = "Success";
		}
		else
		{
		 $res['status'] = "Failure";
		 $res['msg'] = '0';
		}
	 }
	 else
	 {
		$res['status'] = "Failure";
		$res['msg'] = "Session Expired";
	 }
	 return json_encode($res);
	}

	public function insurance_data($obj)
	{
	 $this->load->model('session_model');
	 $status = $this->session_model->validate_accesstoken($obj['accesstoken']);
	 if($status)
	 {
		$sql = "SELECT provider,date FROM insurance_data WHERE pid = '".$obj['pid']."' AND type in ('primary','secondary','tertiary') ORDER BY date DESC,type";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$enddate='Present';
		if(count($result)>0)
		{
		 $result1=array();
		 foreach($result as $row)
		 {
                  if($row['provider'])
		  {
                     $ins_description=ucfirst($row['type']);
                     $ins_description.=strcmp($enddate, 'Present') != 0 ? " (".'Old'.")" : "";
                     $result1[]=$ins_description;
                  }
                  $enddate=$row['date'];
		 }
		 $res['msg'] = $result1;
		 $res['status'] = "Success";
		}
		else
		{
		 $res['status'] = "Failure";
		 $res['msg'] = '0';
		}
	 }
	 else
	 {
		$res['status'] = "Failure";
		$res['msg'] = "Session Expired";
	 }
	 return json_encode($res);
	}

	public function insurance_data_detail($obj)
	{
	 $this->load->model('session_model');
	 $status = $this->session_model->validate_accesstoken($obj['accesstoken']);
	 if($status)
	 {
		$sql = "SELECT insurance_data.*,insurance_companies.name,a.*  FROM insurance_data INNER JOIN insurance_companies ON insurance_data.provider = insurance_companies.id INNER JOIN addresses as a ON insurance_data.provider = a.foreign_id WHERE pid = '".$obj['pid']."' AND type in ('primary','secondary','tertiary') ORDER BY date DESC";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$enddate='Present';
		if(count($result)>0)
		{
		 $result1=array();
		 foreach($result as $row)
		 {
                  if($row['provider'])
		  {
                        $ins_name = $row['name'];
                        if (strcmp($enddate, 'Present') != 0)
			{
			 $ins_period = "Old ";
			 $arr = ucfirst($instype) . " (Old)";
			}
			else
			$arr = ucfirst($instype);
                        $ins_period .= ucfirst($instype) . " Insurance";
                        if(strcmp($row['date'], '0000-00-00')!= 0)
                        $ins_period = " from " . $row['date'];
                        $ins_period .= " until ";
                        $ins_period .= strcmp($enddate, 'Present') != 0 ? $enddate : 'Present';
                        if(!$ins_name)
                        $ins_name = "Unassigned";
                        if(trim($row['line1']))
			{
                                $ins_add = $row['line1'] . ' ';
                                $ins_add .=  $row['city'] . ', ' . $row['state'] . ' ' . $row['zip'];
                        }
                        $ins_policy = $row['policy_number'];
                        $ins_plan = $row['plan_name'];
                        $ins_grp = $row['group_number'];
                        $sub_name = $row['subscriber_fname'] . ' ' . $row['subscriber_mname'] . ' ' . $row['subscriber_lname'];
                        if($row['subscriber_relationship'] != "")
                        $sub_name .=  " " . $row['subscriber_relationship'];
                        $sub_ss = $row['subscriber_ss'];
                        if ($row['subscriber_DOB'] != "0000-00-00 00:00:00") { $sub_dob = $row['subscriber_DOB'];  }
                        $sub_phone = $row['subscriber_phone'];
                        $sub_emp = $row['subscriber_employer'];
                        $sub_add =  $row['subscriber_employer_street'] . ' ' . $row['subscriber_employer_city'];
                        if($row['subscriber_employer_city'] != "") { $sub_add .= ", " . $row['subscriber_employer_state']; }
                        if($row['subscriber_employer_country'] != "") { $sub_add .= ", " . $row['subscriber_employer_country']; }
                        $sub_add .= $row['subscriber_employer_postal_code'];
                        $sub_copay = $row['copay'];
                        if($row['accept_assignment'] == "TRUE") { $sub_assign = "YES"; }
                        if($row['accept_assignment'] == "FALSE") { $sub_assign = "NO"; }
                        if (!empty($row['policy_type'])) { $medicare = $row['policy_type']; } else { $medicare = "N/A"; }
                        $tmp['ins_period'] = $ins_period;
                        $tmp['ins_name'] = $ins_name;
                        $tmp['ins_add'] = $ins_add;
                        $tmp['ins_policy'] = $ins_policy;
                        $tmp['ins_plan'] = $ins_plan;
                        $tmp['ins_grp'] = $ins_grp;
                        $tmp['sub_name'] = $sub_name;
                        $tmp['sub_ss'] = $sub_ss;
                        $tmp['sub_dob'] = $sub_dob;
                        $tmp['sub_phone'] = $sub_phone;
                        $tmp['sub_add'] = $sub_add;
                        $tmp['sub_emp'] = $sub_emp;
                        $tmp['sub_copay'] = $sub_copay;
                        $tmp['sub_assign'] = $sub_assign;
                        $tmp['medicare'] = $medicare;
                        $result1[$arr] = $tmp;
                  }
                  $enddate = $row['date'];
		 }
		 $res['msg'] = $result1;
		 $res['status'] = "Success";
		}
		else
		{
		 $res['status'] = "Failure";
		 $res['msg'] = '0';
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
