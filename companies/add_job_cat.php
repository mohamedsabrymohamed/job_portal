<?php
require_once 'company_dashboard_header.php';
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <form method="post" action="../process.php">
        <input type="hidden" name="form_name" value="add_job_cat">

        <div class="col-md-12 latest-job ">
            <div class="form-group">
                <input class="form-control input-sm" type="text"  name="job_cat_name" placeholder="Job Category Name" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-flat btn-success">Add</button>
            </div>
        </div>
    </form>
</div>
<!-- END MAIN -->
<div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
