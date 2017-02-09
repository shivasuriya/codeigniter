<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Patient extends CI_Controller
{

  public function Patient()
  {
	parent :: __construct();
	$this->load->model('patient_model');
  }

  public function get()
  {
	$pid=$this->uri->segment(3);
	$accesstoken=$this->input->post('accesstoken');
	echo $this->patient_model->get(array('id'=>$pid,'accesstoken'=>$accesstoken));
  }
}
?>
