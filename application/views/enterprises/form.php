<?php
echo form_open('enterprises/save_config/'.$subsidary_info->subsidary_id.'/'.$enterprise_id,array('id'=>'config_form'));
?>
<input type="hidden" name="submited" value="yes"/>
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<fieldset id="#config_info">
<legend><?php echo $this->lang->line("config_info"); ?></legend>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('config_company').':', 'company',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'company',
		'id'=>'company',
		'value'=>$subsidary_info->company) 
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_country').':', 'country',array('class'=>'wide required')); ?>
	<div class='form_field'>
		<?php echo form_dropdown('country', $this->Country->get_all_array(),
			$subsidary_info->country, "style='width:160px;'");
		?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('config_address').':', 'address',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'address',
		'id'=>'address',
		'rows'=>4,
		'cols'=>17,
		'value'=>$subsidary_info->address)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('config_phone').':', 'phone',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'phone',
		'id'=>'phone',
		'value'=>$subsidary_info->phone)
	);?>
	</div>
</div>



<div class="field_row clearfix">	
    <?php echo form_label($this->lang->line('currency').':', 'enterprise',array('class'=>'wide required')); ?>
    <?php echo form_dropdown('currency', $this->Currency->get_all_array(true),
        $subsidary_info->currency_id, "style='width:160px;'");
    ?>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('config_default_tax_rate_1').':', 'default_tax_1_rate',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'default_tax_1_name',
		'id'=>'default_tax_1_name',
		'size'=>'10',
		'value'=>$subsidary_info->default_tax_1_name!==FALSE ? $subsidary_info->default_tax_1_name : $this->lang->line('items_sales_tax_1'))
	);?>
		
	<?php echo form_input(array(
		'name'=>'default_tax_1_rate',
		'id'=>'default_tax_1_rate',
		'size'=>'4',
		'value'=>$subsidary_info->default_tax_1_rate)
	);?>%
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('config_default_tax_rate_2').':', 'default_tax_1_rate',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'default_tax_2_name',
		'id'=>'default_tax_2_name',
		'size'=>'10',
		'value'=>$subsidary_info->default_tax_2_name!==FALSE ? $subsidary_info->default_tax_2_name : $this->lang->line('items_sales_tax_2')));?>
		
	<?php echo form_input(array(
		'name'=>'default_tax_2_rate',
		'id'=>'default_tax_2_rate',
		'size'=>'4',
		'value'=>$subsidary_info->default_tax_2_rate)
	);?>%
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_email').':', 'email',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'email',
		'id'=>'email',
		'value'=>$subsidary_info->email)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_repeat_email').':', 'repeat_email',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'repeat_email',
		'id'=>'repeat_email',
		'value'=>$subsidary_info->email)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('config_fax').':', 'fax',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'fax',
		'id'=>'fax',
		'value'=>$subsidary_info->fax)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('config_website').':', 'website',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'website',
		'id'=>'website',
		'value'=>$subsidary_info->website)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('common_return_policy').':', 'return_policy',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_textarea(array(
		'name'=>'return_policy',
		'id'=>'return_policy',
		'rows'=>'4',
		'cols'=>'17',
		'value'=>$subsidary_info->return_policy)
	);?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('config_language').':', 'language',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_dropdown('language', array(
		'english'  => 'English',
		//'indonesia'    => 'Indonesia',
		'spanish'   => 'Spanish'), $subsidary_info->language);
		?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('config_timezone').':', 'timezone',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_dropdown('timezone', 
	 array(
		'Pacific/Midway'=>'(GMT-11:00) Midway Island, Samoa',
		'America/Adak'=>'(GMT-10:00) Hawaii-Aleutian',
		'Etc/GMT+10'=>'(GMT-10:00) Hawaii',
		'Pacific/Marquesas'=>'(GMT-09:30) Marquesas Islands',
		'Pacific/Gambier'=>'(GMT-09:00) Gambier Islands',
		'America/Anchorage'=>'(GMT-09:00) Alaska',
		'America/Ensenada'=>'(GMT-08:00) Tijuana, Baja California',
		'Etc/GMT+8'=>'(GMT-08:00) Pitcairn Islands',
		'America/Los_Angeles'=>'(GMT-08:00) Pacific Time (US & Canada)',
		'America/Denver'=>'(GMT-07:00) Mountain Time (US & Canada)',
		'America/Chihuahua'=>'(GMT-07:00) Chihuahua, La Paz, Mazatlan',
		'America/Dawson_Creek'=>'(GMT-07:00) Arizona',
		'America/Belize'=>'(GMT-06:00) Saskatchewan, Central America',
		'America/Cancun'=>'(GMT-06:00) Guadalajara, Mexico City, Monterrey',
		'Chile/EasterIsland'=>'(GMT-06:00) Easter Island',
		'America/Chicago'=>'(GMT-06:00) Central Time (US & Canada)',
		'America/New_York'=>'(GMT-05:00) Eastern Time (US & Canada)',
		'America/Havana'=>'(GMT-05:00) Cuba',
		'America/Bogota'=>'(GMT-05:00) Bogota, Lima, Quito, Rio Branco',
		'America/Caracas'=>'(GMT-04:30) Caracas',
		'America/Santiago'=>'(GMT-04:00) Santiago',
		'America/La_Paz'=>'(GMT-04:00) La Paz',
		'Atlantic/Stanley'=>'(GMT-04:00) Faukland Islands',
		'America/Campo_Grande'=>'(GMT-04:00) Brazil',
		'America/Goose_Bay'=>'(GMT-04:00) Atlantic Time (Goose Bay)',
		'America/Glace_Bay'=>'(GMT-04:00) Atlantic Time (Canada)',
		'America/St_Johns'=>'(GMT-03:30) Newfoundland',
		'America/Araguaina'=>'(GMT-03:00) UTC-3',
		'America/Montevideo'=>'(GMT-03:00) Montevideo',
		'America/Miquelon'=>'(GMT-03:00) Miquelon, St. Pierre',
		'America/Godthab'=>'(GMT-03:00) Greenland',
		'America/Argentina/Buenos_Aires'=>'(GMT-03:00) Buenos Aires',
		'America/Sao_Paulo'=>'(GMT-03:00) Brasilia',
		'America/Noronha'=>'(GMT-02:00) Mid-Atlantic',
		'Atlantic/Cape_Verde'=>'(GMT-01:00) Cape Verde Is.',
		'Atlantic/Azores'=>'(GMT-01:00) Azores',
		'Europe/Belfast'=>'(GMT) Greenwich Mean Time : Belfast',
		'Europe/Dublin'=>'(GMT) Greenwich Mean Time : Dublin',
		'Europe/Lisbon'=>'(GMT) Greenwich Mean Time : Lisbon',
		'Europe/London'=>'(GMT) Greenwich Mean Time : London',
		'Africa/Abidjan'=>'(GMT) Monrovia, Reykjavik',
		'Europe/Amsterdam'=>'(GMT+01:00) Amsterdam, Berlin, Bern',
		'Europe/Rome'=>'(GMT+01:00) Rome, Stockholm, Vienna,Prague',
		'Europe/Belgrade'=>'(GMT+01:00)  Bratislava, Budapest, Ljubljana',
		'Europe/Brussels'=>'(GMT+01:00)  Copenhagen, Madrid, Paris',
		'Africa/Algiers'=>'(GMT+01:00) West Central Africa',
		'Africa/Windhoek'=>'(GMT+01:00) Windhoek',
		'Asia/Beirut'=>'(GMT+02:00) Beirut',
		'Africa/Cairo'=>'(GMT+02:00) Cairo',
		'Asia/Gaza'=>'(GMT+02:00) Gaza',
		'Africa/Blantyre'=>'(GMT+02:00) Harare, Pretoria',
		'Asia/Jerusalem'=>'(GMT+02:00) Jerusalem',
		'Europe/Minsk'=>'(GMT+02:00) Minsk',
		'Asia/Damascus'=>'(GMT+02:00) Syria',
		'Europe/Moscow'=>'(GMT+03:00) Moscow, St. Petersburg, Volgograd',
		'Africa/Addis_Ababa'=>'(GMT+03:00) Nairobi',
		'Asia/Tehran'=>'(GMT+03:30) Tehran',
		'Asia/Dubai'=>'(GMT+04:00) Abu Dhabi, Muscat',
		'Asia/Yerevan'=>'(GMT+04:00) Yerevan',
		'Asia/Kabul'=>'(GMT+04:30) Kabul',
		'Asia/Yekaterinburg'=>'(GMT+05:00) Ekaterinburg',
		'Asia/Tashkent'=>'(GMT+05:00) Tashkent',
		'Asia/Kolkata'=>'(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi',
		'Asia/Katmandu'=>'(GMT+05:45) Kathmandu',
		'Asia/Dhaka'=>'(GMT+06:00) Astana, Dhaka',
		'Asia/Novosibirsk'=>'(GMT+06:00) Novosibirsk',
		'Asia/Rangoon'=>'(GMT+06:30) Yangon (Rangoon)',
		'Asia/Bangkok'=>'(GMT+07:00) Bangkok, Hanoi, Jakarta',
		'Asia/Krasnoyarsk'=>'(GMT+07:00) Krasnoyarsk',
		'Asia/Hong_Kong'=>'(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi',
		'Asia/Irkutsk'=>'(GMT+08:00) Irkutsk, Ulaan Bataar',
		'Australia/Perth'=>'(GMT+08:00) Perth',
		'Australia/Eucla'=>'(GMT+08:45) Eucla',
		'Asia/Tokyo'=>'(GMT+09:00) Osaka, Sapporo, Tokyo',
		'Asia/Seoul'=>'(GMT+09:00) Seoul',
		'Asia/Yakutsk'=>'(GMT+09:00) Yakutsk',
		'Australia/Adelaide'=>'(GMT+09:30) Adelaide',
		'Australia/Darwin'=>'(GMT+09:30) Darwin',
		'Australia/Brisbane'=>'(GMT+10:00) Brisbane',
		'Australia/Hobart'=>'(GMT+10:00) Hobart',
		'Asia/Vladivostok'=>'(GMT+10:00) Vladivostok',
		'Australia/Lord_Howe'=>'(GMT+10:30) Lord Howe Island',
		'Etc/GMT-11'=>'(GMT+11:00) Solomon Is., New Caledonia',
		'Asia/Magadan'=>'(GMT+11:00) Magadan',
		'Pacific/Norfolk'=>'(GMT+11:30) Norfolk Island',
		'Asia/Anadyr'=>'(GMT+12:00) Anadyr, Kamchatka',
		'Pacific/Auckland'=>'(GMT+12:00) Auckland, Wellington',
		'Etc/GMT-12'=>'(GMT+12:00) Fiji, Kamchatka, Marshall Is.',
		'Pacific/Chatham'=>'(GMT+12:45) Chatham Islands',
		'Pacific/Tongatapu'=>'(GMT+13:00) Nuku\'alofa',
		'Pacific/Kiritimati'=>'(GMT+14:00) Kiritimati'
		), $subsidary_info->timezone ? $subsidary_info->timezone : date_default_timezone_get());
		?>
	</div>
</div>

<?php 
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'submit_button float_right')
);

?>
</fieldset>
<?php
echo form_close();
?>
<script type='text/javascript'>
//validation and submit handling
$(document).ready(function()
{
	$('#config_form').validate({
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			company: "required",
			address: "required",
                          currency:"required",
    		phone: 
            {
                required:true,
                number:true
            },
    		default_tax_rate:
    		{
    			required:true,
    			number:true
    		},
    		repeat_email:
			{
 				equalTo: "#email"
			},
    		email:
    		{
    			required:true,
    			email:true
    		},
    		return_policy: "required"    		
   		},
		messages: 
		{
     		company: "<?php echo $this->lang->line('config_company_required'); ?>",
     		address: "<?php echo $this->lang->line('config_address_required'); ?>",
                 currency: "<?php echo $this->lang->line('currency_required_field'); ?>",
     	 phone: 
            {
                 required: "<?php echo $this->lang->line('config_phone_required'); ?>",
                 number:  "<?php echo $this->lang->line('common_valid_phonenumber'); ?>"
            },
     		default_tax_rate:
    		{
    			required:"<?php echo $this->lang->line('config_default_tax_rate_required'); ?>",
    			number:"<?php echo $this->lang->line('config_default_tax_rate_number'); ?>"
    		},
    		repeat_email:
			{
				equalTo: "<?php echo $this->lang->line('common_email_must_match'); ?>"
     		},
     		email:
    		{
    			required:"<?php echo $this->lang->line('config_email_required'); ?>",
    			email:"<?php echo $this->lang->line('common_email_invalid_format'); ?>"
    		},
     		return_policy:"<?php echo $this->lang->line('config_return_policy_required'); ?>"
	
		}
	});
});
</script>