<?php
require_once 'company_dashboard_header.php';
$companies_table = new companies_table();
$company_data    = $companies_table->retrieve_company(get_login_company_id_company());
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">

    <div class="row">
        <form action="../process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="form_name" value="company_profile_edit">
            <input type="hidden" name="com_id" value="<?php echo get_login_company_id_company();?>">

                    <div class="col-md-6 latest-job ">
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" class="form-control input-sm" name="company_name" value="<?php echo $company_data['company_name']; ?>" required="">
                        </div>
                        <div class="form-group">
                            <label>Website</label>
                            <input type="text" class="form-control input-sm" name="website" value="<?php echo $company_data['website']; ?>" required="">
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control input-sm" name="phone" value="<?php echo $company_data['phone']; ?>" required="">
                        </div>

                        <div class="form-group">
                            <label>Location</label>
                            <input type="text" class="form-control input-sm" name="location" value="<?php echo $company_data['location']; ?>" required="">
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



                    </div>
                    <div class="col-md-6 latest-job ">

                        <div class="form-group">
                            <label>About</label>
                            <textarea class="form-control input-sm" rows="4" name="about"><?php echo $company_data['about']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Change Company Logo</label>
                            <input type="file" name="company_logo" class="btn btn-default">
                            <?php if($company_data['company_logo'] != "") { ?>
                                <br> <img src="../uploads/logo/215_143/<?php echo $company_data['company_logo']; ?>" class="img-responsive" >
                            <?php } ?>
                        </div>
                    </div>
            <div class="form-group">
                <button type="submit" class="btn btn-flat btn-success">Update Company Profile</button>
            </div>
        </form>
    </div>


</div>
</div>
</div>
<!-- END MAIN -->
<div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
