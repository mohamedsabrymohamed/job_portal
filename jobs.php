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

                if(isset($_GET) && !empty($_GET)){
                    if($_GET['country_id'] == 0 && $_GET['job_cat'] == 0){
                        $jobs_data  = $jobs_table->retrieve_all_jobs_with_keyword($_GET['keyword']);
                    }elseif($_GET['country_id'] != 0 && $_GET['job_cat'] != 0 && !empty($_GET['keyword'])){
                        $jobs_data  = $jobs_table->retrieve_all_jobs_with_all_parameters($_GET['country_id'] , $_GET['job_cat'] , $_GET['keyword']);
                    }elseif (empty($_GET['keyword']) && $_GET['job_cat'] == 0){
                        $jobs_data  = $jobs_table->retrieve_all_jobs_with_country_id($_GET['country_id']);
                    }elseif (empty($_GET['keyword']) && $_GET['country_id'] == 0){
                        $jobs_data  = $jobs_table->retrieve_all_jobs_with_cat_id($_GET['job_cat']);
                    }
                }else{
                    $jobs_data  = $jobs_table->retrieve_all_jobs();
                }
               if($jobs_data == false){
                   ?>
                   <h3 style="color: #6f0808;">No Jobs Found with you search.</h3>
                   <?php
               }else{
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
                                <a class="btn btn-primary" href="job_single.php?id=<?php echo $single_job['id'];?>">Details</a>
                            </p>
                    </div>
                    <!-- /.caption -->
                </div>
                <!-- /.thumbnail -->
            </div>
<?php } }?>

        </div>
        <!-- /.flex-row  -->
