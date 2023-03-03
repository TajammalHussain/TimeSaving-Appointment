<?php
if (session_status() == PHP_SESSION_NONE) 
{
    session_start();
}
if((!isset($_SESSION['load']) || !isset($_SESSION['uid'])) && (!isset($_SESSION['utype']) && $_SESSION['utype']==1))
{
    header("location: login.php");
}
$_SESSION['page_id']=1;
include('config.php');
$page_title="Dashboard";
$db = new DbCon();
$connection = $db->getCon();

include "BookAppointment.php";
$book = new BookAppointment();
$scheduled = $book->getScheduledD($connection,$_SESSION['uid']);
$tscheduled = $book->getTotalScheduledD($connection,$_SESSION['uid']);


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $page_title;?></title>
        <?php include('head.php');?>
    </head>
    <body class="skin-default-dark fixed-layout">
        <?php
            include('loader.php');
        ?>
        <div id="main-wrapper">
            <?php
                include('header.php');
                include('menu.php');
            ?>
            <div class="page-wrapper">
                <div class="container-fluid">
                    <div class="row page-titles">
                        <div class="col-md-5 align-self-center">
                            <h4 class="text-themecolor">Dashboard</h4>
                        </div>
                        <div class="col-md-7 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                                <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                    <!-- Column -->
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0"><?php echo $tscheduled;?></h3>
                                        <h5 class="text-muted m-b-0">Total Appointments</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0"><?php echo $scheduled;?></h3>
                                        <h5 class="text-muted m-b-0">Scheduled Appointments</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    
                    <!-- Column -->
                </div>
                    
                    
                </div>
            </div>
            
            <?php
                include('footer.php');
            ?>
        </div>
        
        <?php
            include('footerScript.php');
        ?>
    </body>

</html>