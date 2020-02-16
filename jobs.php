<?php
require_once 'inc.php';
require_once 'header.php';
?>
<div class="main">
    <section class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 latest-job margin-bottom-20">
                    <h1 class="text-center">Latest Jobs</h1>


                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="flex-row row">



                <?php
                $jobs_table = new jobs_table();
                $company_table = new companies_table();
                $jobs_data  = $jobs_table->retrieve_all_jobs();
                foreach ($jobs_data as $single_job){
                    $company_data = $company_table->retrieve_company_info($single_job['company_id']);
                ?>
            <div class="col-xs-6 col-sm-4 col-lg-3">
                <div class="thumbnail ">
                    <img src="uploads/logo/215_143/<?php echo $company_data['company_logo'];?>">
                    <div class="caption">
                        <h3><?php echo $single_job['job_title']?></h3>
                            <p class="flex-text text-muted"><?php echo substr($single_job['job_desc'], 0, 100);?></p>
                            <p>
                                <a class="btn btn-primary" href="#">Details</a>
                            </p>
                    </div>
                    <!-- /.caption -->
                </div>
                <!-- /.thumbnail -->
            </div>
<?php }?>

        </div>
        <!-- /.flex-row  -->
