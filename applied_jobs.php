<?php
require_once 'dashboard_header.php';
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <div class="col-md-9 bg-white padding-2">
        <h2 class="attachment-heading-head">Recent Applications</h2>
        <p>Below you will find job roles you have applied for</p>

        <?php
        $user_jobs_table = new users_jobs_table();
        $jobs_table      = new jobs_table();
        $user_jobs_data  = $user_jobs_table->retrieve_all_user_applied_jobs_by_user_id(get_login_user_id());
        foreach ($user_jobs_data as $single_job){
                ?>
                <div class="attachment-block clearfix padding-2">
                    <h4 class="attachment-heading"><a><?php
                            $jobs_data = $jobs_table->retrieve_job_by_id($single_job['job_id']);
                            echo $jobs_data['job_title']; ?></a></h4>
                    <div class="attachment-text padding-2">
                        <div class="pull-left"><i class="fa fa-calendar"></i> <?php echo $single_job['applied_at']; ?></div>
                        <?php

                        if($single_job['status'] == 0) {
                            echo '<div class="pull-right"><strong class="text-orange">Pending</strong></div>';
                        } else if ($single_job['status'] == 1) {
                            echo '<div class="pull-right"><strong class="text-red">Approved</strong></div>';
                        } else if ($single_job['status'] == 2) {
                            echo '<div class="pull-right"><strong class="text-green">Rejected</strong></div> ';
                        }
                        else if ($single_job['status'] == 3) {
                            echo '<div class="pull-right"><strong class="text-green">Under Review</strong></div> ';
                        }
                        ?>

                    </div>
                </div>

                <?php
            }
        ?>

    </div>
</div>
</div>
<!-- END MAIN -->
<div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
