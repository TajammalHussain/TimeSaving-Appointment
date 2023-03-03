<?php
include "config.php";
$db = new DbCon();
$connection = $db->getCon();

if(!isset($_SESSION)) 
    {
        session_start();
    }
if(isset($_GET['set']))
{
    unset($_SESSION['load']);
}
if(isset($_SESSION['load']))
{
    header("location: index.php");
}
else
{
if(isset($_POST['loginsub']))
{
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $sql = "SELECT `id`, `user_id`, `user_type` FROM `login` WHERE `username`='$user' AND `password`='$pass'";
    $fire = mysqli_query($connection,$sql);
    if($row = mysqli_fetch_array($fire))
    {
        $_SESSION['uid'] = $row['user_id'];
        $_SESSION['utype'] = $row['user_type'];
        $_SESSION['load'] = 1;
        if($row['user_type']==1)
        {
            header("location: index.php");
        }else if($row['user_type']==0)
        {
            header("location: userIndex.php");
        }
    }
    else
    {
      $msg="Wrong Credentials!!! UserId and/or Password entered by you is incorrect.";
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>My Appointments</title>
    <link href="dist/css/pages/login-register-lock.css" rel="stylesheet">
    <link href="dist/css/style.min.css" rel="stylesheet">
</head>

<body class="skin-default card-no-border">
    <?php
        include('loader.php');
    ?>
    <section id="wrapper">
        <div class="login-register" style="background-image:url(../assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-body">
                    <form class="form-horizontal form-material" id="loginform" action="#" method="POST">
                        <h3 class="text-center m-b-20">Sign In to My Appointments</h3>
                         <?php if(@$msg){ ?>
                                    <div class="alert alert-danger" role="alert">
                                        <span class="sr-only"></span>
                                          <?=$msg?>
                                    </div>
                         <?php 	} ?>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="Username" name="user"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" placeholder="Password" name="pass"> </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div class="custom-control custom-checkbox">
                                        <!--<input type="checkbox" class="custom-control-input" id="customCheck1">-->
                                        <!--<label class="custom-control-label" for="customCheck1">Remember me</label>-->
                                    </div> 
                                    <div class="ml-auto">
                                        <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fas fa-lock m-r-5"></i> Forgot password?</a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <button class="btn btn-block btn-lg btn-info btn-rounded" type="submit" name="loginsub">Log In</button>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal" id="recoverform" action="index.html">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Recover Password</h3>
                                <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="Email"> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <script src="../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/node_modules/popper/popper.min.js"></script>
    <script src="../assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!--Custom JavaScript -->
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
    
</body>

</html>