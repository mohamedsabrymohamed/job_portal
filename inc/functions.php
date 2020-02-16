<?php

		
	function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}			

	function send_invitation_email($user_id,$to_email,$invitaion_id)
	{
	    $user_table = new user_table();
	    $hash = $user_table->generate_invitaion_hash($user_id,$to_email,$invitaion_id);
	    if($hash != false)
	    {
	        $user_data = $user_table->retrieve_user($user_id);
	        if($user_data)
	        {
	            $user_email = $user_data['EMAIL'];
				$user_full_name = $user_data['FULL_NAME'];
	            $email = new user_mail();
	            $email->set_to($to_email);
				$email->set_subject('Invitation');
				if($user_data['USER_TYPE'] == 3){
				$message_body = $email->generate_invitation_merch_email_body($hash,$user_full_name);
				}
				else{
				$message_body = $email->generate_invitation_email_body($hash,$user_full_name);
				}

	            $email->set_message_body($message_body);
	            $return = $email->send_mail();
	            if($return)
	            {
	                return true;
	            }
	        }
	    }
	    return false;
	}


		function send_contactus_email(array $contact_data)
	{


	        if($contact_data)
	        {
			$param_table = new param_table();
			$param_data = $param_table->retrieve_params();
			$admin_email = $param_data['CONTACT_US_EMAIL'];
	            $email = new user_mail();
	            $email->set_to($admin_email);
				$email->set_subject('Contact Us');

	            $message_body = $email->generate_contactus_email($contact_data);
	            $email->set_message_body($message_body);
	            $return = $email->send_mail();
	            if($return)
	            {
	                return true;
	            }
	        }

	    return false;
	}

   function verify_session_time_out()
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

    function is_user_login()
    {
        if(verify_session_time_out())
        {
            $user_id = @$_SESSION['user_id'];
            if($user_id and !empty($user_id) and isset($user_id))
            {
                return true;
            }
        }
        return false;
    }

     function create_url($path)
    {
        global $global_variable;
        $site_url = $global_variable['site_url'];
        return $site_url.$path;
    }

    function create_path($path)
    {
        global $global_variable;
        $site_path = $global_variable['site_path'];
        $url = $site_path.$path;
        return $url;
    }

	function get_login_user_id()
	{
		if(is_user_login())
		{
			$user_id = @$_SESSION['user_id'];
			return $user_id;
		}
		return false;

	}

    function unset_user_session()
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

    function set_temp_session()
    {
        $user_id = $_SESSION['user_id'];
        unset($_SESSION['user_id']);
        $_SESSION['temp_user_id'] = $user_id;
    }

    function remove_temp_session()
    {
        unset($_SESSION['temp_user_id']);
    }

    function get_temp_session_id()
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

	function unset_temp_session_id()
    {
		unset($_SESSION['temp_user_id']);
    }


    function login_status()
    {
		$ajaxresutreturn='<div class="users_wrap clearfix el_transition">';
		$ajaxresutreturn.=' <div class="users_thumbnail" >';
		$user_table= new user_table();
		$user_data=$user_table->retrieve_user($_SESSION['user_id']);
		$user_type= $user_data['USER_TYPE'];
		$user_img= $user_data['USER_IMAGE'];
		$param_table = new param_table();
        $param_data = $param_table->retrieve_params();
        $BASE_WEBSITE = $param_data['BASE_URL'];
		$ajaxresutreturn.='<img class="img-responsive" src="'.$BASE_WEBSITE.'upload/'.$user_img.'" />';
		$ajaxresutreturn.='</div>';
		$ajaxresutreturn.=' <div class="user_log_name">';
		$ajaxresutreturn.=get_login_user_full_name();
		$ajaxresutreturn.='</div>';
		$ajaxresutreturn.='<i class="ion-ios-arrow-down"></i>';
		$ajaxresutreturn.=' <ul class="user_dropdown">';
		$ajaxresutreturn.='<li class="el_transition"> <i class="ion-gear-a"></i>';
		
		if ($user_type == 1){
			$link_url2 = 'admin.php';
		}
		elseif ($user_type == 2){
			$link_url2 = 'dataentry.php';
		}
		elseif ($user_type == 3){
			$link_url2 = 'profile.php';
		}
		elseif ($user_type == 4){
			$link_url2 = 'supervisor.php';
		}
		$ajaxresutreturn.='<a href="'.$link_url2.'"> الاعدادات </a>';
		$ajaxresutreturn.='</li>';
		if ($user_type == 3){
		$ajaxresutreturn.='<li class="el_transition"> <i class="ion-speakerphone"></i> ';
		$link_ads = 'add_ads.php';
		$ajaxresutreturn.='<a href="'.$link_ads.'"> الإعلان </a>';
		}
		
		$ajaxresutreturn.='<li class="el_transition"> <i class="ion-log-out"></i> ';
		$link_url = 'auth/logout.php';
		$ajaxresutreturn.='<a href="'.$link_url.'"> تسجيل الخروج </a>';
		$ajaxresutreturn.='</li>';
		$ajaxresutreturn.='</ul>';
		$ajaxresutreturn.=' </div>';
		
		return $ajaxresutreturn;
    }

    function get_login_user_full_name()
    {
        if(is_user_login())
        {
            $user_id = @$_SESSION['user_id'];
            $user_table = new user_table();
            return $user_table->get_full_name($user_id);
        }
        return false;
    }

	function is_injected($str)
	{
		$injections = array('(\n+)','(\r+)','(\t+)','(%0A+)','(%0D+)','(%08+)','(%09+)');
		$inject = join('|', $injections);
		$inject = "/$inject/i";
		if(preg_match($inject,$str))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_error_message()
	{
	    $output = '';
	    $message = '';
	    $notification_class = '';
	    if(array_key_exists('error', $_SESSION))
	    {
	        $message = @$_SESSION['error'];
					$notification_class = 'error';
	    }
	    else if(array_key_exists('success', $_SESSION))
	    {
	        $message = @$_SESSION['success'];
	        $notification_class = 'success';
	    }
	    if($message and !empty($message))
	    {
	        $msg = json_decode($message);
	        $output = '<p class="'.$notification_class.'">';
	        if(is_array($msg))
	        {
				$i = 0;
				foreach($msg as $single_message)
				{
					$i++;
					if($i!=1)
					{
						$output .= "<br/>";
					}
					$output .= $single_message;
				}
			}
			else
			{
            	$output .= $message;
			}
			$output .= "</p>";
	    }
	    return $output;
	}

	function is_user_verified()
	{
	    if(is_user_login())
	    {
	        $user_id = get_login_user_id();
	        $user_table = new user_table();
	        $verification_status = $user_table->is_user_verified($user_id);
	        return $verification_status;
	    }
	    return true;
	}

	function send_confirmation_email($user_id,$first_name,$last_name)
	{
	    $user_table = new user_table();
	    $hash = $user_table->generate_confirmation_hash($user_id);
	    if($hash != false)
	    {
	        $user_data = $user_table->retrieve_user($user_id);
	        if($user_data)
	        {
	            $user_email = $user_data['EMAIL'];
	            $email = new user_mail();
	            $email->set_to($user_email);
	            $email->set_subject('Account Confirmation');
	            $message_body = $email->generate_confirmation_email_body($hash,$first_name,$last_name);
	            $email->set_message_body($message_body);
	            $return = $email->send_mail();
	            if($return)
	            {
	                return true;
	            }
	        }
	    }
	    return false;
	}

	function send_confirmation_email_merch($user_id)
	{
	    $user_table = new user_table();
	    $user_data = $user_table->retrieve_user($user_id);
	        if($user_data)
	        {
	            $user_email = $user_data['EMAIL'];
	            $email = new user_mail();
	            $email->set_to($user_email);
	            $email->set_subject('Account Confirmation');
	            $message_body = $email->generate_confirmation_email_body_merch();
	            $email->set_message_body($message_body);
	            $return = $email->send_mail();
	            if($return)
	            {
	                return true;
	            }
	        }

	    return false;
	}

	function create_notification_string($notification)
	{
	    $message = '';
	    if(is_array($notification))
	    {
	        if(array_key_exists('error', $notification) and count($notification['error'])>0)
	        {
	            $errors = $notification['error'];
	            $message = 'error='.json_encode($errors);
	        }
	        else if(array_key_exists('success',$notification) and count($notification['success'])>0)
	        {
	            $errors = $notification['success'];
	            $message = 'success='.json_encode($errors);
	        }
	    }
	    return $message;
	}


	function conver_url_to_absolute_path($url)
	{
	    $url = str_replace(create_url(''), create_path(''), $url);
	    return $url;
	}

	function convert_absolute_path_to_url($path)
	{
	    $url = str_replace(create_path(''), create_url(''), $path);
	    return $url;
	}


	function create_directory($dir)
	{
	    $dir_list = explode('/',$dir);
	    $dir_name = '';
	    foreach($dir_list as $single_dir)
	    {
	        if($single_dir and !empty($single_dir))
	        {
	            $dir_name .= $single_dir.'/';
	            $dir_path = create_path($dir_name);
	            if (!file_exists($dir_path))
	            {
	                mkdir($dir_path, 0777);
	            }
	        }
	    }
	}




		$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
			function getOS() {

				global $user_agent;

					$os_platform    =   "Unknown OS Platform";

					$os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }

    return $os_platform;

}

					function getBrowser() {

						global $user_agent;

						$browser        =   "Unknown Browser";

						$browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}



?>
