<?php
require_once 'company_dashboard_header.php';
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <div class="col-md-9 bg-white padding-2">
        <h2>Talent Database</h2>
        <p>In this section you can download resume of all candidates who applied to your job posts</p>
        <div class="row margin-top-20">
            <div class="col-md-12">
                <div class="box-body table-responsive no-padding">
                    <table id="example2" class="table table-hover">
                        <thead>
                        <th>Candidate Name</th>
                        <th>Job Title</th>
                        <th>Country</th>
                        <th>Download Resume</th>
                        </thead>
                        <tbody>
                        <?php
                            $user_jobs_table  = new users_jobs_table();
                            $user_jobs_data   = $user_jobs_table->retrieve_all_user_jobs_by_company_id(get_login_company_id_company());
                            $users_table      = new users_table();
                            $countries_table  = new country_table();
                            foreach ($user_jobs_data as $single_job){
                                $user_data    = $users_table->retrieve_user($single_job['user_id']);
                                $country_data = $countries_table->retrieve_country_by_id($user_data['country_id']);
                                ?>
                                <tr>
                                    <td><?php echo $user_data['full_name']; ?></td>
                                    <td><?php echo $user_data['job_title']; ?></td>
                                    <td>
                                        <?php echo $country_data['NAME_EN']; ?>
                                    </td>

                                    <td><a href="../uploads/cv/<?php echo $user_data['uploaded_cv']; ?>" download="<?php echo $user_data['full_name'].' Resume'; ?>"><i class="fa fa-file-pdf-o"></i></a></td>
                                </tr>

                                <?php

                            }

                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<!-- END MAIN -->
<div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
