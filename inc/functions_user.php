<?php

   function verify_session_time_out_user()
    {
        $user_id = @$_SESSION['user_id'];
        if($user_id and !empty($user_id) and isset($user_id))
        {
            $session_timeout = $_SESSION['web_session_timeout'];
            $saved_time = strtotime(date('Y-m-d H:i:s',$_SESSION['timeout']));
            $current_time = strtotime(date('Y-m-d H:i:s',time()));

            $interval  = abs($current_time - $saved_time);
            if($interval > $session_timeout)
            {
				$login_table=new log_table();
				$update_login=$login_table->update_login_user($user_id,session_id());
                unset_user_session();
                return false;
            }
        }
        $_SESSION['timeout'] = time();
        return true;
    }

    function is_user_login_user()
    {
        if(verify_session_time_out_user())
        {
            $user_id = @$_SESSION['user_id'];
            if($user_id and !empty($user_id) and isset($user_id))
            {
                return true;
            }
        }
        return false;
    }

	function get_login_user_id_user()
	{
		if(is_user_login_user())
		{
			$user_id = @$_SESSION['user_id'];
			return $user_id;
		}
		return false;

	}

    function unset_user_session_user()
    {
        $user_id = @$_SESSION['user_id'];
        if($user_id and !empty($user_id) and isset($user_id))
        {
			unset($_SESSION['user_id']);
            unset($_SESSION['temp_user_id']);
            unset($_SESSION['access_token']);
            unset($_SESSION['timeout']);
            unset($_SESSION['web_session_timeout']);
			$_SESSION['USERNAME'] = NULL;
			$_SESSION['FULLNAME'] = NULL;
			$_SESSION['EMAIL'] =  NULL;
			$_SESSION['LOGOUT'] = NULL;
			unset($_SESSION);
			session_destroy();
        }
    }

    function set_temp_session_user()
    {
        $user_id = $_SESSION['user_id'];
        unset($_SESSION['user_id']);
        $_SESSION['temp_user_id'] = $user_id;
    }

    function remove_temp_session_user()
    {
        unset($_SESSION['temp_user_id']);
    }

    function get_temp_session_id_user()
    {
        if(array_key_exists('temp_user_id', $_SESSION))
        {
            $user_id = $_SESSION['temp_user_id'];
            if($user_id and !empty($user_id))
            {
                return $user_id;
            }
        }
        return false;
    }

	function unset_temp_session_id_user()
    {
		unset($_SESSION['temp_user_id']);
    }





?>
