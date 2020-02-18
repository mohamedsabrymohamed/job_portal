<?php
require_once 'company_dashboard_header.php';
$job_cat_table = new job_cat_table();
$job_cat_data  = $job_cat_table->retrieve_category_by_id($_GET['id']);
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <form method="post" action="../process.php">
        <input type="hidden" name="form_name" value="edit_job_cat">
        <input type="hidden" name="cat_id" value="<?php echo $_GET['id'];?>">

        <div class="col-md-12 latest-job ">
            <div class="form-group">
                <input class="form-control input-sm" type="text"  name="job_cat_name" placeholder="Job Category Name" required value="<?php echo $job_cat_data['category_name'];?>">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-flat btn-success">Edit</button>
            </div>
        </div>
    </form>
</div>
<!-- END MAIN -->
<div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
