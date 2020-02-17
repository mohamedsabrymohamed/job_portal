<?php
require_once 'company_dashboard_header.php';
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <div class="col-md-9 bg-white padding-2">
        <h2>Recent Applications</h2>

        <?php
        $user_jobs_table = new users_jobs_table();
        $jobs_table      = new jobs_table();
        $users_table     = new users_table();
        $user_jobs_data  = $user_jobs_table->retrieve_all_user_jobs_by_company_id(get_login_company_id_company());
        foreach ($user_jobs_data as $single_job){
                ?>
                <div class="attachment-block clearfix padding-2">
                    <h4 class="attachment-heading"><a href="user_application.php?id=<?php echo $single_job['id']; ?>">
                            <?php
                            $user_data = $users_table->retrieve_user($single_job['user_id']);
                            $job_data  =$jobs_table->retrieve_job_by_id($single_job['job_id']);
                            echo $job_data['job_title'].' @ ('.$user_data['full_name'].')'; ?>
                        </a></h4>
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
