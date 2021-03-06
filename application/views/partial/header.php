<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<base href="<?php echo base_url();?>" />
	<title><?php echo $this->config->item('company').' -- '.$this->lang->line('common_powered_by').' '.$this->lang->line('sales_system'); ?></title>
	
<link rel="shortcut icon" href="images/icos/iandresa.ico" type="image/x-icon" />	
	
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/phppos.css" />
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/phppos_print.css"  media="print"/>
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/SpryCollapsiblePanel.css" />
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/carousel.css" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/jquery.simple-dtpicker.css" />

    <script src="<?php echo base_url();?>js/jquery-1.2.6.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script src="<?php echo base_url();?>js/jquery.color.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.metadata.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.form.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.tablesorter.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.ajax_queue.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.bgiframe.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.autocomplete.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.validate.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/thickbox.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/common.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/manage_tables.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/swfobject.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/SpryCollapsiblePanel.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/combo.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/carousel.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <script src="<?php echo base_url();?>js/jquery.simple-dtpicker.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<style type="text/css">
html {
    overflow: auto;
}
</style>
<script language="javascript" type="text/javascript">
    //<![CDATA[
    var cot_loc0=(window.location.protocol == "https:")? "https://secure.comodo.net/trustlogo/javascript/cot.js" :
    "http://www.trustlogo.com/trustlogo/javascript/cot.js";
    document.writeln('<scr' + 'ipt language="JavaScript" src="'+cot_loc0+'" type="text\/javascript">' + '<\/scr' + 'ipt>');
    //]]>
</script>
    
<style type="text/css">
    .carousel-component { 
        padding:8px 16px 4px 16px;
        margin:0px;
    }

    .carousel-component .carousel-list li { 
        margin:4px;
        width:79px; /* img width is 75 px from flickr + a.border-left (1) + a.border-right(1) + 
                       img.border-left (1) + img.border-right (1)*/
        height:93px; /* image + row of text (87) + border-top (1) + border-bottom(1) + margin-bottom(4) */
        /*	margin-left: auto;*/ /* for testing IE auto issue */
    }

    .carousel-component .carousel-list li a { 
        display:block;
        border:0px;
        outline:none;
    }

    .carousel-component .carousel-list li a:hover { 
        border: 1px solid #aaaaaa; 
    }

    .carousel-component .carousel-list li img { 
        border:0px ;
        display:block; 
        margin-left: 15px;
    }

    .carousel-component .carousel-prev { 
        position:absolute;
        top:22px;
        z-index:3;
        cursor:pointer; 
        left:5px; 
    }

    .carousel-component .carousel-next { 
        position:absolute;
        top:22px;
        z-index:3;
        cursor:pointer; 
        right:5px; 
    }
</style>
    
<script type="text/javascript">

/**
 * Custom button state handler for enabling/disabling button state. 
 * Called when the carousel has determined that the previous button
 * state should be changed.
 * Specified to the carousel as the configuration
 * parameter: prevButtonStateHandler
 **/
var handlePrevButtonState = function(type, args) {

	var enabling = args[0];
	var leftImage = args[1];
	if(enabling) {
		leftImage.src = "./images/left-enabled.png";	
	} else {
		leftImage.src = "./images/left-disabled.png";	
	}
	
};

/**
 * Custom button state handler for enabling/disabling button state. 
 * Called when the carousel has determined that the next button
 * state should be changed.
 * Specified to the carousel as the configuration
 * parameter: nextButtonStateHandler
 **/
var handleNextButtonState = function(type, args) {

	var enabling = args[0];
	var rightImage = args[1];
	
	if(enabling) {
		rightImage.src = "./images/right-enabled.png";
	} else {
		rightImage.src = "./images/right-disabled.png";
	}
	
};


/**
 * You must create the carousel after the page is loaded since it is
 * dependent on an HTML element (in this case 'mycarousel'.) See the
 * HTML code below.
 **/
var carousel; // for ease of debugging; globals generally not a good idea
var pageLoad = function() 
{
	carousel = new YAHOO.extension.Carousel("mycarousel", 
		{
			numVisible:        9,
			animationSpeed:    0.15,
			scrollInc:         1,
			navMargin:         20,
			prevElement:     "prev-arrow",
			nextElement:     "next-arrow",
			size:              <?php echo $allowed_modules->num_rows(); ?>,
			prevButtonStateHandler:   handlePrevButtonState,
			nextButtonStateHandler:   handleNextButtonState
		}
	);

};

YAHOO.util.Event.addListener(window, 'load', pageLoad);
</script>
    
</head>
<body>

    

    
<div id="menubar">
    
      <?php
            $lang = $this->session->userdata('lang');//creo que esto no esta pinchando HECTOR
            $personId = $this->session->userdata('person_id');
            
            $row = $this->Subsidary->get_info($this->session->userdata('subsidary_id'));//HECTOR
      ?>

	<div id="menubar_container">
         <div id="bola" style="margin-top: 30px; float: left;">
         <a href="<?php echo site_url('login/show_menu/'.$lang.'/Services');?>" 
               title="<?php echo $this->lang->line('login_Services'); ?>">
            <img width="50px" src="images/logotipo/<?php echo $this->lang->line('login_out'); ?>.png" 
                 onmouseover="this.src='images/logotipo/<?php echo $this->lang->line('login_over'); ?>.png'" 
                 onmouseout="this.src='images/logotipo/<?php echo $this->lang->line('login_out'); ?>.png'" 
                 border="0">
        </a>
         </div>
        <div id="menubar_company_info" style="margin-left: 60px">
		<!--<span id="company_title"><?php echo $this->config->item('company'); ?></span><br />-->
		<span id="company_title"><?php echo $this->Enterprise->getName($this->session->userdata('enterprise_id')); ?></span><br />
		<span id="company_title"><?php echo $this->Subsidary->getName($this->session->userdata('subsidary_id')); ?></span><br />
		<span style='font-size:8pt;'><?php echo $this->lang->line('common_powered_by').' '.$this->lang->line('sales_system'); ?></span>
	</div>

        
<div id="mycarousel" class="carousel-component">
	<div class="carousel-prev">
		<img id="prev-arrow" class="left-button-image" src="./images/left-enabled.png" alt="Previous Button">
	</div>
	<div class="carousel-next">
		<img id="next-arrow" class="right-button-image" src="./images/right-enabled.png" alt="Next Button">
	</div>
    <div style="width: 261px;height: 80px;" class="carousel-clip-region">
        <ul style="position: relative; left: -261px; top: 0px;" class="carousel-list carousel-horizontal">
            <?php
            $id = 1;
            $is_adviser_user = $this->Employee->is_AdviserUser($this->session->userdata('person_id'));
            foreach($allowed_modules->result() as $module)
            {
    //                echo "<div class='menu_item'>";
    //                echo "<a href='".site_url($module->module_id)."'>";
    //                echo "<img src='".base_url().'images/menubar/'.$module->module_id.".png' border='0' alt='Menubar Image' /></a><br />";
    //                echo "<a href='".site_url($module->module_id)."'>".$this->lang->line("module_".$module->module_id)."</a>";
    //                echo "</div>";

                echo "<li id='mycarousel-item-".$id++."'>";
                echo "<a href='".site_url($module->module_id)."'>";
                echo "<img src='".base_url().'images/menubar/'.$module->module_id.".png' border='0' alt='Menubar Image' >";
                //Ariel:
                if($is_adviser_user == 1 && $module->module_id == "advisers")
                   echo $this->lang->line("module_".$module->module_id."_1");
                else
                    echo $this->lang->line("module_".$module->module_id);
                //======
                echo "</a>";
                echo "</li>";
            }
            ?>
        </ul>
    </div>
</div>
 
		<div id="menubar_footer">
		<?php echo $this->lang->line('common_welcome')." $user_info->first_name $user_info->last_name! | "; ?>
		<?php echo anchor("home/logout",$this->lang->line("common_logout")); ?>
                <?php 
                 $this->load->model('Postpone');//$this->Postpone->get_count()
                 $CI =& get_instance();
                 $postponeCount=$CI->Postpone->get_count();
                 if($postponeCount)
                 {
                     echo "| ".anchor("sales/load_postpone_view","{$postponeCount}x <img src='".base_url()."images/icos/doc2.png' border='0'>",'TITLE="'.$this->lang->line('common_postpone1').$postponeCount.$this->lang->line('common_postpone2').'"'); 
                 }
                 ?>
		</div>
                 <div id="menubar_acquire_modules">
		<?php 
                    if(($this->Employee->is_AdviserUser($personId)))
                    {
                        echo  anchor("dineroMailer/banners",$this->lang->line("common_acquire_banner"));
                        echo " | "?><a href="mailto:support@iandresa.com"><?php echo $this->lang->line("common_support"); ?> </a>
                    <?php }
                    else  
                    {       
                        echo anchor("dineroMailer",$this->lang->line("common_acquire_modules"));  
                        
                        
			echo " | ".anchor("register/new_adviser_confirm/0/width:320/height:220",$this->lang->line("common_acquire_banner"), array('class'=>'thickbox none','title'=>$this->lang->line('publish_whit_us')));				
            
                        echo " | "?><a href="mailto:support@iandresa.com"><?php echo $this->lang->line("common_support"); ?> </a>    
                <?php }  
			if($this->Employee->is_SuperUser($personId))
				 echo  " | ".anchor("dineroMailer/test","Test"); 
		?> 
		  
		</div>    
            
		<div id="menubar_date">
                    <script type="text/javascript"> 
                        var now = new Date();
                        
                        var monthNamesES = new Array(12);
                        monthNamesES[0] = "Enero";
                        monthNamesES[1] = "Febrero";
                        monthNamesES[2] = "Marzo";
                        monthNamesES[3] = "Abril";
                        monthNamesES[4] = "Mayo";
                        monthNamesES[5] = "Junio";
                        monthNamesES[6] = "Julio";
                        monthNamesES[7] = "Agosto";
                        monthNamesES[8] = "Septiembre";
                        monthNamesES[9] = "Octubre";
                        monthNamesES[10] = "Noviembre";
                        monthNamesES[11] = "Diciembre";
                        
                        var monthNamesEN = new Array(12);
                        monthNamesEN[0] = "January";
                        monthNamesEN[1] = "February";
                        monthNamesEN[2] = "March";
                        monthNamesEN[3] = "April";
                        monthNamesEN[4] = "May";
                        monthNamesEN[5] = "June";
                        monthNamesEN[6] = "July";
                        monthNamesEN[7] = "August";
                        monthNamesEN[8] = "September";
                        monthNamesEN[9] = "October";
                        monthNamesEN[10] = "November";
                        monthNamesEN[11] = "December";
                    </script>
		    <?php if(!($this->Employee->is_AdviserUser($personId))){
                            if($row->language=="spanish"){ ?>
                            <script language="JavaScript"> 
                                document.write(monthNamesES[now.getMonth()]);
                            </script>
                    <?php }else {?>
                            <script language="JavaScript"> 
                                document.write(monthNamesEN[now.getMonth()]);
                            </script>
                    <?php } 
                              echo date('d, Y h:i a'); 
                          } else{  ?>
                    <?php if($this->Employee->get_adviser_lang($personId)=="spanish"){ ?>
                            <script language="JavaScript"> 
                                document.write(monthNamesES[now.getMonth()]);
                            </script>
                    <?php }else { ?>
                            <script language="JavaScript"> 
                                document.write(monthNamesEN[now.getMonth()]);
                            </script>
                    <?php } 
                        echo date('d, Y h:i a');
                     } ?>
		</div>

	</div>
</div>
    <div id="content_area_wrapper">
        
        <center>
            <?php
                //Ariel: Anuncios
                $adds = $this->Campaign_model->get_nextadvises('side');

                $this->session->set_userdata('real_banners_showed', count($adds));
                
                $ban_margintop = 100;
                $dis_from_center = 523;
                
                echo "<div style='height:0px; width: ".$this->config->item('banner_side_width')."px;position:relative;right: ".$dis_from_center."px;margin-bottom: -100px;margin-top: 100px'>";
                for($i = 0 ; $i < count($adds)/2; $i++)
                {
                    $openLink = $this->Adviser->get_campaign_link($adds[$i]);  
                    echo $openLink;
                    echo "<img border='0' alt='banner' height='".$this->config->item('banner_side_height')."' width='".$this->config->item('banner_side_width')."' src='".base_url()."images/banners_pics/".$adds[$i]['image_large']."'/>";
                    echo "</a>";
                }
                echo "</div>";
                
                
                echo "<div style='height:0px; width: ".$this->config->item('banner_side_width')."px;position:relative;left: ".$dis_from_center."px;margin-bottom: -100px;margin-top: 100px'>";
                for($i = count($adds)%2 == 0 ? count($adds)/2 : count($adds)/2 + .5 ; $i < count($adds); $i++)
                {
                    $openLink = $this->Adviser->get_campaign_link($adds[$i]);  
                    echo $openLink;
                    echo "<img border='0'  alt='banner' height='".$this->config->item('banner_side_height')."' width='".$this->config->item('banner_side_width')."' src='".base_url()."images/banners_pics/".$adds[$i]['image_large']."'/>";
                    echo "</a>";
                }
                echo "</div>";
              
            ?>
        
        
           <?php
          
           
           //Ariel: last_activity 
           $enter_id = $this->session->userdata('enterprise_id');
           $this->db->query("UPDATE phppos_enterprises SET last_activity_time = NOW() WHERE enterprise_id = $enter_id");
           
           
           $this->tasklib->DailyTask_Checker();
           
           ?>

            
        <center> 
        
            
            
            
            
            <div id="content_area">
                
                
                

   


