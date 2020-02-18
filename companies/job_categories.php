<?php
require_once 'company_dashboard_header.php';
$job_cat_table = new job_cat_table();
$job_cat_data  = $job_cat_table->retrieve_all_job_cat();
?>

<div id="wrapper">
    <?php require_once 'dashboard_sidebar.php'?>

</div>

<div class="main">
    <div class="col-md-9 bg-white padding-2">
        <div class="pull-right">
            <a href="add_job_cat.php" class="btn btn-default btn-sm btn-flat margin-top-20"><i class="fa fa-plus"></i> Add New Job Category</a>
        </div>
        <h3 class="heading">Job Categories</h3>
        <p>In this section you can view all job categories.</p>
        <div class="row margin-top-20">
            <div class="col-md-12">
                <div class="box-body table-responsive no-padding">
                    <table id="example2" class="table table-hover">
                        <thead>
                        <th>Job Category Title</th>
                        <th>Edit</th>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($job_cat_data as $single_cat){
                                ?>
                                <tr>
                                    <td><?php echo $single_cat['category_name']; ?></td>
                                    <td><a href="edit_job_cat.php?id=<?php echo $single_cat['id']; ?>"><i class="lnr lnr-code"></i></a></td>
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
