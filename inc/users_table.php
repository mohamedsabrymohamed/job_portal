<?php
	class users_table
	{
		private $_dbh;
		private $_table_name = 'users';
		public function __construct()
		{
			$this->_dbh = new db_connection($this->_table_name);
		}


		
		public function is_user_registered($email)
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


        public function is_user_exist($id)
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

		
		
		public function retrieve_user_by_email($user_email)
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
		
		public function retrieve_user($user_id)
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



		public function retrieve_all_users()
		{
			$query = "SELECT * from ".$this->_table_name." ";
			$result = $this->_dbh->query($query);
			$trans_data = array();
			while($row = mysqli_fetch_assoc($result))
			{
				$trans_data[] = $row;
			}
			return $trans_data;
		}



        public function retrieve_user_info($user_id)
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
		
		

		

		public function verify_user($user_email,$user_password)
		{
			$user_data = $this->retrieve_user_by_email($user_email);
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

		public function generate_confirmation_hash($user_id)
		{
			$user_data = $this->retrieve_user($user_id);
			$verification_status = $user_data['email_verf'];
			if($verification_status == 0)
			{
				$user_id = $user_data['id'];
				$user_email = $user_data['email'];
				$created_date = $user_data['created_at'];
				$hash = hash('SHA256', $user_id.$user_email.$created_date);
				$hash .= base64_encode($user_id);
				return $hash;
			}
			return false;
		}


		public function validate_confirmation_hash($hash)
		{
			if(strlen($hash)>64)
			{
				$hash_string = substr($hash, 0,64);
				$encoded_string = substr($hash, 64);
				$user_id = @base64_decode($encoded_string);
				if($user_id and !empty($user_id))
				{
					$user_data = $this->retrieve_user($user_id);
					if($user_data)
					{
						$user_id = $user_data['id'];
						$user_email = $user_data['email'];
						$created_date = $user_data['created_at'];
						$db_hash = hash('SHA256', $user_id.$user_email.$created_date);
						$db_hash .= base64_encode($user_id);
						if($db_hash == $hash)
						{
							return $user_id;
						}
					}

				}
			}
			return false;
		}

		public function get_id_from_hash($hash)
		{
			$hash_string = substr($hash, 0,64);
			$encoded_string = substr($hash, 64);
			$decoded_string = base64_decode($encoded_string);
			$split_strings = explode('-', $decoded_string);
			$user_id = base64_decode($split_strings[1]);
			if($user_id and !empty($user_id))
			{
				return $user_id;
			}
			return false;
		}

		public function validate_hash($hash)
		{
			if(strlen($hash)>64)
			{
				$hash_string = substr($hash, 0,64);
				$encoded_string = substr($hash, 64);
				$decoded_string = base64_decode($encoded_string);
				$split_strings = explode('-', $decoded_string);
				$time = @base64_decode($split_strings[0]);
				$user_id = @base64_decode($split_strings[1]);
				if($time and !empty($time) and $user_id and !empty($user_id))
				{
					$current_time = time();
					$difference = $current_time - $time;
					if($difference>0)
					{
						$minutes = $difference /60;
						$total_minutes_per_day = 24*60*60;
						if($minutes<=$total_minutes_per_day)
						{
							$user_data = $this->retrieve_user($user_id);
							if($user_data)
							{
								$user_id = $user_data['id'];
								$user_email = $user_data['email'];
								$user_password = $user_data['password'];
								$user_salt = $user_data['salt'];

								$db_hash = hash('SHA256', $user_id.$user_email.$user_password.$user_salt);
								$encode_str = base64_encode(base64_encode($time).'-'.base64_encode($user_id));
								$db_hash .= $encode_str;

								if($hash == $db_hash)
								{
									return true;
								}
							}
						}
					}
				}
			}
			return false;
		}


		public function add_new_user(array $user_data)
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

		public function update_user(array $user_data,$condition)
		{
			return $this->_dbh->update($user_data, $condition);
		}

		public function update_user_password(array $user_data)
		{
			$user_id = $user_data['id'];
			unset($user_data['id']);
			$password = $user_data['password'];
			$confirm_password = $user_data['confirm_password'];
			unset($user_data['confirm_password']);
			$user_where = '`id`='.$user_id;
			if($password == $confirm_password)
			{

				$rng = new CSPRNG();
				$user_data['salt'] = hash('SHA256',$rng->GenerateToken());
				$password_string = hash('SHA256',$user_data['password']);
				$user_data['password'] = hash('SHA256',$user_data['salt'].$password_string);
				return $this->update_user($user_data, $user_where);
			}
			return false;
		}


		public function confirm_user($user_id)
		{
			$user_where = '`id`='.$user_id;
			$user_data = array();
			$user_data['email_verf'] = '1';
			$user_data['ver_Date'] = date("Y-m-d H:i:s");
			return $this->update_user($user_data, $user_where);
		}



		
		
	}
?>
