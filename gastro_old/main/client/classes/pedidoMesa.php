<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pedidoMesa
 *
 * @author Watanuki
 */
class pedidoMesa {

    protected  $db;

    public function __construct()
    {
        $this->db = new mysql();
    }

    function nuevoPedidoMesa($cant,$nomProd,$fecha,$idPedido,$valorNeto)
    {
        $query = "INSERT INTO pedidoMesa(cant,nombreProducto,fecha,idPedido,valorNeto) VALUES(".$cant.",'".$nomProd."',".$fecha.",".$idPedido.",".$valorNeto.");";

        if($this->db->query($query))
        {
            return "Pedido a mesa añadido correctamente";
        }
        else
        {
            return "Error añadiendo pedido a mesa";
        }
    }

	function getLastIdPed()
	{
		$query = "SELECT idPedido FROM pedidoMesa DESC LIMIT 0,1;";

		return $this->db->queryArray($query);
	}

	function showDetail($idP)
	{
		$query = "SELECT * FROM pedidoMesa WHERE idPedido = ".$idP.";";

		return $this->db->queryTotal($query);
	}



    function anularPedido($id,$fecha)
    {
        $query = "UPDATE pedidoMesa SET estado = 'Anulado', fecha = ".$fecha." WHERE idPedido = ".$id.";";

        if($this->db->query($query))
        {
            return "Pedido a mesa anulado correctamente";
        }
        else
        {
            return "Error anulando pedido a mesa";
        }
    }
}
?>
