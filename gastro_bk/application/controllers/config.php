<?php
require_once ("secure_area.php");
class Config extends Secure_area 
{
	function __construct()
	{
		parent::__construct('config');
	}
	
	function index()
	{
		$subsidary_id = $this->session->userdata('subsidary_id');
		$this->session->set_userdata('subsidary_id',$this->session->userdata('subsidary_id'));
		$data['subsidary_info']=$this->Appconfig->get_info($subsidary_id);
		$this->load->view('config',$data);
	}
		
	function save()
	{
		$batch_save_data=array(
		'company'=>$this->input->post('company'),
		'country'=>$this->input->post('country'),
		'address'=>$this->input->post('address'),
		'phone'=>$this->input->post('phone'),
		'email'=>$this->input->post('email'),
		'fax'=>$this->input->post('fax'),
		'website'=>$this->input->post('website'),
		'default_tax_1_rate'=>$this->input->post('default_tax_1_rate'),		
		'default_tax_1_name'=>$this->input->post('default_tax_1_name'),		
		'default_tax_2_rate'=>$this->input->post('default_tax_2_rate'),	
		'default_tax_2_name'=>$this->input->post('default_tax_2_name'),		
		'return_policy'=>$this->input->post('return_policy'),
		'language'=>$this->input->post('language'),
		'timezone'=>$this->input->post('timezone'),
		'print_after_sale'=>$this->input->post('print_after_sale')	
		);
		
		$this->Appconfig->batch_save($batch_save_data);
		
		//$this->MY_Language->switch_to($this->input->post('language'));
		$this->index();
		//$this->load->view('home');
	}
}
?>