<?php
require_once("report.php");
class Summary_customers extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array($this->lang->line('reports_customer'), $this->lang->line('reports_subtotal'), $this->lang->line('reports_total'), $this->lang->line('reports_tax'), $this->lang->line('reports_profit'));
	}
	
	public function getData(array $inputs)
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		
		$this->db->select('CONCAT(first_name, " ",last_name) as customer, sum(subtotal) as subtotal, sum(total) as total, sum(tax) as tax,sum(profit) as profit', false);
		$this->db->from('sales_items_temp');
		$this->db->join('customers', 'customers.person_id = sales_items_temp.customer_id');
		$this->db->join('people', 'customers.person_id = people.person_id');
		$this->db->where('sale_date BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->where("subsidary_id = $subsidaryID");//change
		$this->db->group_by('customer_id');
		$this->db->order_by('last_name');

		return $this->db->get()->result_array();		
	}
	
	public function getData2(array $inputs)
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		
		$this->db->select('CONCAT(first_name, " ",last_name) as customer, sum(subtotal) as subtotal, sum(total) as total, sum(tax) as tax,sum(profit) as profit', false);
		$this->db->from('sales_items_temp');
		$this->db->join('customers', 'customers.person_id = sales_items_temp.customer_id');
		$this->db->join('people', 'customers.person_id = people.person_id');
		$this->db->where('sale_date BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->where("subsidary_id = $subsidaryID");//change
		$this->db->group_by('customer_id');
		$this->db->order_by('last_name');

		return $this->db->get();		
	}
	
	public function getSummaryData(array $inputs)
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		
		$this->db->select('sum(subtotal) as subtotal, sum(total) as total, sum(tax) as tax, sum(profit) as profit');
		$this->db->from('sales_items_temp');
		$this->db->join('customers', 'customers.person_id = sales_items_temp.customer_id');
		$this->db->join('people', 'customers.person_id = people.person_id');
		$this->db->where('sale_date BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->where("subsidary_id = $subsidaryID");//change
		
		return $this->db->get()->row_array();
	}
}
?>