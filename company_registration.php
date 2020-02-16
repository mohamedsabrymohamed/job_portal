<?php
require_once 'inc.php';
?>
<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="assets/css/custom/login.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/linearicons/style.css">
    <!-- MAIN CSS -->

    <link rel="stylesheet" href="assets/css/main.css">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="assets/css/demo.css">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
</head>

<body>
<!-- WRAPPER -->
<div id="wrapper">
    <div class="vertical-align-wrap">
        <div class="vertical-align-middle">
            <div class="auth-box ">
                <div class="left">
                    <div class="content">
                        <div class="header">

                            <p class="lead">Register Company</p>
                        </div>
                        <?php
                        if(isset($_SESSION['company_reg_error'])  && $_GET['company_reg_error'] == 'Y'){
                            ?>
                            <p class="alert-danger"> <?php echo $_SESSION['company_reg_error'];?></p>
                        <?php
                        }
                        ?>

                        <form class="form-auth-small" action="process.php" method="post">
                            <input type="hidden" name="form_name" value="company_register">
                            <div class="form-group">
                                <label for="signup-company_name" class="control-label sr-only">Company Name</label>
                                <input type="text" class="form-control" id="signup-company_name" placeholder="Enter Company Name...." name="company_name" required>
                            </div>
                            <div class="form-group">
                                <label for="signup-email" class="control-label sr-only">Email</label>
                                <input type="email" class="form-control" id="signup-email" placeholder="Enter Email...." name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label sr-only">Password</label>
                                <input type="password" class="form-control" id="password"  placeholder="Enter Password...." name="password" required>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password" class="control-label sr-only">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password"  placeholder="Enter Password Again...." name="confirm_password" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block">Register Now</button>
                            <div class="bottom">
                                <span><a href="login.php">Already have A account? Login Now!</a></span><br>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="right">
                    <div class="overlay"></div>
                    <div class="content text">
                        <h1 class="heading">Sign up for free to get best employees! </h1>
                        <p>by Job Portal</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var password = document.getElementById("password")
        , confirm_password = document.getElementById("confirm_password");

    function validatePassword(){
        if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>
<!-- END WRAPPER -->
</body>

</html>
