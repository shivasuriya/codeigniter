<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appointment extends CI_Controller
{
  public function Appointment()
  {
	parent :: __construct();
	$this->load->model('appointment_model');
  }

  public function get()
  {
	$accesstoken=$this->input->post('accesstoken');
	$year=$this->uri->segment(3);
	$month=$this->uri->segment(4);
	$aid=$this->uri->segment(5);
	echo $this->appointment_model->get(array('year'=>$year,'accesstoken'=>$accesstoken,'month'=>$month,'aid'=>$aid));
  }

  public function insert()
  {
	$accesstoken=$this->input->post('accesstoken');
	$args=$this->input->post('args');
	echo $this->appointment_model->insert_events(array('accesstoken'=>$accesstoken,'args'=>$args));
  }
}
?>
