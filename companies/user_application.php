<?php
require_once 'company_dashboard_header.php';
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <div class="col-md-9 bg-white padding-2">
        <div class="row margin-top-20">
            <div class="col-md-12">
                <?php
                        $user_jobs       = new users_jobs_table();
                        $user_jobs_data  = $user_jobs->retrieve_user_jobs_by_id($_GET['id']);
                        $user_table      = new users_table();
                        $user_data       = $user_table->retrieve_user($user_jobs_data['user_id']);
                        $countries_table = new country_table();
                        ?>
                        <div class="pull-left">
                            <h2><b><i><?php echo $user_data['full_name']; ?></i></b></h2>
                        </div>
                        <div class="pull-right">
                            <a href="job_applications.php" class="btn btn-default btn-sm btn-flat margin-top-20"><i class="fa fa-arrow-circle-left"></i> Back</a>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div>
                            <?php
                            $country_data = $countries_table->retrieve_country_by_id($user_data['country_id']);
                            echo 'Email : '.$user_data['email'];
                            echo '<br>';
                            echo '<br>';

                            echo 'Country : '.$country_data['NAME_EN'];
                            echo '<br>';
                            echo '<br>';
                            echo '<br>';
                            if($user_data['uploaded_cv'] != "") {
                                echo '<a href="../uploads/cv/'.$user_data['uploaded_cv'].'" class="btn btn-info" download="Resume">Download Resume</a>';
                            }
                            echo '<br>';
                            echo '<br>';
                            echo '<br>';
                            echo '<br>';
                            ?>
                            <div class="row">
                                <div class="col-md-4 pull-left">
                                    <a href="../process.php?job_und_rev=<?php echo $_GET['id']; ?>" class="btn btn-warning">Mark Under Review</a>
                                </div>

                                <div class="col-md-4 ">
                                    <a href="../process.php?job_approve=<?php echo $_GET['id']; ?>" class="btn btn-success">Approve Application</a>
                                </div>

                                <div class="col-md-4 pull-right">
                                    <a href="../process.php?job_reject=<?php echo $_GET['id']; ?>" class="btn btn-danger">Reject Application</a>
                                </div>
                            </div>
                        </div>

                        <div>
                        </div>

            </div>
        </div>

    </div>
</div>
<!-- END MAIN -->
<div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
