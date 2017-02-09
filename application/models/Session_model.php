<?php 
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Session_model extends CI_Model
 {
    	public function __construct()
    	{
         parent::__construct();
    	}
	public function login($obj)
	{
	 $result = "select id,salt,password from users_secure where username='".$obj['uname']."'";
	 $result = $this->db->query($result);
	 $result = $result->result_array();
	 if(count($result)>0)
	 {
	  $result = $result[0];
	  $this->load->helper('password');
	  $hash = oemr_password_hash($obj['pwd'],$result['salt']);
	 }
	 else
	 {
	  $result = array();
	  $result['id']="0";
	  $result['password']='1';
	  $hash='2';
	 }
	 if($hash == $result['password'])
	 {
	   $res['status'] = "Success";
	   $result['accesstoken'] = $this->generate_accesstoken();
	   $res['msg'] = $result;
	   $uid = $result['id'];
	   $accesstoken = $result['accesstoken'];
	   $delete = "delete from session where userid='$uid'";
	   $this->db->query($delete);
	   $result1 = "INSERT INTO session(userid,createdtime,expirytime,accesstoken) VALUES($uid,NOW(),DATE_ADD(NOW(), INTERVAL 1 HOUR),'$accesstoken')";
	   if($this->db->query($result1))
	   return json_encode($res);
	   else
	   {
	    $res['status'] = "Failure";
	    $res['msg'] = "Error in Session Creation";
	    return json_encode($res);
	   }
	 }
	 else
	 {
	   $res['status'] = "Failure";
	   $res['msg'] = "Invalid Credentials";
	   return json_encode($res);
	 }
	}

	public function oemr_password_salt()
	{
	    $Allowed_Chars ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
	    $Chars_Len = 63;
	    $Salt_Length = 22;
	    $salt = "";
	    for($i=0; $i<$Salt_Length; $i++)
	    {
	        $salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
	    }
	    // This is the preferred hashing mechanism
	    if(CRYPT_BLOWFISH===1)
	    {
	        $rounds='05';
	        //This string tells crypt to apply blowfish $rounds times.
	        $Blowfish_Pre = '$2a$'.$rounds.'$';
	        $Blowfish_End = '$';
	        return $Blowfish_Pre.$salt.$Blowfish_End;
	    }
	    error_log("Blowfish hashing algorithm not available.  Upgrading to PHP 5.3.x or newer is strongly recommended");
	    return SALT_PREFIX_SHA1.$salt;
	}

	public function generate_accesstoken($length=16)
	{
	    global $conn;
	    $characters = "abcdefghijklmnopqrstuvwxyzABCDERFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $randomString = "";
	    for ($i = 0; $i < $length; $i++) {
	      $randomString .= $characters[mt_rand(0, strlen($characters)-1)];
	    }
	    $qry = "SELECT id FROM session WHERE accesstoken='$randomString'";
	    $res = $this->db->query($qry);
	    $res = $res->result_array();
	    if(count($res) > 0){
		$res = $res[0];
	        $id = $res['id'];
	    }
	    return $randomString;
	}

	public function validate_accesstoken($accesstoken)
	{
	    global $conn;
	    $id = "";
	    $qry = "SELECT id FROM session WHERE accesstoken='$accesstoken' AND (NOW() BETWEEN createdtime AND expirytime)";
	    $res = $this->db->query($qry);
	    $res = $res->result_array();
	    if(count($res)>0)
	    {
	     $res = $res[0];
	     $id = $res['id'];
	    }
	    if(isset($id)&&$id!= ""){
	        return true;
	    } else {
	        return false;
	    }
	}

	public function delete_accesstoken($id,$accesstoken)
	{
	    global $conn;
	    $s = "DELETE FROM session WHERE userid='$id' AND accesstoken='$accesstoken'";
	    if ($this->db->query($s)){
	        return true;
	    }else {
	        return false;
	    }
	}

	public function logout($obj)
	{
	 if($this->validate_accesstoken($obj['accesstoken']))
	 {
	  if($this->delete_accesstoken($obj['id'],$obj['accesstoken']))
	  {
           $result['status'] = "Success";
           $result['msg'] = "Deleted";
	  }
	  else
	  {
           $result['status'] = "Failure";
           $result['msg'] = "Session not resetted";
	  }
	 }
	 else
	 {
          $result['status'] = "Failure";
          $result['msg'] = "Session Expired";
	 }
	 return json_encode($result);
	}
 }
?>
