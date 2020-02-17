<?php 
    class log_table
    {
        private $_dbh;
        private $_table_name = 'login_hist';
        public function __construct()
        {
            $this->_dbh = new db_connection($this->_table_name);
        }

        public function retrieve_all_log()
        {
            $query = "SELECT * from ".$this->_table_name." ORDER BY histroy_id DESC";
            $result = $this->_dbh->query($query);
            $trans_data = array();
            while($row = mysqli_fetch_assoc($result))
            {
                $trans_data[] = $row;
            }
            return $trans_data;
        }


        
        public function create_login_log()
        {
            $user_id 		= get_login_user_id();
            $user_os        =   getOS();
			$user_browser   =   getBrowser();

	    $log_data = array();
            if($user_id and !empty($user_id))
            {
                $log_data['histroy_id'] = null;
                $log_data['USER_ID'] = $user_id;
                $log_data['SESSIONID'] = session_id();
                $log_data['IP_ADDRESS'] = $_SERVER['REMOTE_ADDR'];
				$log_data['TIMESTAMP'] = DATE('Y-m-d H:i:s');
				$log_data['BROWSER'] = $user_browser;
				$log_data['OS'] = $user_os ;
				$log_data['ACTIVE'] = 1;
				return $this->_dbh->insert($log_data);
            }
            return false;        
        }
		
		public function retrieve_login_by_user($id)
		{
			
			$query = "SELECT * FROM ".$this->_table_name."  
						where 
						USER_ID = '".$id."'
						AND
						ACTIVE=1
						AND
						DATE_FORMAT (TIMESTAMP,'%d') = DATE_FORMAT(NOW(),'%d')";
            $result = $this->_dbh->query($query);
            $login_data = array();
			
            while($row = mysqli_fetch_assoc($result))
            {
                $login_data[] = $row;        
            }
            return $login_data;
		}


		public function retrieve_login_by_user_ID($id)
		{
			
			$query = "SELECT * FROM ".$this->_table_name."  
						where 
						USER_ID = '".$id."'
						";
            $result = $this->_dbh->query($query);
            $login_data = array();
			
            while($row = mysqli_fetch_assoc($result))
            {
                $login_data[] = $row;        
            }
            return $login_data;
		}
		
		
		public function update_login_user($user_id,$session_id)
		{
            $logout_date= date("Y-m-d H:i:s");
            $query = "update ".$this->_table_name." 
					SET ACTIVE =0 , 
					LOGOUT_TIMESTAMP = '".$logout_date."'
					WHERE  
					SESSIONID = '".$session_id."'
					and
					USER_ID ='".$user_id."'";
					 
            $result = $this->_dbh->query($query);
		   
		    if($result)
		    {
		        return true;
		    }
		    return false;		    
		}



public function update_login_company($user_id,$session_id)
{
    $logout_date= date("Y-m-d H:i:s");
    $query = "update ".$this->_table_name." 
					SET ACTIVE =0 , 
					LOGOUT_TIMESTAMP = '".$logout_date."'
					WHERE  
					SESSIONID = '".$session_id."'
					and
					USER_ID ='".$user_id."'";
    $result = $this->_dbh->query($query);

    if($result)
    {
        return true;
    }
    return false;
}
}
    
?>
