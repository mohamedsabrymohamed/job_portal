<?php
require_once 'company_dashboard_header.php';
$events_table = new events_table();
$events_data  = $events_table->retrieve_all_events();
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <div class="col-md-9 bg-white padding-2">
        <div class="pull-right">
            <a href="add_event.php" class="btn btn-default btn-sm btn-flat margin-top-20"><i class="fa fa-plus"></i> Add New Event</a>
        </div>
        <h3 class="heading">My Job Posts</h3>
        <p>In this section you can view all events created by you.</p>
        <div class="row margin-top-20">
            <div class="col-md-12">
                <div class="box-body table-responsive no-padding">
                    <table id="example2" class="table table-hover">
                        <thead>
                        <th>Event Title</th>
                        <th>View</th>
                        <th>Edit</th>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($events_data as $sing_event){
                                ?>
                                <tr>
                                    <td><?php echo $sing_event['event_title']; ?></td>
                                    <td><a href="view_event.php?id=<?php echo $sing_event['id']; ?>"><i class="lnr lnr-briefcase"></i></a></td>
                                    <td><a href="edit_event.php?id=<?php echo $sing_event['id']; ?>"><i class="lnr lnr-code"></i></a></td>
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
