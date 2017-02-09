<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Facility extends CI_Controller
{
  public function Facility()
  {
	parent :: __construct();
	$this->load->model('facility_model');
  }

  public function get()
  {
	$accesstoken=$this->input->post('accesstoken');
	$case=$this->uri->segment(3);
	echo $this->facility_model->get(array('case'=>$case,'accesstoken'=>$accesstoken));
  }
}
?>
