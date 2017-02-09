<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appointment_status extends CI_Controller
{
  public function Appointment_status()
  {
	parent :: __construct();
	$this->load->model('list_option_model');
  }

  public function get()
  {
	$accesstoken=$this->input->post('accesstoken');
	echo $this->list_option_model->appt_status(array('accesstoken'=>$accesstoken));
  }
}
?>
