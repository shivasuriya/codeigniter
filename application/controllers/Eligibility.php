<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Eligibility extends CI_Controller
{

  public function Eligibility()
  {
	parent :: __construct();
	$this->load->model('eligibility_model');
  }

  public function get()
  {
	$accesstoken=$this->input->post('accesstoken');
	$pid=$this->uri->segment(3);
	echo $this->eligibility_model->get(array('pid'=>$pid,'accesstoken'=>$accesstoken));
  }
}
?>
