<?php 
class DineroMailerSecure extends Controller 
{
	function __construct()
	{
		parent::__construct();
                //force_ssl();
        }
		
    function notification()
    {	
	//Verificando la autenticidad de la respuesta, mediante el Hostname de la respuesta.		
	$ok="";
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);//TODO quitar el TRUE POR SEGURIDAD tras las pruebas	
	if ($hostname == 'server1.pagomaster.net') 
	{

	$ok="Nice"; 
		//$requestInfo = var_export($_REQUEST, true);//valor de 

	if($_REQUEST['status']=='1')//indica transaccion pagada
		{			
		$ok="Ok"; 
			
		//Activando si es necesario modulos de tiempo 
		$transactionId=$_REQUEST['merchant_transaction_id'];
		
		$primero=$transactionId[0];
                $segundo=$transactionId[1];
                $tercero=$transactionId[2];
                $cuarto=substr ($transactionId, 3);             
		
		if($primero=="1")//trabajo con modulos
		{
            //echo "AQUI-1";
			$idProduct=$segundo;
			$idTime=$tercero;
			$enterprise_id=$cuarto;
			$daysTrial=0;

            //echo $enterprise_id;
			//*********//			
			//$data['permi_gr_reports_days']=31;
			//$data['permi_uncomplete_sale_days']=31;
			//$data['permi_delivery_days']=31;
			$data['name']=$this->Enterprise->getName($enterprise_id);
			$data['permi_gr_reports']=$this->Enterprise->get_permi_gr_reports($enterprise_id);
			$data['permi_uncomplete_sale']=$this->Enterprise->get_permi_uncomplete_sale($enterprise_id);
			$data['permi_delivery']=$this->Enterprise->get_permi_delivery($enterprise_id);
			$data['permi_hide_banners']=$this->Enterprise->get_permi_hide_banners($enterprise_id);
			//*********//
                        $timePeriod='adquire_modules_semiannual';
			switch ($idTime) 
				{
					case "1" :				
					$daysTrial='31'; 
                                        $timePeriod='adquire_modules_monthly';
					break;
					
					case "2" :
					$daysTrial='183';
                                        $timePeriod='adquire_modules_semiannual';
					break;
					
					case "3" :
					$daysTrial='366'; 
                                        $timePeriod='adquire_modules_annual';
					break;
				}			
			$purchased_module_id="reports";			
			
			if($idProduct=="1")//permi_uncomplete_sale
			{//echo "AQUI-2";
			$data['permi_uncomplete_sale']='1';              
				$data['permi_uncomplete_sale_days']=$daysTrial;
				$purchased_module_id="cafeteria";
			}
			elseif($idProduct=="2")//permi_delivery
			{//echo "AQUI-3";
			$data['permi_delivery']='1'; 	
				 $data['permi_delivery_days']=$daysTrial;
				 $purchased_module_id="deliveries"; 			
			}
			elseif($idProduct=="3")//permi_gr_reports
			{//echo "AQUI-4";
			$data['permi_gr_reports']='1';			
				 $data['permi_gr_reports_days']=$daysTrial; 
				 $purchased_module_id="reports";		
			}  
			//echo $_REQUEST['merchant_transaction_id']." transactionId: $transactionId; idProduct: $idProduct;	idTime: $idTime;	enterprise_id: $enterprise_id;";
	        if($this->Enterprise->exists($enterprise_id))
			{ 
                $mail_to_owner = false;
                //HL (2013-10-09) -> Daba un error a la hora de ejecutar el update enterprise porque -
                //faltaba este dato.
                $enterprise_info = $this->Enterprise->get_info($enterprise_id);
                $data['currency_id'] = $enterprise_info->currency_id;
                //echo $data['currency_id'];
                ////////////////////
				$this->Enterprise->save($data,$enterprise_id);
				//mandar correo
				$subs = $this->Enterprise->get_all_subsidaries_from_enterprise($enterprise_id);		
				foreach($subs->result() as $sub)
				{	
                                        $this->tasklib->Sent_Letter_To_Person('module_purchased', $sub->email, $sub->language, $sub->company, null,null,null,$this->lang->line("module_".$purchased_module_id )." [ ".$this->lang->line($timePeriod)." ]", null,null,null);
                                        //$this->tasklib->Sent_Letter_To_Person('module_purchased', $sub->email, $sub->language,$client_name = $sub->company, $purchased_module = "dd".$this->lang->line("module_".$purchased_module_id ));
					//$this->tasklib->Sent_Letter_To_Person('module_purchased', $sub->email, $sub->language, $sub->company ,null,null,NULL,$this->lang->line("module_".$purchased_module_id)); 
                                        if(!$mail_to_owner)
                                        {
                                            $this->tasklib->Sent_Letter_To_Person('module_purchased', 'sales@iandresa.com', $sub->language, $sub->company."(".$sub->email.")", null,null,null,$this->lang->line("module_".$purchased_module_id )." [ ".$this->lang->line($timePeriod)." ]", null,null,null);
                                            $mail_to_owner = true;    
                                        }  
                                }                     
			
			}
			
		}		
		elseif($primero=="2")//trabajo con banners
		{	
                 /*
                  * $lang['adquire_modules_prints']='Prints';
                    $lang['adquire_modules_end']='At then end of the page (does not include login page)';
                    $lang['adquire_modules_side']='At side of the page (does not include login page)';
                    $lang['adquire_modules_login']='Only at login';
                 */				
			$adviser_id=$cuarto;
			$campaign_offer_id=$tercero;
			$this->Campaign_offer_model->increase_campaign($adviser_id,$campaign_offer_id);
			$person=$this->Person->get_info($adviser_id);		
			$offer=$this->Campaign_offer_model->get_offer($campaign_offer_id)->result();	
                        //$offer[0]->count
			$lang=$this->Employee->get_adviser_lang($adviser_id);                        
			$this->tasklib->Sent_Letter_To_Person('banner_purchased', $person->email, $lang, $person->first_name ,NULL,NULL,NULL,NULL,$this->Campaign_offer_model->get_offer_summary($offer[0]),NULL,NULL);
			$this->tasklib->Sent_Letter_To_Person('banner_purchased', 'sales@iandresa.com', $lang, $person->first_name."(".$person->email.")",NULL,NULL,NULL,NULL,$this->Campaign_offer_model->get_offer_summary($offer[0]),NULL,NULL);					
		}
            }	
        }//end if $hostname
        $saveDAtaPrint="hostName = $hostname; ";
        while (list($x,$y)=each($_REQUEST))
        {
                $saveDAtaPrint.="$x = $y; ";
        }
        $this->db->insert('test', array('key' =>'test'.$ok, 'value'=>$saveDAtaPrint));   
    }//end function
    
}
?>