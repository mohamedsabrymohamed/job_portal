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
                        $events_table = new events_table();
                        $event_data   = $events_table->retrieve_events_by_id($_GET['id']);
                        ?>
                        <div class="pull-left">
                            <h1 class="text-center"><?php echo $event_data['event_title']; ?></h1>

                        </div>

                        <div class="clearfix"></div>
                        <hr>
                        <div>
                            <p><span class="margin-right-10"><i class="fa fa-location-arrow text-green"></i> <?php echo $event_data['location']; ?></span> <i class="fa fa-calendar text-green"></i> <?php echo $event_data['event_date']; ?></p>
                        </div>
                        <div>
                            <h4 style="color:#FFF !important;"><?php echo stripcslashes($event_data['event_desc']); ?></h4>
                        </div>


                    </div>



                </div>
            </div>
        </div>
    </section>


