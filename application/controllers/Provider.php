<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Provider extends CI_Controller
{

  public function Provider()
  {
	parent :: __construct();
	$this->load->model('provider_model');
  }

  public function get()
  {
	$accesstoken=$this->input->post('accesstoken');
	$id=$this->uri->segment(3);
	$field=$this->uri->segment(4);
	echo $this->provider_model->get(array('id'=>$id,'accesstoken'=>$accesstoken,'field'=>$field));
  }
}
?>
