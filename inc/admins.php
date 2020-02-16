<?php
	class admins_table
	{
		private $_dbh;
		private $_table_name = 'admins';
		
		public function __construct()
		{
			$this->_dbh = new db_connection($this->_table_name);
		}


		
		public function is_admin_registered($email)
		{
		    $query = "Select count(email) as total_count from ".$this->_table_name." where email ='".$email."'";
		    $result = $this->_dbh->query($query);
		    $result_data = mysqli_fetch_assoc($result);
		    if($result_data['total_count']>0)
		    {
		        return true;
		    }
		    return false;
		}


        public function is_admin_exist($id)
        {
            $query = "Select count(id) as total_count from ".$this->_table_name." where id ='".$id."'";
            $result = $this->_dbh->query($query);
            $result_data = mysqli_fetch_assoc($result);
            if($result_data['total_count']>0)
            {
                return true;
            }
            return false;
        }

		
		
		public function retrieve_admin_by_email($user_email)
		{
		    $query = "Select *,full_name from ".$this->_table_name." where email ='".$user_email."'";
		    $result = $this->_dbh->query($query);
		    $result_data = mysqli_fetch_assoc($result);
		    if($result_data['id'] and !empty($result_data['id']))
		    {
		        return $result_data;
		    }
		    return false;
		}
		
		public function retrieve_admin($user_id)
		{
		   $query = "SELECT *,full_name from ".$this->_table_name." where id ='".$user_id."' ";
            $result = $this->_dbh->query($query);
		    $result_data = mysqli_fetch_assoc($result);
		    if($result_data['id'] and !empty($result_data['id']))
		    {
		        return $result_data;
		    }
		    return false;		    
		}






        public function retrieve_admin_info($user_id)
		{
		   $query = "SELECT * from ".$this->_table_name." where id ='".$user_id."'";
            $result = $this->_dbh->query($query);
		    $result_data = mysqli_fetch_assoc($result);
		    if($result_data['id'] and !empty($result_data['id']))
		    {
		        return $result_data;
		    }
		    return false;		    
		}
		
		

		
		public function get_admin_full_name($user_id)
		{
		    $query = "Select id,full_name AS FULL_NAME from ".$this->_table_name." where id ='".$user_id."'";
		    $result = $this->_dbh->query($query);
		    $result_data = mysqli_fetch_assoc($result);
		    if($result_data['FULL_NAME'] and !empty($result_data['FULL_NAME']))
		    {
		        return $result_data['FULL_NAME'];
		    }
		    return false;
		}

		public function verify_admin($user_email,$user_password)
		{
			$user_data = $this->retrieve_admin_by_email($user_email);
			if($user_data)
			{
				$password_string = hash('SHA256',$user_password);
				$user_password = hash('SHA256',$user_data['salt'].$password_string);
				if($user_password == $user_data['password'])
				{
					return $user_data['id'];
				}
			}
			return false;
		}


		public function add_new_admin(array $user_data)
		{
			if($user_data)
			{
				$password = $user_data['password'];
				$confirm_password = $user_data['confirm_password'];
				unset($user_data['confirm_password']);
				if($password == $confirm_password)
				{
					$rng = new CSPRNG();
					$user_data['salt'] = hash('SHA256',$rng->GenerateToken());
					$password_string = hash('SHA256',$user_data['password']);
					$user_data['password'] = hash('SHA256',$user_data['salt'].$password_string);
					return $this->_dbh->insert($user_data);
				}
			}
			return false;
		}

		public function update_admin(array $user_data,$condition)
		{
			return $this->_dbh->update($user_data, $condition);
		}

		
		
	}
?>
