<?php
require_once 'company_dashboard_header.php';
$jobs_table = new jobs_table();
$jobs_data  = $jobs_table->retrieve_all_jobs();
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <div class="col-md-9 bg-white padding-2">
        <div class="pull-right">
            <a href="add_job.php" class="btn btn-default btn-sm btn-flat margin-top-20"><i class="fa fa-plus"></i> Add New Job</a>
        </div>
        <h3 class="heading">My Job Posts</h3>
        <p>In this section you can view all job posts created by you.</p>
        <div class="row margin-top-20">
            <div class="col-md-12">
                <div class="box-body table-responsive no-padding">
                    <table id="example2" class="table table-hover">
                        <thead>
                        <th>Job Title</th>
                        <th>View</th>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($jobs_data as $single_job){
                                ?>
                                <tr>
                                    <td><?php echo $single_job['job_title']; ?></td>
                                    <td><a href="view_job.php?id=<?php echo $single_job['id']; ?>"><i class="lnr lnr-briefcase"></i></a></td>
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
<div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
