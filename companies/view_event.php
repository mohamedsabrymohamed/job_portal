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
                    $events_table = new events_table();
                    $event_data   = $events_table->retrieve_events_by_id(($_GET['id']));
                        ?>
                        <div class="pull-left">
                            <h2><b><i><?php echo $event_data['event_title']; ?></i></b></h2>
                        </div>
                        <div class="pull-right">
                            <a href="event_posts.php" class="btn btn-default btn-sm btn-flat margin-top-20"><i class="fa fa-arrow-circle-left"></i> Back</a>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div>
                            <p><span class="margin-right-10"> <i class="fa fa-calendar text-green"></i> <?php echo $event_data['event_date']; ?></p>
                        </div>
                        <div>
                            <?php echo stripcslashes($event_data['event_desc']); ?>
                        </div>
                        <div>
                        </div>

            </div>
        </div>

    </div>
</div>
</div>
<!-- END MAIN -->
<div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
