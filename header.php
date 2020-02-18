<?php
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Job-Portal</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/linearicons/style.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="assets/css/main.css">

    <link rel="stylesheet" href="assets/css/custom/job-details.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/linearicons/style.css">
    <link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
    <link rel="stylesheet" href="assets/css/custom/dashboard.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <link rel="stylesheet" href="assets/css/demo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/custom/back_style.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/custom/navbar.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/custom/flex-box-landing-page.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/custom/emp-job.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/custom/candidate-login.css" />
    <script src="main.js"></script>
</head>


<body>

<link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>

<div class="overlay">
    <a class="wt navbar-brand" href="index.php">Job Portal </a>
    <div id="navbar">

        <a href="jobs.php">Browse Jobs</a>
        <a href="events.php">Events</a>


        <?php
        if (!is_user_login() && !is_company_login_company()){

        ?>
            <a href="login.php">Login</a>
            <a href="register.php">Join Now</a>
            <a href="company_registration.php">Employer?</a>
<?php }else{
            if(is_user_login()){
            ?>

        <a href="dashboard.php">Dashboard</a>
                <?php }elseif(is_company_login_company()){?>
                <a href="companies/dashboard.php">Dashboard</a>
        <?php }}?>



    </div>
