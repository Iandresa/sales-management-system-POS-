<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of factura
 *
 * @author Sebastián Arancibia
 */
class factura {

    protected $db;

    public function __construct()
    {
        $this->db = new mysql();
    }

    function nuevaFactura($idRecinto,$idDocumento,$tipo,$valorTotal,$impuesto,$fecha,$idPedido)
    {
        $query = "INSERT INTO Factura(idRecinto,idDocumento,tipoGasto,valorTotal,impuesto,fecha) VALUES(".$idRecinto.",".$idDocumento.",'".$tipo."',".$valorTotal.",".$impuesto.",".$fecha.");";

        if($this->db->query($query))
        {
            return "Factura añadida correctamente";
        }
        else
        {
            return "Error añadiendo factura";
        }
    }



    function anularFactura($id)
    {
        $query = "UPDATE Factura SET tipo = 'Anulado' WHERE id = ".$id.";";

        if($this->db->query($query))
        {
            return "Factura anulada correctamente";
        }
        else
        {
            return "Error anulando factura";
        }
    }

	function getLastFactura()
	{
		$query = "SELECT id FROM Factura ORDER BY id DESC LIMIT 0,1";

		$res = $this->db->queryArray($query);

		return $res[0];
	}

	function searchFactByDate($desde,$hasta,$id)
	{
		$query = "SELECT id,idDocumento,tipoGasto,valorTotal,idPedido,fecha FROM Factura WHERE idRecinto = ".$id." AND fecha < ".$hasta." AND fecha > ".$desde.";";

		$res = $this->db->queryTotal($query);

		return $res;
	}

	function searchFacturaById($id)
	{
		$query = "SELECT id,idDocumento,tipoGasto,valorTotal,idPedido,impuesto,fecha FROM Factura WHERE id = ".$id.";";

		$res = $this->db->queryArray($query);

		return $res;
	}

	function searchLatest($id)
	{
		$query = "SELECT id,idDocumento,tipoGasto,valorTotal,idPedido,fecha FROM Factura WHERE idRecinto = ".$id." LIMIT 0,10;";

		$res = $this->db->queryTotal($query);

		return $res;
	}

	function sumaIngresos($id)
	{
		$query = "SELECT SUM(valorTotal) FROM Factura WHERE idRecinto = ".$id.";";

		$res = $this->db->queryArray($query);

		return $res[0];
	}

	function getGastos($desde,$hasta,$id)
	{
		$query = "SELECT idDocumento,tipoGasto,valorTotal,fecha FROM Factura WHERE idRecinto = ".$id." AND fecha > ".$desde." AND fecha < ".$hasta.";";

		$res = $this->db->queryTotal($query);

		return $res;
	}

}
?>
