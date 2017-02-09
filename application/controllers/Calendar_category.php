<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Calendar_category extends CI_Controller
{
  public function Calendar_category()
  {
	parent :: __construct();
	$this->load->model('calendar_category_model');
  }

  public function get()
  {
	$accesstoken=$this->input->post('accesstoken');
	print_r($this->calendar_category_model->get(array('accesstoken'=>$accesstoken)));
  }
}
?>
