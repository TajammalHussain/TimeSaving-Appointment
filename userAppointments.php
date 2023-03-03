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
$page_title="My Appointments";
$db = new DbCon();
$connection = $db->getCon();

date_default_timezone_set('Europe/London');

if(isset($_POST['cacleApnt']))
{
    $fire2 = mysqli_query($connection,"SELECT schedule,doctor_id FROM `appointments_details` WHERE `id`=".$_POST['cacleApnt']);
      $row2 = mysqli_fetch_array($fire2);
      $fire1 = mysqli_query($connection,"SELECT patient_id,schedule FROM `appointments_details` WHERE `schedule` BETWEEN '".date('Y-m-d',strtotime($row2['schedule']))." 00:00:01' AND '".date('Y-m-d',strtotime($row2['schedule']))." 23:59:59' AND `doctor_id`=".$row2['doctor_id']." AND status='SCHEDULED'");
      $uids= array();
      $insrt = array();
      if($row3 = mysqli_fetch_array($fire1))
      {
          $uids[0] = "New schedule is available @ ".$row2['schedule'];
          $uids[1] = $row3['patient_id'];
          $insrt[] = "(".$uids[1].",".$row2['doctor_id'].",'".$uids[0]."')";
      }
      $i=2;
      while($row3 = mysqli_fetch_array($fire1))
      {
          $uids[$i] = $row3['patient_id'];
          $insrt[] = "(".$uids[$i].",".$row2['doctor_id'].",'".$uids[0]."')";
          $i++;
      }
      $inst = "INSERT INTO `notification`(`uid`, `doctor_id`, `msg`) VALUES ".implode(",",$insrt);
      $sql7 = mysqli_query($connection,$inst);
      require __DIR__ . '/vendor/autoload.php';
        $options = array(
        'cluster' => 'ap2',
        'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
        'b20bc17a9833899f99aa',
        'dc9a9fc1880c955d65b3',
        '1180768',
        $options
        );
      $data['message'] = implode("@#@",$uids);
      $pusher->trigger('my-channel', 'my-event', $data);
    
    $sql1 = mysqli_query($connection,"SELECT `appointments_details`.`doctor_id`, `appointments_details`.`live_track`, `doctors_schedule`.`time_per_patient` FROM `appointments_details` inner join `doctors_schedule` on `doctors_schedule`.`doctor_id` = `appointments_details`.`doctor_id` WHERE `appointments_details`.`id`=".$_POST['cacleApnt']);
    $row1 = mysqli_fetch_array($sql1);
    $sql2 = mysqli_query($connection,"UPDATE `appointments_details` SET `schedule`=DATE_SUB(`schedule`,interval ".$row1['time_per_patient']." minute) WHERE `doctor_id`= ".$row1['doctor_id']." AND `schedule` > '".$row1['schedule']."' AND `schedule` between '".$row1['schedule']."' AND '".date("Y-m-d",strtotime($row1['schedule']))." 23:59:59'");
    $sql3 = mysqli_query($connection,"UPDATE `appointments_details` SET `status`='CANCELED' WHERE `id`=".$_POST['cacleApnt']);
    echo "<script>alert('Appointment is canceled successfully!!!')</script>";
    
}
if(isset($_POST['sharePre']))
{
    $sql = mysqli_query($connection,"UPDATE `appointments_details` SET `sharedPresc`=1 WHERE `id`=".$_POST['sharePre']);
    echo "<script>alert('Prescription has been shared successfully!!!')</script>";
}

include "BookedAppointment.php";
$bApp = new BookedAppointment();
$appList = $bApp->getMyAppointments($connection,$_SESSION['uid']);
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
                                              <th>Speciality</th>
                                              <th>Schedule</th>
                                              <th>CAP</th>
                                              <th>Prescription Shared</th>
                                              <th>Status</th>
                                              <th>Live Track</th>
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
        <script>
        function myFunc(typ,id,appnt)
            {
                var tid = typ+id+appnt;
                var curval = document.getElementById('currentModal').value;
                if(curval==tid)
                {
                    $("#communModal").modal();
                }else
                {
                    $.ajax({
                      method: 'GET',
                      url: 'BookedAppointment.php',
                      data: {'typ':typ,'pid':id,'appnt':appnt}, 
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
            function getSch(sel)
        {
            $.ajax({
              method: 'GET',
              url: 'BookAppointment.php',
              data: {'getSch' : sel.value}, 
              success: function(response){ 
                  document.getElementById('timeSlot').innerHTML = response;
              },
               error: function(jqXHR, textStatus, errorThrown) { 
                   alert("error-"+jqXHR);
               }
            });
        }
        function bookNow(did)
        {
            var gt = document.getElementById('timeSlot').value;
            $.ajax({
              method: 'GET',
              url: 'BookAppointment.php',
              data: {'reSch' :did+"###"+gt}, 
              success: function(response){ 
                  if(response=="Done")
                  {
                      alert("Appointment Rescheduled successfully.");
                      location.reload();
                  }
                  
              },
               error: function(jqXHR, textStatus, errorThrown) { 
                   alert("error-"+jqXHR);
               }
            });
        }
        </script>
    </body>

</html>