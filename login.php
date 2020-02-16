<?php
require_once 'inc.php';
?>
<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title>Login</title>
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

                            <p class="lead">Login to your account</p>
                        </div>
                        <?php
                        if(isset($_SESSION['u_reg_succ']) && $_GET['u_reg_succ'] == 'Y'){
                            ?>
                            <p class="alert-success"> <?php echo $_SESSION['u_reg_succ'];?></p>
                            <?php
                        }elseif (isset($_SESSION['err_uname_pass']) && $_GET['err_uname_pass'] == 'Y'){
                        ?>
                            <p class="alert-danger"> <?php echo $_SESSION['errup'];?></p>
                            <?php
                        }?>
                        <form class="form-auth-small" action="process.php" method="post">
                            <input type="hidden" name="form_name" value="user_login">
                            <input type="hidden" name="form_type" value="ajax">
                            <div class="form-group">
                                <label for="signin-email" class="control-label sr-only">Email</label>
                                <input type="email" class="form-control" id="signin-email" placeholder="Enter Email...." name="email">
                            </div>
                            <div class="form-group">
                                <label for="signin-password" class="control-label sr-only">Password</label>
                                <input type="password" class="form-control" id="signin-password"  placeholder="Enter Password...." name="password">
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                            <div class="bottom">
                                <span><a href="register.php">Not A member? SignUp Now!</a></span><br>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="right">
                    <div class="overlay"></div>
                    <div class="content text">
                        <h1 class="heading">Signup for free to experience your dream job! </h1>
                        <p>by Job Portal</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<!-- END WRAPPER -->
</body>

</html>
