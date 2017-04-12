<?php
require_once("report.php");
class Summary_taxes extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array($this->lang->line('reports_tax_percent'), $this->lang->line('reports_subtotal'), $this->lang->line('reports_total'), $this->lang->line('reports_tax'));
	}
	
	public function getData(array $inputs)//todo me falta filtrar por subsidary_id
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		
		$query = $this->db->query("SELECT percent, SUM(subtotal) as subtotal, sum(total) as total, sum(tax) as tax 
		FROM (SELECT name, CONCAT( percent,  '%' ) AS percent, 
                (item_unit_price * quantity_purchased - item_unit_price * quantity_purchased * discount_percent /100
		) AS subtotal, 
                ROUND( (item_unit_price * quantity_purchased - item_unit_price * quantity_purchased * discount_percent /100
		) * ( 1 + ( percent /100 ) ) , 2 ) AS total, 
                ROUND( (item_unit_price * quantity_purchased - item_unit_price * quantity_purchased * discount_percent /100
		) * ( percent /100 ) , 2 ) AS tax
		FROM ".$this->db->dbprefix('sales_items_taxes')."
		JOIN ".$this->db->dbprefix('sales_items')." ON "
		.$this->db->dbprefix('sales_items').'.sale_id='.$this->db->dbprefix('sales_items_taxes').'.sale_id'." and "
		.$this->db->dbprefix('sales_items').'.item_id='.$this->db->dbprefix('sales_items_taxes').'.item_id'." and "
		.$this->db->dbprefix('sales_items').'.line='.$this->db->dbprefix('sales_items_taxes').'.line'." 
		JOIN ".$this->db->dbprefix('sales')." ON ".$this->db->dbprefix('sales_items_taxes').".sale_id=".$this->db->dbprefix('sales').".sale_id
		WHERE  percent > 0 and subsidary_id = $subsidaryID and is_finished = 1 and date(sale_time) BETWEEN '".$inputs['start_date']."' and '".$inputs['end_date']."') as temp_taxes
                GROUP BY percent");
		return $query->result_array();
// ECP probando, quité excluir 0 %      WHERE percent > 0 and subsidary_id = $subsidaryID and is_finished = 1 and date(sale_time) BETWEEN '".$inputs['start_date']."' and '".$inputs['end_date']."') as temp_taxes
               
	}
	
	public function getData2(array $inputs)//todo me falta filtrar por subsidary_id
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		
		$query = $this->db->query("SELECT percent, SUM(subtotal) as subtotal, sum(total) as total, sum(tax) as tax 
		FROM (SELECT name, CONCAT( percent,  '%' ) AS percent, (
		item_unit_price * quantity_purchased - item_unit_price * quantity_purchased * discount_percent /100
		) AS subtotal, ROUND( (
		item_unit_price * quantity_purchased - item_unit_price * quantity_purchased * discount_percent /100
		) * ( 1 + ( percent /100 ) ) , 2 ) AS total, ROUND( (
		item_unit_price * quantity_purchased - item_unit_price * quantity_purchased * discount_percent /100
		) * ( percent /100 ) , 2 ) AS tax
		FROM ".$this->db->dbprefix('sales_items_taxes')."
		JOIN ".$this->db->dbprefix('sales_items')." ON "
		.$this->db->dbprefix('sales_items').'.sale_id='.$this->db->dbprefix('sales_items_taxes').'.sale_id'." and "
		.$this->db->dbprefix('sales_items').'.item_id='.$this->db->dbprefix('sales_items_taxes').'.item_id'." and "
		.$this->db->dbprefix('sales_items').'.line='.$this->db->dbprefix('sales_items_taxes').'.line'." 
		JOIN ".$this->db->dbprefix('sales')." ON ".$this->db->dbprefix('sales_items_taxes').".sale_id=".$this->db->dbprefix('sales').".sale_id
		WHERE subsidary_id = $subsidaryID and is_finished = 1 and date(sale_time) BETWEEN '".$inputs['start_date']."' and '".$inputs['end_date']."') as temp_taxes 
		GROUP BY percent");
		return $query;
	}
	
	public function getSummaryData(array $inputs)
	{
                $report_data = $this->getData($inputs);
                
                $subTotal = 0;
                $total = 0;
                $tax = 0;
                foreach($report_data as $row)
		{
			$subTotal += $row['subtotal'];
                        $total += $row['total'];
                        $tax += $row['tax'];
		}
                
                $summaryData = array('subtotal'=>$subTotal,'total'=>$total,'tax'=>$tax);

		return $summaryData;
	}
	
	public function getSummaryData2(array $inputs)//no se usará
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		$this->db->select('sum(subtotal) as subtotal, sum(total) as total, sum(tax) as tax');
//ECP quitar ganacia/pérdida para utilizar la misma consulta para el gráfico que para el tabular  $this->db->select('sum(subtotal) as subtotal, sum(total) as total, sum(tax) as tax, sum(profit) as profit');
		//$this->db->select('sum(subtotal) as subtotal, sum(total) as total, sum(tax) as tax');
                $this->db->from('sales_items_temp');
		$this->db->join('items', 'items.item_id = sales_items_temp.item_id');//change
		$this->db->where('sale_date BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->where("subsidary_id = $subsidaryID and is_finished = 1");//change

		return $this->db->get()->row_array();
	}
}
?>