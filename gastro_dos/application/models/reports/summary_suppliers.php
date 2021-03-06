<?php
require_once("report.php");
class Summary_suppliers extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array($this->lang->line('reports_supplier'), $this->lang->line('reports_quantity_purchased'), $this->lang->line('reports_subtotal'), $this->lang->line('reports_total'), $this->lang->line('reports_profit'), $this->lang->line('reports_cost'));
	}
	
	public function getData(array $inputs)
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		
		$this->db->select('company_name as supplier, sum(quantity_purchased) as quantity_purchased, sum(subtotal) as subtotal, sum(total) as total, sum(profit) as profit, sum(cost) as cost', false);
		$this->db->from('receivings_items_temp');
		$this->db->join('suppliers', 'suppliers.person_id = receivings_items_temp.supplier_id');
		$this->db->join('people', 'suppliers.person_id = people.person_id');
                $this->db->where('receiving_date BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->where("subsidary_id = $subsidaryID");//change
		$this->db->group_by('supplier_id');
		$this->db->order_by('last_name');
		
		return $this->db->get()->result_array();
	}
	
	public function getData2(array $inputs)
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		
		$this->db->select('CONCAT(first_name, " ",last_name) as supplier, sum(quantity_purchased) as quantity_purchased, sum(subtotal) as subtotal, sum(total) as total, sum(profit) as profit, sum(cost) as cost', false);
		$this->db->from('receivings_items_temp');
		$this->db->join('suppliers', 'suppliers.person_id = receivings_items_temp.supplier_id');
		$this->db->join('people', 'suppliers.person_id = people.person_id');
                $this->db->where('receiving_date BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->where("subsidary_id = $subsidaryID");//change
		$this->db->group_by('supplier_id');
		$this->db->order_by('last_name');
		
		return $this->db->get();
	}
	
	public function getSummaryData(array $inputs)
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		
		$this->db->select('sum(quantity_purchased) as quantity_purchased,sum(subtotal) as subtotal, sum(total) as total, sum(profit) as profit, sum(cost) as cost');
		$this->db->from('receivings_items_temp');
		$this->db->join('suppliers', 'suppliers.person_id = receivings_items_temp.supplier_id');
		$this->db->join('people', 'suppliers.person_id = people.person_id');
                $this->db->where('receiving_date BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->where("subsidary_id = $subsidaryID");//change

		return $this->db->get()->row_array();
	}
}
?>