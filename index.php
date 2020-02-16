<?php
require_once 'inc.php';
require_once 'header.php';
?>

        <h1>All in One Job Portal</h1>
        <p>Find Jobs,Careers and Employment</p>

<div class="btn-wrap">
    <a>Search Job</a>
</div>
</div>

<form action="jobs.php" method="get">

    <div id="mainbox">
        <div class="card">
            <div class="label">KEYWORD?</div>
            <input class="form-control input-sm" placeholder="Enter job title, position..." type="text" name="keyword">
        </div>

        <div class="card">
            <div class="label">WHERE?</div>
            <?php
            $country_table = new country_table();
            $country_data  = $country_table->retrieve_all_country();
            ?>
            <select class="form-control input-sm" name="country_id">
                <option value="0">All locations</option>
                <?php
                foreach ($country_data as $single_country){
                    ?>
                    <option value="<?php echo $single_country['ID']?>"><?php echo $single_country['NAME_EN']?></option>
                <?php
                }
                ?>
            </select>
        </div>

        <div class="card">
            <div class="label">CATEGORIES?</div>
            <?php
            $job_cat_table = new job_cat_table();
            $job_cat_data  = $job_cat_table->retrieve_all_job_cat();
            ?>
            <select class="form-control input-sm" name="job_cat">
                <option value="0">All Categories</option>
                <?php
                foreach ($job_cat_data as $single_cat){
                    ?>
                    <option value="<?php echo $single_cat['id']?>"><?php echo $single_cat['category_name']?></option>
                <?php
                }
                ?>

            </select>
        </div>

        <div class="btn-wrap-go" style="margin-top: 1.7%;">
            <button type="submit">Go!</button>

        </div>
    </div>
</form>

</body>

</html>