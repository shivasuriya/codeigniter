<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Session extends CI_Controller
{
  public function Session()
  {
	parent :: __construct();
    	$this->load->model('session_model');
  }

  public function index()
  {
    $data = $this->session_model->sample();
    $this->load->view('session/index',$data);
  }

  public function login()
  {
    $uname=$this->input->post('uname');
    $pwd=$this->input->post('pwd');
    echo $this->session_model->login(array('uname'=>$uname,'pwd'=>$pwd));
  }

  public function logout()
  {
    $accesstoken=$this->input->post('accesstoken');
    $id=$this->uri->segment(3);
    echo $this->session_model->logout(array('id'=>$id,'accesstoken'=>$accesstoken));
  }
}
?>
