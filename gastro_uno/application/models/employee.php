<?php
class Employee extends Person
{
	/*
	Determines if a given person_id is an employee
	*/
	function exists($person_id)
	{
		$this->db->from('employees');	
		$this->db->join('people', 'people.person_id = employees.person_id');
		$this->db->where('employees.person_id',$person_id);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}	
	
	/*
	Returns all the employees
	*/
	function get_all()
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		
		$this->db->from('employees');
		//$this->db->where('deleted',0);
		$this->db->where("deleted = 0 and subsidary_id = $subsidaryID");//change		
		$this->db->join('people','employees.person_id=people.person_id');			
		$this->db->order_by("last_name", "asc");
		return $this->db->get();		
	}
	
	/*
	Gets information about a particular employee
	*/
	function get_info($employee_id)
	{
		$this->db->from('employees');	
		$this->db->join('people', 'people.person_id = employees.person_id');
		$this->db->where('employees.person_id',$employee_id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $employee_id is NOT an employee
			$person_obj=parent::get_info(-1);
			
			//Get all the fields from employee table
			$fields = $this->db->list_fields('employees');
			
			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field)
			{
				$person_obj->$field='';
			}
			
			return $person_obj;
		}
	}
	
	/*
	Gets information about multiple employees
	*/
	function get_multiple_info($employee_ids)
	{
		$this->db->from('employees');
		$this->db->join('people', 'people.person_id = employees.person_id');		
		$this->db->where_in('employees.person_id',$employee_ids);
		$this->db->order_by("last_name", "asc");
		return $this->db->get();		
	}
	
	/*
	Inserts or updates an employee
	*/
	function save(&$person_data, &$employee_data,&$permission_data,$employee_id=false)
	{
		$success=false;
		
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
			
		if(parent::save($person_data,$employee_id))
		{
			if (!$employee_id or !$this->exists($employee_id))
			{
				$employee_data['person_id'] = $employee_id = $person_data['person_id'];
				$success = $this->db->insert('employees',$employee_data);
				$subsidaryID = $this->session->userdata('subsidary_id');  //change
				$enterpriseID = $this->session->userdata('enterprise_id');//change
				$this->db->where('person_id', $person_data['person_id']);
				$this->db->update('people',array("subsidary_id"=>$subsidaryID,"enterprise_id"=>$enterpriseID));//change			
			}
			else
			{
				$this->db->where('person_id', $employee_id);
				$success = $this->db->update('employees',$employee_data);		
			}
			
			//We have either inserted or updated a new employee, now lets set permissions. 
			if($success)
			{
				//First lets clear out any permissions the employee currently has.
				$success=$this->db->delete('permissions', array('person_id' => $employee_id));
				
				//Now insert the new permissions
				if($success)
				{
					foreach($permission_data as $allowed_module)
					{
						$success = $this->db->insert('permissions',
						array(
						'module_id'=>$allowed_module,
						'person_id'=>$employee_id));
					}
				}
			}
			
		}
		
		$this->db->trans_complete();		
		return $success;
	}
	
	/*
	Inserts an enterprise, subsidary and employee and permissions 
	*/
	function saveRegister(&$data)
	{
		//$success = false;
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		
		$enterprise_data = array('name'=>$data['enterprise']);
		if($this->db->insert('enterprises',$enterprise_data))
			$enterprise_data['enterprise_id'] = $this->db->insert_id();
		
		$subsidary_data = array('company'=>$data['subsidary'],'enterprise_id'=>$enterprise_data['enterprise_id']);
		if($this->db->insert('subsidaries',$subsidary_data))
			$subsidary_data['subsidary_id']	= $this->db->insert_id();
			
		$person_data = array('first_name'=>$data['name'],'enterprise_id'=>$enterprise_data['enterprise_id'],'subsidary_id'=>$subsidary_data['subsidary_id']);
		if($this->db->insert('people',$person_data))
			$person_data['person_id']	= $this->db->insert_id();
			
		$this->session->set_userdata('person_id', $person_data['person_id']);
		$this->session->set_userdata('subsidary_id', $subsidary_data['subsidary_id']);
		$this->session->set_userdata('enterprise_id', $enterprise_data['enterprise_id']);
		
		$employee_data = array('username'=>$data['name'],'password'=>$data['password'],'person_id'=>$person_data['person_id']);
		$this->db->insert('employees',$employee_data);
		
		$module_data = array('config','customers','employees','items','reports','sales','suppliers','receivings','subsidaries');
		foreach($module_data as $module)
		{
			$success = $this->db->insert('permissions',
			array(
			'module_id'=>$module,
			'person_id'=>$person_data['person_id']));
		}
			
		$this->db->trans_complete();		
		//return $success;
	}
	
	/*
	Validate register new user 
	*/
	function validate_user($username)
	{
		$this->db->from('employees');	
		$this->db->where('employees.username',$username);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	/*
	Validate if an employee has a subsidary 
	*/
	function have_subsidary($username)
	{
		$this->db->from('employees');
		$this->db->where('employees.username',$username);	
		$this->db->join('people','employees.person_id = people.person_id'); 
		$this->db->join('subsidaries','people.subsidary_id = subsidaries.subsidary_id');
		$this->db->where('subsidaries.deleted',0);
		$query = $this->db->get();
		
		if($query->num_rows()==0)
			return false;
			
		return true;
	}
	
	/*
	Deletes one employee
	*/
	function delete($employee_id)
	{
		$success=false;
		
		//Don't let employee delete their self
		if($employee_id==$this->get_logged_in_employee_info()->person_id)
			return false;
		
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		
		//Delete permissions
		if($this->db->delete('permissions', array('person_id' => $employee_id)))
		{	
			$this->db->where('person_id', $employee_id);
			$success = $this->db->update('employees', array('deleted' => 1));
		}
		$this->db->trans_complete();		
		return $success;
	}
	
	/*
	Deletes a list of employees
	*/
	function delete_list($employee_ids)
	{
		$success=false;
		
		//Don't let employee delete their self
		if(in_array($this->get_logged_in_employee_info()->person_id,$employee_ids))
			return false;

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		$this->db->where_in('person_id',$employee_ids);
		//Delete permissions
		if ($this->db->delete('permissions'))
		{
			//delete from employee table
			$this->db->where_in('person_id',$employee_ids);
			$success = $this->db->update('employees', array('deleted' => 1));
		}
		$this->db->trans_complete();		
		return $success;
 	}
	
	/*
	Get search suggestions to find employees
	*/
	function get_search_suggestions($search,$limit=5)
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		$suggestions = array();
		
		$this->db->from('employees');
		$this->db->join('people','employees.person_id=people.person_id');	
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0 and subsidary_id = $subsidaryID");//change
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->first_name.' '.$row->last_name;		
		}
		
		$this->db->from('employees');
		$this->db->join('people','employees.person_id=people.person_id');
		//$this->db->where('deleted', 0);
		$this->db->where("deleted = 0 and subsidary_id = $subsidaryID");//change
		$this->db->like("email",$search);
		$this->db->order_by("email", "asc");		
		$by_email = $this->db->get();
		foreach($by_email->result() as $row)
		{
			$suggestions[]=$row->email;		
		}
		
		$this->db->from('employees');
		$this->db->join('people','employees.person_id=people.person_id');	
		//$this->db->where('deleted', 0);
		$this->db->where("deleted = 0 and subsidary_id = $subsidaryID");//change
		$this->db->like("username",$search);
		$this->db->order_by("username", "asc");		
		$by_username = $this->db->get();
		foreach($by_username->result() as $row)
		{
			$suggestions[]=$row->username;		
		}


		$this->db->from('employees');
		$this->db->join('people','employees.person_id=people.person_id');	
		//$this->db->where('deleted', 0);
		$this->db->where("deleted = 0 and subsidary_id = $subsidaryID");//change
		$this->db->like("phone_number",$search);
		$this->db->order_by("phone_number", "asc");		
		$by_phone = $this->db->get();
		foreach($by_phone->result() as $row)
		{
			$suggestions[]=$row->phone_number;		
		}
		
		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	
	}
	
	/*
	Preform a search on employees
	*/
	function search($search)
	{
		$subsidaryID = $this->session->userdata('subsidary_id');//change
		
		$this->db->from('employees');
		$this->db->join('people','employees.person_id=people.person_id');		
		$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
		email LIKE '%".$this->db->escape_like_str($search)."%' or 
		phone_number LIKE '%".$this->db->escape_like_str($search)."%' or 
		username LIKE '%".$this->db->escape_like_str($search)."%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0 and subsidary_id = $subsidaryID");//change		
		$this->db->order_by("last_name", "asc");
		
		return $this->db->get();	
	}
	
	/*
	Attempts to login employee and set session. Returns boolean based on outcome.
	*/
	function login($username, $password)//change migue
	{
		$query = $this->db->get_where('employees', array('username' => $username,'password'=>md5($password), 'deleted'=>0), 1);
		if ($query->num_rows() ==1)
		{
			$row=$query->row();
			$this->session->set_userdata('person_id', $row->person_id);
			
			
			$query = $this->db->get_where('people', array('person_id' => $row->person_id), 1);
			if ($query->num_rows() ==1)
			{
				$row=$query->row();			
				$this->session->set_userdata('subsidary_id', $row->subsidary_id);
				$this->session->set_userdata('enterprise_id', $row->enterprise_id);
			}		
			return true;
		}
		return false;
	}
	
	/*
	Logs out a user by destorying all session data and redirect to login
	*/
	function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
	
	/*
	Determins if a employee is logged in
	*/
	function is_logged_in()
	{
		return $this->session->userdata('person_id')!=false;
	}
	
	/*
	Gets information about the currently logged in employee.
	*/
	function get_logged_in_employee_info()
	{
		if($this->is_logged_in())
		{
			return $this->get_info($this->session->userdata('person_id'));
		}
		
		return false;
	}
	
	/*
	Determins whether the employee specified employee has access the specific module.
	*/
	function has_permission($module_id,$person_id)
	{
		//if no module_id is null, allow access
		if($module_id==null)
		{
			return true;
		}
		
		$query = $this->db->get_where('permissions', array('person_id' => $person_id,'module_id'=>$module_id), 1);
		return $query->num_rows() == 1;
		
		
		return false;
	}

}
?>
