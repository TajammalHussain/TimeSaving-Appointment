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
$page_title="Today's OPD";
$db = new DbCon();
$connection = $db->getCon();

date_default_timezone_set('Europe/London');

include "OPD.php";
$opd = new OPD();
$checkStart = $opd->checkStart($connection,$_SESSION['uid']);
$tr = $opd->getTodaySchedule($connection,$_SESSION['uid']);

if(isset($_POST['typ']) && isset($_POST['aid']))
{
    $dt = date("Y-m-d H:i:s");
    $aid = $_POST['aid'];
    $advice = $_POST['advice'];
    $complaints = $_POST['complaints'];
    $prescription = $_POST['prescription'];
    $followup = "NULL";
    if(isset($_POST['followup']))
    {
        $followup = "'".$_POST['followup']."'";
    }
    $sqlpresIn = mysqli_query($connection,"INSERT INTO `patient_prescrition`(`appointment_id`, `complaints`, `advise`, `prescription`, `followup`, `timestmp`) VALUES ($aid,'$complaints','$advice','$prescription',$followup,'$dt')");
    error_log("INSERT INTO `patient_prescrition`(`appointment_id`, `complaints`, `advise`, `prescription`, `followup`, `timestmp`) VALUES ($aid,'$complaints','$advice','$prescription',$followup,'$dt')",0);
    $sqlpresUp = mysqli_query($connection,"UPDATE `appointments_details` SET `attainded_at`='$dt',`status`='ATTENDED' WHERE `id`=$aid");
    error_log("UPDATE `appointments_details` SET `attainded_at`='$dt',`status`='ATTENDED' WHERE `id`=$aid",0);
    echo "<script>alert('Patient attended succefuly!!!');</script>";
}else if(isset($_POST['aid']))
{
    $dt = date("Y-m-d H:i:s");
    $aid = $_POST['aid'];
    $advice = $_POST['advice'];
    $complaints = $_POST['complaints'];
    $prescription = $_POST['prescription'];
    $followup = "NULL";
    if(isset($_POST['followup']))
    {
        $followup = "'".$_POST['followup']."'";
    }
    $sqlpres = mysqli_query($connection,"UPDATE `patient_prescrition` SET `complaints`='$complaints',`advise`='$advice',`prescription`='$prescription',`followup`=$followup WHERE `appointment_id`=$aid");
    echo "<script>alert('Updated succefuly!!!');</script>";
}
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
                            <h4 class="text-themecolor">Today's OPD</h4>
                        </div>
                        <div class="col-md-7 align-self-center text-right">
                            <div class="d-flex justify-content-end align-items-center">
                                <?php
                                if($checkStart==1)
                                {
                                ?>
                                <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Start OPD</button>
                                <?php
                                }
                                ?>
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
                                              <th>Name</th>
                                              <th>Schedule</th>
                                              <th>History</th>
                                              <th>Shared Prescription</th>
                                              <th>Status</th>
                                              <th>Action</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                              <?php echo $tr;?>
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
        <script>
        function enableFields()
        {
            var cells = document.getElementsByClassName("enbFld"); 
            for (var i = 0; i < cells.length; i++) { 
                cells[i].disabled = false;
            }
        }
            function callModal(typ,id)
            {
                var tid = typ+id;
                var curval = document.getElementById('currentModal').value;
                if(curval==tid)
                {
                    $("#communModal").modal();
                }else
                {
                    $.ajax({
                      method: 'GET',
                      url: 'OPD.php',
                      data: {'typ':typ,'did':id}, 
                      success: function(response){ 
                          document.getElementById('communModal').innerHTML = response;
                          document.getElementById('currentModal').value = tid;
                          $("#communModal").modal();
                      },
                       error: function(jqXHR, textStatus, errorThrown) { 
                           alert("error");
                       }
                    });
                }
            }
        </script>
    </body>

</html>