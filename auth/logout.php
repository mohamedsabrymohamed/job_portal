<?php 
    require_once '../inc.php';
    if(is_user_login())
    {
		$login_table=new log_table();
		$session_id = session_id();
		$update_login=$login_table->update_login_user(get_login_user_id(),session_id());
		unset_user_session();
    }
    ?><script>window.location = '../index.php';</script><?php

