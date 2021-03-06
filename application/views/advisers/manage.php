<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
{ 
    init_table_sorting();
    enable_select_all();
    enable_checkboxes();
    //enable_row_selection();
    enable_delete('<?php echo $this->lang->line($controller_name."_confirm_delete")?>','<?php echo $this->lang->line($controller_name."_none_selected")?>');
}); 

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{ 
			sortList: [[1,0]], 
			headers: 
			{ 
				0: { sorter: false}, 
				5: { sorter: false} 
			} 

		}); 
	}
}

function post_person_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);	
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.person_id,'<?php echo site_url("$controller_name/get_row")?>');
			set_feedback(response.message,'success_message',false);	
			
		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				hightlight_row(response.person_id);
				set_feedback(response.message,'success_message',false);		
			});
		}
	}
}
</script>

<div id="title_bar">
    <?php if(!$this->Employee->is_AdviserUser($this->session->userdata('person_id'))):?>
    	<div id="title" class="float_left"><?php echo $this->lang->line('common_list_of').' '.$this->lang->line('module_'.$controller_name); ?></div>
    
    <?php else: ?>    
        <div id="title" class="float_left"><?php echo $this->lang->line('advisers_profile'); ?></div>
    <?php endif; ?> 	
</div>

<?php 
if(!$this->Employee->is_AdviserUser($this->session->userdata('person_id')))
{?>
    <div id="table_action_header">
        <ul>
            <li class="float_left"><span><?php echo anchor("$controller_name/delete",$this->lang->line("common_delete"),array('id'=>'delete')); ?></span></li>
            <li class="float_right">
            <img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />

            </li>
        </ul>
    </div>
<?php
}?>

<div id="table_holder">
<?php echo $manage_table; ?>
</div>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>