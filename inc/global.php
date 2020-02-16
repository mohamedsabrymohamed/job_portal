<?php
    global $global_variable;
    $global_variable['site_url'] = 'http://localhost/cs_web_jobs/';

    $abosolute_path = dirname(__FILE__);
    $abosolute_path = str_replace('inc', '', $abosolute_path);
    $global_variable['site_path'] = $abosolute_path;

?>
