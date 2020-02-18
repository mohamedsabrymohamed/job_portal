<?php
require_once 'inc.php';
require_once 'header.php';
?>
<div class="main">
    <section class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 latest-job margin-bottom-20">
                    <h1 class="text-center">Latest Events</h1>


                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="flex-row row">



                <?php
                $events_table  = new events_table();
                $company_table = new companies_table();
                $events_data   = $events_table->retrieve_all_events();

               if($events_data == false){
                   ?>
                   <h3 style="color: #6f0808;">No Events Found.</h3>
                   <?php
               }else{
                foreach ($events_data as $single_event){
                    $company_data = $company_table->retrieve_company_info($single_event['company_id']);
                ?>
            <div class="col-xs-6 col-sm-4 col-lg-3">
                <div class="thumbnail ">
                    <img src="uploads/logo/215_143/<?php echo $company_data['company_logo'];?>">
                    <div class="caption">
                        <h3><?php echo $single_event['event_title']?></h3>
                            <p class="flex-text text-muted"><?php echo substr($single_event['job_desc'], 0, 100);?></p>
                            <p>
                                <a class="btn btn-primary" href="event_single.php?id=<?php echo $single_event['id'];?>">Details</a>
                            </p>
                    </div>
                    <!-- /.caption -->
                </div>
                <!-- /.thumbnail -->
            </div>
<?php } }?>

        </div>
        <!-- /.flex-row  -->
