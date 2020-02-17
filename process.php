<?php
require_once 'inc.php';
$notification = array();
$notification['error'] = array();
$notification['success'] = array();

if($_POST){
    $form_name = $_POST['form_name'];
    if($form_name and !empty($form_name))
    {
        switch($form_name)
        {

                            //////////////////// USERS///////////////////////
                            ////////////////////////////////////////////////
            case 'user_login':
                {
                    $form_type = $_POST['form_type'];
                    $user_email = $_POST['email'];
                    $user_password = $_POST['password'];
                    $user_table = new users_table();
                    $user_id = $user_table->verify_user($user_email, $user_password);
                    $user_type=$user_table->retrieve_user($user_id);
                    $login_table = new log_table();
                    if (empty($user_id)){
                        $reason="wrong username or password";
                        $notification['error'][] = "Please check username or password.";
                        $_SESSION['err_uname_pass']= "Please check username or password.";
                        $notification_string = create_notification_string($notification);
                        $redirect_path = 'login.php';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path."?err_uname_pass=Y"; ?>'; </script><?php

                    }

                    $errors = $notification['error'];
                    if($errors and !empty($errors))
                    {

                        $notification_string = create_notification_string($notification);
                        $_SESSION['login_error']=$notification_string;
                        $redirect_path = 'index.php';

                        if($form_type!="ajax")
                        {
                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path; ?>'; </script><?php
                        }
                        else
                        {
                            foreach($errors as $error)
                                $notification['error']= array();

                        }
                    }
                    else
                    {
                        if($form_type=="ajax")
                        {
                            if($user_id and !empty($user_id))
                            {

                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['timeout'] = time();
                                $_SESSION['web_session_timeout'] = 900;

                                $log_table = new log_table();
                                $log_table->create_login_log();

                            }

                            else
                            {

                                $notification['error'][] = "Something went wrong. Please check again.";
                                $_SESSION['u_no_login_error']= "Something went wrong. Please check again.";
                                setcookie("err_count",$count + 1,+time() + 60);
                                $notification_string = create_notification_string($notification);
                                $redirect_path = 'login.php';
                                ?><script type="text/javascript">window.location = '<?php echo $redirect_path."?nou=Y"; ?>'; </script><?php
                            }


                            $user_type=$user_table->retrieve_user($user_id);
                            $login_table = new log_table();
                            $redirect_path = 'index.php';


                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path;?>'; </script><?php

                        }
                    }

                    break;
                }

            case 'user_register':
                {
                    $errors = array();
                    $user_data = array();
                    $user_data['email']               = $_POST['email'];
                    $user_data['full_NAME']           = $_POST['full_name'];
                    $user_data['password']            = $_POST['password'];
                    $user_data['confirm_password']    = $_POST['confirm_password'];
                    if(count($notification['error']) == 0)
                    {
                        $user_table = new users_table();
                        $user_exist = $user_table->is_user_registered($_POST['email']);
                        if($user_exist)
                        {
                            $notification['error'] = array();
                            $notification['error'][] = 'user already exist';
                            $_SESSION['u_reg_error']='user already exist';
                            $redirect_path = 'register.php';
                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path."?u_reg_error=Y"; ?>'; </script><?php
                        }
                        else
                        {
                            $user_table = new users_table();
                            $user_id = $user_table->add_new_user($user_data);
                        }
                    }

                    $errors = $notification['error'];
                    if($errors and count($errors)>0)
                    {
                        $notification_string = create_notification_string($notification);
                        $_SESSION['u_r_error'] = $notification_string;
                        ?><script type="text/javascript">window.location = '<?php echo 'register.php'; ?>'; </script><?php

                    }
                    else
                    {


                        $notification['error'] = array();
                        $_SESSION['u_reg_succ']='Thank you for registration. You can login now.';
                        $redirect_path = 'login.php';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path."?u_reg_succ=Y"; ?>'; </script><?php

                    }

                    break;
                }

            case 'edit_profile':
                {

                    $data = array();
                    $data['full_name']      = $_POST['full_name'];
                    $data['mobile']         = $_POST['mobile'];
                    $data['job_title']      = $_POST['job_title'];
                    $data['birth_date']     = $_POST['birth_date'];
                    $data['country_id']     = $_POST['country_id'];
                    $data['facebook_link']  = $_POST['facebook_link'];
                    $data['twitter_link']   = $_POST['twitter_link'];
                    $data['linkedin_link']  = $_POST['linkedin_link'];
                    $data['address']        = $_POST['address'];
                    $data['skills']         = $_POST['skills'];
                    $data['about']          = $_POST['about'];

                    //upload Profile Image
                    // upload original image
                    $upload_path = $_SERVER["DOCUMENT_ROOT"]."/cs_web_jobs/uploads/profile_img/original/";
                    $upload_thumb_path = $_SERVER["DOCUMENT_ROOT"]."/cs_web_jobs/uploads/profile_img/64_64/";
                    $target_file = basename($_FILES["profile_img"]["name"]);
                    $foo = new upload($_FILES['profile_img']);
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                    $new_file_name = time();

                    if ($foo->uploaded) {
                        $foo->file_new_name_body = $new_file_name;
                        $file_name = $foo->Process($upload_path);
                        if ($foo->processed) {
                            //resize 64 * 64
                            $foo->file_new_name_body = $new_file_name;
                            $foo->image_resize = true;
                            $foo->image_x = 64;
                            $foo->image_y = 64;
                            $foo->Process($upload_thumb_path);
                            if ($foo->processed) {
                                $foo->Clean();
                                $data['profile_image']        = $new_file_name.'.'.$imageFileType;
                                $redirect_path = 'edit_profile.php';
                                $_SESSION['err_img_upload'] = $foo->error;
                                ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_img_upload=Y'; ?>'; </script><?php

                            } else {
                                $redirect_path = 'edit_profile.php';
                                $_SESSION['err_img_upload'] = $foo->error;
                                ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_img_upload=Y'; ?>'; </script><?php
                            }

                        } else {
                            $redirect_path = 'edit_profile.php';
                            $_SESSION['err_img_upload'] = $foo->error;
                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_img_upload=Y'; ?>'; </script><?php
                        }
                    }
                    // end profile Image upload

                    //upload CV
                    // upload original image
                    $cv_upload_path = $_SERVER["DOCUMENT_ROOT"]."/cs_web_jobs/uploads/cv/";
                    $cv_file = basename($_FILES["resume"]["name"]);
                    $foo = new upload($_FILES['resume']);
                    $cvFileType = pathinfo($cv_file,PATHINFO_EXTENSION);

                    $cv_file_name = time();

                    if ($foo->uploaded) {
                        $foo->file_new_name_body = $cv_file_name;
                        $file_name = $foo->Process($cv_upload_path);

                            if ($foo->processed) {
                                $foo->Clean();
                                $data['uploaded_cv']        = $cv_file_name.'.'.$cvFileType;
                                $redirect_path = 'edit_profile.php';
                                $_SESSION['err_img_upload'] = $foo->error;
                                ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_img_upload=Y'; ?>'; </script><?php
                            } else {
                            $redirect_path = 'edit_profile.php';
                            $_SESSION['err_img_upload'] = $foo->error;
                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_img_upload=Y'; ?>'; </script><?php
                        }
                    }

                    $user_table              = new users_table();
                    $where                   = 'id = ' . $_POST['uid'];
                    $edit_data               = $user_table->update_user($data,$where);

                    if ( !empty($add_data) ) {
                        $redirect_path = 'edit_profile.php';
                        $_SESSION['succ_post_add'] = 'Successfully add Post';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?succ_post_add=Y'; ?>'; </script><?php


                    }
                    else{
                        $redirect_path = 'edit_profile.php';
                        $_SESSION['err_post_add'] = 'Error Creating Post. Please Try Again';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_post_add=Y'; ?>'; </script><?php
                    }
                    break;
                }



                            //////////////////// Companies ///////////////////////
                            ////////////////////////////////////////////////
            case 'company_login':
                {
                    $form_type = $_POST['form_type'];
                    $user_email = $_POST['email'];
                    $user_password = $_POST['password'];
                    $company_table = new companies_table();
                    $company_id = $company_table->verify_company($user_email, $user_password);
                    $company_type=$company_table->retrieve_company($company_id);
                    $login_table = new log_table();
                    if (empty($company_id)){
                        $reason="wrong username or password";
                        $notification['error'][] = "Please check username or password.";
                        $_SESSION['err_compname_pass']= "Please check username or password.";
                        $notification_string = create_notification_string($notification);
                        $redirect_path = 'company_login.php';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path."?err_compname_pass=Y"; ?>'; </script><?php

                    }

                    $errors = $notification['error'];
                    if($errors and !empty($errors))
                    {

                        $notification_string = create_notification_string($notification);
                        $_SESSION['login_error']=$notification_string;
                        $redirect_path = 'index.php';

                        if($form_type!="ajax")
                        {
                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path; ?>'; </script><?php
                        }
                        else
                        {
                            foreach($errors as $error)
                                $notification['error']= array();

                        }
                    }
                    else
                    {
                        if($form_type=="ajax")
                        {
                            if($company_id and !empty($company_id))
                            {

                                $_SESSION['company_id'] = $company_id;
                                $_SESSION['timeout'] = time();
                                $_SESSION['web_session_timeout'] = 900;

                                $log_table = new log_table();
                                $log_table->create_login_log();

                            }

                            else
                            {

                                $notification['error'][] = "Something went wrong. Please check again.";
                                $_SESSION['comp_no_login_error']= "Something went wrong. Please check again.";
                                setcookie("err_count",$count + 1,+time() + 60);
                                $notification_string = create_notification_string($notification);
                                $redirect_path = 'company_login.php';
                                ?><script type="text/javascript">window.location = '<?php echo $redirect_path."?nocomp=Y"; ?>'; </script><?php
                            }


                            $company_type= $company_table->retrieve_company($company_id);
                            $login_table = new log_table();
                            $redirect_path = 'index.php';


                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path;?>'; </script><?php

                        }
                    }

                    break;
                }

            case 'company_register':
                {
                    $errors = array();
                    $company_data = array();
                    $company_data['email']               = $_POST['email'];
                    $company_data['company_name']        = $_POST['company_name'];
                    $company_data['password']            = $_POST['password'];
                    $company_data['confirm_password']    = $_POST['confirm_password'];
                    if(count($notification['error']) == 0)
                    {
                        $companies_table = new companies_table();
                        $company_exist = $companies_table->is_company_exist($_POST['email']);
                        if($company_exist)
                        {
                            $notification['error'] = array();
                            $notification['error'][] = 'Company already exist';
                            $_SESSION['company_reg_error']='Company already exist';
                            $redirect_path = 'company_registration.php';
                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path."?company_reg_error=Y"; ?>'; </script><?php
                        }
                        else
                        {
                            $companies_table = new companies_table();
                            $company_id = $companies_table->add_new_company($company_data);
                        }
                    }

                    $errors = $notification['error'];
                    if($errors and count($errors)>0)
                    {
                        $notification_string = create_notification_string($notification);
                        $_SESSION['company_reg_error'] = $notification_string;
                        ?><script type="text/javascript">window.location = '<?php echo 'company_registration.php'; ?>'; </script><?php

                    }
                    else
                    {


                        $notification['error'] = array();
                        $_SESSION['company_reg_succ']='Thank you for registration. You can login now.';
                        $redirect_path = 'company_login.php';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path."?company_reg_succ=Y"; ?>'; </script><?php

                    }

                    break;
                }

            case 'company_profile_edit':
                {

                    $data = array();
                    $data['company_name']      = $_POST['company_name'];
                    $data['website']           = $_POST['website'];
                    $data['phone']             = $_POST['phone'];
                    $data['location']          = $_POST['location'];
                    $data['country_id']        = $_POST['country_id'];
                    $data['about']             = $_POST['about'];

                    //upload company logo
                    // upload original image
                    $upload_path = $_SERVER["DOCUMENT_ROOT"]."/cs_web_jobs/uploads/logo/original/";
                    $upload_thumb_path = $_SERVER["DOCUMENT_ROOT"]."/cs_web_jobs/uploads/logo/215_143/";
                    $target_file = basename($_FILES["company_logo"]["name"]);
                    $foo = new upload($_FILES['company_logo']);
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                    $new_file_name = time();

                    if ($foo->uploaded) {
                        $foo->file_new_name_body = $new_file_name;
                        $file_name = $foo->Process($upload_path);
                        if ($foo->processed) {
                            //resize 64 * 64
                            $foo->file_new_name_body = $new_file_name;
                            $foo->image_resize = true;
                            $foo->image_x = 215;
                            $foo->image_y = 143;
                            $foo->Process($upload_thumb_path);
                            if ($foo->processed) {
                                $foo->Clean();
                                $data['company_logo']        = $new_file_name.'.'.$imageFileType;
                                $redirect_path = 'companies/profile.php';
                                $_SESSION['err_img_upload'] = $foo->error;
                                ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_img_upload=Y'; ?>'; </script><?php

                            } else {
                                $redirect_path = 'companies/profile.php';
                                $_SESSION['err_img_upload'] = $foo->error;
                                ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_img_upload=Y'; ?>'; </script><?php
                            }

                        } else {
                            $redirect_path = 'companies/profile.php';
                            $_SESSION['err_img_upload'] = $foo->error;
                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_img_upload=Y'; ?>'; </script><?php
                        }
                    }
                    // end company logo upload



                    $companies_table              = new companies_table();
                    $where                   = 'id = ' . $_POST['com_id'];
                    $edit_data               = $companies_table->update_company($data,$where);

                    if ( !empty($add_data) ) {
                        $redirect_path = 'companies/profile.php';
                        $_SESSION['succ_post_add'] = 'Successfully add Post';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?succ_post_add=Y'; ?>'; </script><?php


                    }
                    else{
                        $redirect_path = 'companies/profile.php';
                        $_SESSION['err_post_add'] = 'Error Creating Post. Please Try Again';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_post_add=Y'; ?>'; </script><?php
                    }
                    break;
                }





            case 'add_job':
                {
                    $data = array();
                    $data['job_title']      = $_POST['job_title'];
                    $data['salary']         = $_POST['salary'];
                    $data['country_id']     = $_POST['country_id'];
                    $data['job_cat']        = $_POST['cat_id'];
                    $data['job_desc']       = $_POST['job_desc'];
                    $data['company_id']     = get_login_company_id_company();

                    $jobs_table             = new jobs_table();
                    $add_data                = $jobs_table->add_new_data($data);

                    if ( !empty($add_data) ) {
                        $redirect_path = 'companies/job_posts.php';
                        $_SESSION['succ_post_add'] = 'Successfully add Post';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?succ_post_add=Y'; ?>'; </script><?php


                    }
                    else{
                        $redirect_path = 'companies/job_posts.php';
                        $_SESSION['err_post_add'] = 'Error Creating Post. Please Try Again';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_post_add=Y'; ?>'; </script><?php
                    }

                    break;
                }



            case 'apply_job':
                {
                    if($_POST['uuid'] == 0){
                        $_SESSION['not_login']= "Please Please login to submit for jobs.";
                        $notification_string = create_notification_string($notification);
                        $redirect_path = 'login.php';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path."?not_login=Y"; ?>'; </script><?php

                    }else{

                        $data = array();
                        $data['user_id']     = $_POST['uuid'];
                        $data['job_id']      = $_POST['job_id'];
                        $data['company_id']  = $_POST['comp_id'];


                        $user_jobs               = new users_jobs_table();
                        $add_data                = $user_jobs->add_new_data($data);

                        if ( !empty($add_data) ) {
                            $redirect_path = 'dashboard.php';
                            $_SESSION['succ_job_add'] = 'Successfully add Post';
                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?succ_job_add=Y'; ?>'; </script><?php


                        }
                        else{
                            $redirect_path = 'job_single.php';
                            $_SESSION['err_job_add'] = 'Error Creating Post. Please Try Again';
                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path.'?err_job_add=Y'; ?>'; </script><?php
                        }


                    }
                    break;
                }



                            //////////////////// Admin ///////////////////////
                            ////////////////////////////////////////////////
            case 'admin_login_form':
                {
                    $form_type = $_POST['form_type'];
                    $user_email = $_POST['email'];
                    $user_password = $_POST['password'];
                    $admins_table = new admins_table();
                    $admin_id = $admins_table->verify_user($user_email, $user_password);
                    $user_type=$admins_table->retrieve_user($admin_id);
                    $login_table = new log_table();
                    if (empty($admin_id)){
                        $reason="wrong username or password";
                         $notification['error'][] = "Please check username or password.";
                        $_SESSION['errup']= "Please check username or password.";
                        $notification_string = create_notification_string($notification);
                        $redirect_path = 'index.php';
                        ?><script type="text/javascript">window.location = '<?php echo $redirect_path."?errup=Y"; ?>'; </script><?php

                    }

                    $errors = $notification['error'];
                    if($errors and !empty($errors))
                    {

                        $notification_string = create_notification_string($notification);
                        $_SESSION['login_error']=$notification_string;
                        $redirect_path = 'index.php';

                        if($form_type!="ajax")
                        {
                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path; ?>'; </script><?php
                        }
                        else
                        {
                            foreach($errors as $error)
                                $notification['error']= array();

                        }
                    }
                    else
                    {
                        if($form_type=="ajax")
                        {
                            if($admin_id and !empty($admin_id))
                            {

                                $_SESSION['user_id'] = $admin_id;
                                $_SESSION['timeout'] = time();
                                $_SESSION['web_session_timeout'] = 900;

                                $log_table = new log_table();
                                $log_table->create_login_log();

                            }

                            else
                            {

                                $notification['error'][] = "Something went wrong. Please check again.";
                                $_SESSION['u_no_login_error']= "Something went wrong. Please check again.";
                                setcookie("err_count",$count + 1,+time() + 60);
                                $notification_string = create_notification_string($notification);
                                $redirect_path = 'index.php';
                                ?><script type="text/javascript">window.location = '<?php echo $redirect_path."?nou=Y"; ?>'; </script><?php
                            }


                            $user_type=$admins_table->retrieve_user($admin_id);
                            $login_table = new log_table();
                            $redirect_path = 'welcome.php';


                            ?><script type="text/javascript">window.location = '<?php echo $redirect_path;?>'; </script><?php

                        }
                    }

                    break;
                }


        }
    }
}




if($_GET) {

    // mark job under review

    $job_und_rev = @$_GET['job_und_rev'];
    if ($job_und_rev and !empty($job_und_rev)) {

        $notification_string = create_notification_string($notification);

        $user_jobs      = new users_jobs_table();
        $user_jobs_data = $user_jobs->retrieve_user_jobs_by_id($job_und_rev);

        if ($user_jobs_data) {
            $user_jobs      = new users_jobs_table();
            $update_job     = $user_jobs->under_review_job($job_und_rev);
        }
        $_SESSION['under_rev_job'] = "Marked Successfully.";
        $redirect_path = 'companies/job_applications.php';
        ?>
        <script type="text/javascript">window.location = '<?php echo $redirect_path . '?under_rev_job=Y'; ?>'; </script><?php
    }


    // Approve Job

    $job_approve = @$_GET['job_approve'];
    if ($job_approve and !empty($job_approve)) {

        $notification_string = create_notification_string($notification);

        $user_jobs      = new users_jobs_table();
        $user_jobs_data = $user_jobs->retrieve_user_jobs_by_id($job_approve);

        if ($user_jobs_data) {
            $user_jobs      = new users_jobs_table();
            $update_job     = $user_jobs->approve_job($job_approve);
        }
        $_SESSION['approve_job'] = "Approved Successfully.";
        $redirect_path = 'companies/job_applications.php';
        ?>
        <script type="text/javascript">window.location = '<?php echo $redirect_path . '?approve_job=Y'; ?>'; </script><?php
    }


    // Approve Job

    $job_reject = @$_GET['job_reject'];
    if ($job_reject and !empty($job_reject)) {

        $notification_string = create_notification_string($notification);

        $user_jobs      = new users_jobs_table();
        $user_jobs_data = $user_jobs->retrieve_user_jobs_by_id($job_reject);

        if ($user_jobs_data) {
            $user_jobs      = new users_jobs_table();
            $update_job     = $user_jobs->reject_job($job_reject);
        }
        $_SESSION['reject_job'] = "Rejected Successfully.";
        $redirect_path = 'companies/job_applications.php';
        ?>
        <script type="text/javascript">window.location = '<?php echo $redirect_path . '?reject_job=Y'; ?>'; </script><?php
    }



}