<?php
require_once 'inc.php';
require_once 'header.php';
?>
<div class="main">
    <section class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 latest-job margin-bottom-20">
                    <div class="col-md-12">
                        <?php
                        $jobs_table = new jobs_table();
                        $jobs_data  = $jobs_table->retrieve_job_by_id($_GET['id']);
                        ?>
                        <div class="pull-left">
                            <h1 class="text-center"><?php echo $jobs_data['job_title']; ?></h1>

                        </div>

                        <div class="clearfix"></div>
                        <hr>
                        <div>
                            <p><span class="margin-right-10"><i class="fa fa-location-arrow text-green"></i> <?php echo $jobs_data['salary']; ?> $ Salary</span> <i class="fa fa-calendar text-green"></i> <?php echo $jobs_data['created_date']; ?></p>
                        </div>
                        <div>
                            <h4 style="color:#FFF !important;"><?php echo stripcslashes($jobs_data['job_desc']); ?></h4>
                        </div>
                        <div >
                            <form action="process.php" method="post">
                                <input type="hidden" name="form_name" value="apply_job">
                                <input type="hidden" name="job_id" value="<?php echo $_GET['id'];?>">
                                <input type="hidden" name="comp_id" value="<?php echo $jobs_data['company_id'];?>">
                                <input type="hidden" name="uuid" value="<?php echo get_login_user_id();?>">

                                <button type="submit" style="color: rgb(240, 102, 22) !important;" class="btn btn-default btn-bg btn-flat margin-top-20"><i class="fa fa-wpforms"></i> Submit Job</button>
                            </form>
                        </div>

                    </div>



                </div>
            </div>
        </div>
    </section>


