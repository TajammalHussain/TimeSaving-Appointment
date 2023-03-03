<?php
if (session_status() == PHP_SESSION_NONE) 
{
    session_start();
}
if((!isset($_SESSION['load']) || !isset($_SESSION['uid'])) && (!isset($_SESSION['utype']) && $_SESSION['utype']==1))
{
    header("location: login.php");
}
$_SESSION['page_id']=10;
include('config.php');
$page_title="Notifications";
$db = new DbCon();
$connection = $db->getCon();

date_default_timezone_set('Europe/London');

include "BookedAppointment.php";
$bApp = new BookedAppointment();
$appList = $bApp->getMyNotification($connection,$_SESSION['uid']);
// $tr = $opd->getTodaySchedule($connection,$_SESSION['uid']);
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
                            <h4 class="text-themecolor">Booked Appointments</h4>
                        </div>
                        <div class="col-md-7 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="table table-responsive">
                                        <table class="table table-bordered">
                                          <thead>
                                            <tr>
                                              <th>#</th>
                                              <th>Doctor</th>
                                              <th>New Schedule</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                              <?php echo $appList;?>
                                          </tbody>
                                        </table>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        <input type='hidden' id='currentModal' value='10'>
        <div id="communModal" class="modal fade" role="dialog">
        </div>
    </body>

</html>