<?php 
    class country_table
    {
        private $_dbh;
        private $_table_name = 'all_country';
		 public function __construct()
        {
            $this->_dbh = new db_connection($this->_table_name);
        }
		
		
		
		public function retrieve_all_country()
		{
			$query = "SELECT * from ".$this->_table_name."";
            $result = $this->_dbh->query($query);
            $trans_data = array();
            while($row = mysqli_fetch_assoc($result))
            {
                $trans_data[] = $row;        
            }
            return $trans_data;
		}
		
		
		public function retrieve_country_by_id($country_id)
		{
		   $query = "SELECT * from ".$this->_table_name." where ID ='".$country_id."'";
            $result = $this->_dbh->query($query);
		    $result_data = mysqli_fetch_assoc($result);
		    if($result_data['ID'] and !empty($result_data['ID']))
		    {
		        return $result_data;
		    }
		    return false;		    
		}
		
		public function retrieve_country_by_engname($country_id)
		{
		   $query = "SELECT * from ".$this->_table_name." where NAME_EN LIKE '%".$country_id."%'";
            $result = $this->_dbh->query($query);
		    $result_data = mysqli_fetch_assoc($result);
		    if($result_data['ID'] and !empty($result_data['ID']))
		    {
		        return $result_data;
		    }
		    return false;		    
		}


        public function retrieve_country_by_arname($country_id)
        {
            $query = "SELECT * from ".$this->_table_name." where NAME_AR LIKE '%".$country_id."%'";
            $result = $this->_dbh->query($query);
            $result_data = mysqli_fetch_assoc($result);
            if($result_data['ID'] and !empty($result_data['ID']))
            {
                return $result_data;
            }
            return false;
        }


		
		
		
		
		
		
	}
?>