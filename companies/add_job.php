<?php
require_once 'company_dashboard_header.php';
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <form method="post" action="../process.php">
        <input type="hidden" name="form_name" value="add_job">
        <div class="col-md-12 latest-job ">
            <div class="form-group">
                <input class="form-control input-sm" type="text"  name="job_title" placeholder="Job Title" required>
            </div>

            <div class="form-group">
                <input class="form-control input-sm" type="number"  name="salary" placeholder="Salary" required>
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
                <label for="country">Category</label>
                <?php
                $job_cat_table = new job_cat_table();
                $job_cat_data  = $job_cat_table->retrieve_all_job_cat();
                ?>
                <select class="form-control input-sm" name="cat_id">
                    <?php
                    foreach ($job_cat_data as $single_cat){
                        ?>
                        <option value="<?php echo $single_cat['id']?>"><?php echo $single_cat['category_name']?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <textarea class="form-control input-sm" id="description" name="job_desc" rows="6" placeholder="Job Description"></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-flat btn-success">Create</button>
            </div>
        </div>
    </form>
</div>
<!-- END MAIN -->
<div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
