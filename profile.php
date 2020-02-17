<?php
require_once 'dashboard_header.php';
$user_table         = new users_table();
$user_data          = $user_table->retrieve_user_info(get_login_user_id());
$user_jobs_table    = new users_jobs_table();
$user_applied_jobs  = $user_jobs_table->retrieve_all_user_applied_jobs_by_user_id(get_login_user_id());
$user_approved_jobs = $user_jobs_table->retrieve_all_user_approved_jobs_by_user_id(get_login_user_id());

?>

    <div id="wrapper">
        <?php require_once 'dashboard_sidebar.php'?>

    </div>

<div class="main">
    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="panel panel-profile">
                <div class="clearfix">
                    <!-- LEFT COLUMN -->
                    <div class="profile-left">
                        <!-- PROFILE HEADER -->
                        <div class="profile-header">
                            <div class="overlay"></div>
                            <div class="profile-main">
                                <?php
                                if(empty($user_data['profile_image'])){
                                ?>
                                <img src="assets/img/user1.png" class="img-circle" alt="Avatar">
                                <?php } else{?>
                                    <img src="uploads/profile_img/64_64/<?php echo $user_data['profile_image']; ?>" class="img-circle" alt="Avatar">
                                <?php }?>
                                <h3 class="name"><?php echo $user_data['full_name'];?></h3>
                                <span class="online-status status-available"><?php echo $user_data['job_title'];?></span>
                            </div>
                            <div class="profile-stat">
                                <div class="row">

                                    <div class="col-md-6 stat-item">
                                        <?php echo count($user_applied_jobs);?> <span>Applied</span>
                                    </div>
                                    <div class="col-md-6 stat-item">
                                        <?php echo count($user_approved_jobs);?> <span>Approved</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PROFILE HEADER -->
                        <!-- PROFILE DETAIL -->
                        <div class="profile-info">
                            <h4 class="heading">Social</h4>
                            <ul class="list-inline social-icons">
                                <li><a href="<?php echo $user_data['facebook_link'];?>" target="_blank" class="facebook-bg"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="<?php echo $user_data['twitter_link'];?>" target="_blank" class="twitter-bg"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="<?php echo $user_data['linkedin_link'];?>" target="_blank" class="linkedin-bg"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>




                    </div>
                    <!-- END PROFILE DETAIL -->
                </div>

                <!-- END LEFT COLUMN -->
                <!-- RIGHT COLUMN -->
                <div class="profile-right">
                    <div class="profile-info">
                        <ul class="list-unstyled list-justify">
                            <li><h4 class="heading">About<span>
                                        <a href="edit_profile.php" class="btn btn-primary btn-sm btn-block">Edit Profile</a> </span></h4></li>

                        </ul>
                        <p><?php echo $user_data['about'];?></p>

                    </div>

                    <div class="profile-info">
                        <ul class="list-unstyled list-justify">
                            <li><h4 class="heading">Skills<span></span></h4></li>

                        </ul>
                        <p><?php echo $user_data['skills'];?></p>

                    </div>

                    <!-- AWARDS -->

                    <!-- END AWARDS -->
                    <!-- TABBED CONTENT -->

                    <div class="profile-detail">
                        <div class="profile-info">
                            <h4 class="heading">Basic Info</h4>
                            <ul class="list-unstyled list-justify">
                                <li>Birthdate <span><?php echo $user_data['birth_date']; ?></span></li>
                                <li>Mobile <span><?php echo $user_data['mobile']; ?></span></li>
                                <li>Email <span><?php echo $user_data['email']; ?></span></li>
                                <li>Address<span><?php echo $user_data['address']; ?></span></li>
                                <li>Resume<span><a href="uploads/cv/<?php echo $user_data['uploaded_cv']; ?>" target="_blank"><?php echo $user_data['uploaded_cv']; ?></a></span></li>
                            </ul>
                        </div>

                        <!-- END TABBED CONTENT -->
                    </div>
                    <!-- END RIGHT COLUMN -->

                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT -->
</div>
    <!-- END MAIN -->
    <div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
