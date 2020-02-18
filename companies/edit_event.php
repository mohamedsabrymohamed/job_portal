<?php
require_once 'company_dashboard_header.php';
$events_table = new events_table();
$event_data   = $events_table->retrieve_events_by_id($_GET['id']);
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <form method="post" action="../process.php">
        <input type="hidden" name="form_name" value="edit_event">
        <input type="hidden" name="event_id" value="<?php echo $_GET['id'];?>">
        <div class="col-md-12 latest-job ">
            <div class="form-group">
                <input class="form-control input-sm" type="text"  name="event_title" placeholder="Event Title" required value="<?php echo $event_data['event_title']?>">
            </div>


                <div class="form-group">
                    <input class="form-control input-sm" type="date"  name="event_date" placeholder="Event Date" required value="<?php echo $event_data['event_date']?>">
                </div>

            <div class="form-group">
                <label for="country">Country</label>
                <?php
                $country_table = new country_table();
                $country_data  = $country_table->retrieve_all_country();
                ?>
                <select class="form-control input-sm" name="country_id">
                    <?php
                    foreach ($country_data as $single_country){
                        ?>
                        <option value="<?php echo $single_country['ID']?>"><?php echo $single_country['NAME_EN']?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <input class="form-control input-sm" type="text"  name="event_location" placeholder="Event Location" required>
            </div>


            <div class="form-group">
                <textarea class="form-control input-sm" id="description" name="event_desc" rows="6" placeholder="Job Description"> <?php echo $event_data['event_desc']?> </textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-flat btn-success">Edit</button>
            </div>
        </div>
    </form>
</div>
<!-- END MAIN -->
<div class="clearfix"></div>

<?php require_once 'dashboard_footer.php'?>
