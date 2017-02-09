<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Insurance extends CI_Controller
{

  public function Insurance()
  {
	parent :: __construct();
	$this->load->model('insurance_model');
  }

  public function get()
  {
	$accesstoken=$this->input->post('accesstoken');
	$id=$this->uri->segment(3);
	echo $this->insurance_model->get(array('id'=>$id,'accesstoken'=>$accesstoken));
  }
}
?>
