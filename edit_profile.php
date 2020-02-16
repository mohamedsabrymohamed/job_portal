<?php
require_once 'dashboard_header.php';
$user_table = new users_table();
$user_data  = $user_table->retrieve_user_info(get_login_user_id());
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <form action="process.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="form_name" value="edit_profile">
        <input type="hidden" name="uid" value="<?php echo get_login_user_id();?>">

                <div class="row">
                    <div class="col-md-6 latest-job ">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control input-sm" id="full_name" name="full_name" placeholder="Full Name" value="<?php echo $user_data['full_name']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control input-sm" id="mobile" name="mobile" placeholder="Mobile" value="<?php echo $user_data['mobile']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="job_title">Job Title</label>
                            <input type="text" class="form-control input-sm" id="job_title" name="job_title" placeholder="Job Title" value="<?php echo $user_data['job_title']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="birth_date">Birth Date</label>
                            <input type="date" class="form-control input-sm" id="birth_date" name="birth_date" placeholder="Birth Date" value="<?php echo $user_data['birth_date']; ?>" >
                        </div>

                        <div class="form-group">
                            <label for="country">Country</label>
                            <?php
                            $country_table = new country_table();
                            $country_data  = $country_table->retrieve_all_country();
                            ?>
                            <select class="form-control input-sm" name="country_id">
                                <?php
                                foreach ($country_data as $single_country){
                                    ?>
                                    <option value="<?php echo $single_country['ID']?>"><?php echo $single_country['NAME_EN']?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="facebook_link">Facebook Profile</label>
                            <input type="text" class="form-control input-sm" id="facebook_link" name="facebook_link" placeholder="Facebook Profile" value="<?php echo $user_data['facebook_link']; ?>" >
                        </div>

                        <div class="form-group">
                            <label for="twitter_link">Twitter Profile</label>
                            <input type="text" class="form-control input-sm" id="twitter_link" name="twitter_link" placeholder="Twitter Profile" value="<?php echo $user_data['twitter_link']; ?>" >
                        </div>

                        <div class="form-group">
                            <label for="linkedin_link">LinkedIn Profile</label>
                            <input type="text" class="form-control input-sm" id="linkedin_link" name="linkedin_link" placeholder="LinkedIn Profile" value="<?php echo $user_data['linkedin_link']; ?>" >
                        </div>


                    </div>
                    <div class="col-md-6 latest-job ">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control input-sm" id="address" name="address" placeholder="Address" value="<?php echo $user_data['address']; ?>" >
                        </div>


                        <div class="form-group">
                            <label>Skills</label>
                            <textarea class="form-control input-sm" rows="4" name="skills"><?php echo $user_data['skills']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>About Me</label>
                            <textarea class="form-control input-sm" rows="4" name="about"><?php echo $user_data['about']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Upload/Change Resume</label>
                            <input type="file" name="resume" class="btn btn-default">
                        </div>

                        <div class="form-group">
                            <label>Upload/Change Profile Image</label>
                            <input type="file" name="profile_img" class="btn btn-default">
                            <?php if($user_data['profile_image'] != "") { ?>
                                <br> <img src="uploads/profile_img/64_64/<?php echo $user_data['profile_image']; ?>" class="img-responsive" >
                            <?php } ?>
                        </div>
                    </div>
                </div>

        <div class="form-group">
            <button type="submit" class="btn btn-flat btn-success">Update Profile</button>
        </div>

    </form>

</div>


<!-- END MAIN -->

<div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
