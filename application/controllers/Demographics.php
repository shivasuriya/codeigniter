<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Demographics extends CI_Controller
{
  public function Demographics()
  {
	parent :: __construct();
	$this->load->model('layout_option_model');
  }

  public function get()
  {
	$accesstoken=$this->input->post('accesstoken');
	$form_id=$this->uri->segment(3);
	echo $this->layout_option_model->demo(array('form_id'=>$form_id,'accesstoken'=>$accesstoken));
  }

  public function fields()
  {
	$form_id=$this->uri->segment(3);
	$group=$this->uri->segment(4);
	$accesstoken=$this->input->post('accesstoken');
	echo $this->layout_option_model->fields(array('form_id'=>$form_id,'accesstoken'=>$accesstoken,'group'=>$group));
  }

  public function get_data()
  {
	$this->load->model('patient_model');
	$accesstoken=$this->uri->segment(3);
	$tbl=$this->uri->segment(4);
	$flds=$this->uri->segment(5);
	$pid=$this->uri->segment(6);
	print_r($this->patient_model->get_data(array('tbl'=>$tbl,'accesstoken'=>$accesstoken,'flds'=>$flds,'pid'=>$pid)));
  }

  public function get_ins_tabs()
  {
	$this->load->model('insurance_model');
	$accesstoken=$this->input->post('accesstoken');
	$pid=$this->uri->segment(3);
	echo $this->insurance_model->insurance_data(array('accesstoken'=>$accesstoken,'pid'=>$pid));
  }

  public function get_ins_details()
  {
	$this->load->model('insurance_model');
	$accesstoken=$this->input->post('accesstoken');
	$pid=$this->uri->segment(3);
	echo $this->insurance_model->insurance_data_detail(array('accesstoken'=>$accesstoken,'pid'=>$pid));
  }
}
?>
