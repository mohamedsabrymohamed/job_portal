<?php 
	//env
	
	$URL='squadro/Home';
    require_once (realpath($_SERVER["DOCUMENT_ROOT"]) ."/".$URL.'/inc.php');
    if(!is_user_login())
    {
        ?><script>window.location = 'index.php';</script><?php
    }
	
	//prod
/*
	 require_once '../inc.php';
    if(!is_user_login())
    {
        ?><script>window.location = 'index.php';</script><?php
    }
*/
	?>