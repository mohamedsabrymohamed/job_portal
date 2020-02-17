<?php 
    require_once '../inc.php';
if(is_company_login_company())
{
$login_table=new log_table();
$session_id = session_id();
$update_login=$login_table->update_login_company(get_login_company_id_company(),session_id());
unset_user_session();
}
?><script>window.location = '../index.php';</script><?php
?>
