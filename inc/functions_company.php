<?php

   function verify_session_time_out_company()
    {
        $company_id = @$_SESSION['company_id'];
        if($company_id and !empty($company_id) and isset($company_id))
        {
            $session_timeout = $_SESSION['web_session_timeout'];
            $saved_time = strtotime(date('Y-m-d H:i:s',$_SESSION['timeout']));
            $current_time = strtotime(date('Y-m-d H:i:s',time()));

            $interval  = abs($current_time - $saved_time);
            if($interval > $session_timeout)
            {
				$login_table=new log_table();
				$update_login=$login_table->update_login_company($company_id,session_id());
                unset_company_session();
                return false;
            }
        }
        $_SESSION['timeout'] = time();
        return true;
    }

    function is_company_login_company()
    {
        if(verify_session_time_out_company())
        {
            $company_id = @$_SESSION['company_id'];
            if($company_id and !empty($company_id) and isset($company_id))
            {
                return true;
            }
        }
        return false;
    }

	function get_login_company_id_company()
	{
		if(is_company_login_company())
		{
			$company_id = @$_SESSION['company_id'];
			return $company_id;
		}
		return false;

	}

    function unset_company_session_company()
    {
        $company_id = @$_SESSION['company_id'];
        if($company_id and !empty($company_id) and isset($company_id))
        {
			unset($_SESSION['company_id']);
            unset($_SESSION['temp_company_id']);
            unset($_SESSION['access_token']);
            unset($_SESSION['timeout']);
            unset($_SESSION['web_session_timeout']);
			$_SESSION['companyNAME'] = NULL;
			$_SESSION['FULLNAME'] = NULL;
			$_SESSION['EMAIL'] =  NULL;
			$_SESSION['LOGOUT'] = NULL;
			unset($_SESSION);
			session_destroy();
        }
    }

    function set_temp_session_company()
    {
        $company_id = $_SESSION['company_id'];
        unset($_SESSION['company_id']);
        $_SESSION['temp_company_id'] = $company_id;
    }

    function remove_temp_session_company()
    {
        unset($_SESSION['temp_company_id']);
    }

    function get_temp_session_id_company()
    {
        if(array_key_exists('temp_company_id', $_SESSION))
        {
            $company_id = $_SESSION['temp_company_id'];
            if($company_id and !empty($company_id))
            {
                return $company_id;
            }
        }
        return false;
    }

	function unset_temp_session_id_company()
    {
		unset($_SESSION['temp_company_id']);
    }





?>
