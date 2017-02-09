<?php
 class Appointment_model extends CI_Model
 {
	public function get($obj)
	{
	 $this->load->model('session_model');
	 $status = $this->session_model->validate_accesstoken($obj['accesstoken']);
	 if($status)
	 {
		$evt = $obj['year']."-".$obj['month']."-"."30";
		$end = $obj['year']."-".$obj['month']."-"."01";
		$sql = "SELECT pc_endDate,pc_duration,pc_recurrtype,pc_recurrspec,pc_recurrfreq,pc_eventDate,pc_eid,pc_startTime,pc_endTime,pc_pid,pc_apptstatus FROM openemr_postcalendar_events WHERE pc_eventStatus=1 and pc_aid='".$obj['aid']."' and ((YEAR(pc_eventDate) ='".$obj['year']."' and MONTH(pc_eventDate) = '".$obj['month']."') OR (pc_eventDate < '$evt' and pc_endDate > '$end')) and pc_pid != ''";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(count($result)>0)
		{
		 $this->load->helper('recurr');
		 $result1=array();
		 foreach($result as $row)
		 {
         	  if($row['pc_endDate']!='0000-00-00')
		  {
              	   $recurr =  unserialize($row['pc_recurrspec']);
              	   $excluding_date = $recurr['exdate'];
              	   $ex_dates = explode(",",$excluding_date);
              	   $sdate = $row['pc_eventDate'];
              	   $edate = $row['pc_endDate'];
              	   $re = array();
              	   $r = recurre_events_for_mobileapp($row);
              	   $re = calculate_recurr_dates($r,$row);
              	   foreach($re as $key => $val)
              	   {
                    if($val[0]==1)
                    {
                     $key_str = str_replace("-","",$key);
                     if(in_array($key_str,$ex_dates))
                     unset($re[$key]);
                    }else{
                     unset($re[$key]);
                    }
              	   }
              	   foreach($re as $k => $v)
              	   {
                    $row['pc_eventDate']=$k;
                    $tmp = explode("-",$k);
                    $row['evt'] = $tmp[2];
                    $result1[] = $row;
              	   }
          	  }
	          else
	          {
	           $tmp = explode("-",$row['pc_eventDate']);
	           $row['evt'] = $tmp[2];
	           $result1[] = $row;
	          }
		 }
		 $res['msg'] = $result1;
		 $res['status'] = "Success";
		}
		else
		{
		 $res['status'] = "Failure";
		 $res['msg'] = "No Appointments";
		}
	 }
	 else
	 {
		$res['status'] = "Failure";
		$res['msg'] = "Session Expired";
	 }
	 return json_encode($res);
	}
	public function insert_events($obj)
	{
	 $this->load->model('session_model');
	 $status = $this->session_model->validate_accesstoken($obj['accesstoken']);
	 if($status)
	 {
	  $recurrspec = serialize($obj['args']['recurrspec']);
	  $loc = serialize($obj['args']['location']);
	  $aid = $obj['args']['aid'];
	  $pid = $obj['args']['pid'];
	  $title = $obj['args']['title'];
	  $hometext = $obj['args']['hometext'];
	  $apptstatus = $obj['args']['apptstatus'];
	  $eventDate = $obj['args']['eventDate'];
	  $enddate = $obj['args']['enddate'];
	  $starttime = $obj['args']['starttime'];
	  $endtime = $obj['args']['endtime'];
	  $qry = "INSERT INTO openemr_postcalendar_events(pc_catid,pc_multiple,pc_aid,pc_pid,pc_title,pc_time,pc_hometext,pc_informant,pc_eventDate,pc_endDate,pc_duration,pc_recurrtype,pc_recurrspec,pc_startTime,pc_endTime,pc_alldayevent,pc_apptstatus,pc_prefcatid,pc_location,pc_eventstatus,pc_sharing,pc_facility,pc_billing_location)VALUES({$obj['args']['catid']},0,$aid,'$pid','$title',NOW(),'$hometext',$aid,'$eventDate','$enddate',{$obj['args']['duration']},{$obj['args']['recurrtype']},'$recurrspec','$starttime','$endtime',{$obj['args']['allday']},'$apptstatus',0,'$loc',1,1,{$obj['args']['facility']},{$obj['args']['billing_facility']})";
	  if($this->db->query($qry)){
        	$res['status'] = "Success";
        	return json_encode($res);
	  }else {
        	$res['status'] = "Failure";
        	$res['error'] = '';
        	return json_encode($res);
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
