<?php
if(isset($_GET['typ']) && isset($_GET['pid']) && isset($_GET['appnt']))
{
    include('config.php');
    $db = new DbCon();
    $connection = $db->getCon();
    $booked = new BookedAppointment();
    $appo = $booked->getModal($connection,$_GET['typ'],$_GET['pid'],$_GET['appnt']);
    echo $appo;
}
class BookedAppointment
{
    public function __constructor()
    {
        date_default_timezone_set('Europe/London');
    }
    function getMyNotification($con,$pid)
    {
        $sql = mysqli_query($con,"SELECT  `notification`.`msg`, `user_details`.`user_name` FROM `notification` inner join `user_details` on `user_details`.`user_id`=`notification`.`doctor_id` WHERE `notification`.`uid`=$pid");
        $dt="";
        $i=1;
        while($row = mysqli_fetch_array($sql))
        {
            $dt .= "<tr>
            <td>$i</td><td>".$row['user_name']."</td><td>".$row['msg']."</td></tr>";
            $i++;
        }
        return $dt;
    }
    function getMyAppointments($con,$pid)
    {
        $tr="";
        $i=1;
        $sql= mysqli_query($con,"SELECT `appointments_details`.`id`,`appointments_details`.`doctor_id`,`appointments_details`.`live_track`, `appointments_details`.`schedule`, `appointments_details`.`attainded_at`, `appointments_details`.`status`, `appointments_details`.`booked_at`, `appointments_details`.`sharedPresc`, `user_details`.`user_name`, `doctors_speciality`.`degree`, `speciality`.`speciality`, `patient_prescrition`.`complaints`, `patient_prescrition`.`advise`, `patient_prescrition`.`prescription` FROM `appointments_details` inner join `user_details` ON `appointments_details`.`doctor_id` = `user_details`.`user_id` inner join `doctors_speciality` on `doctors_speciality`.`user_id` = `appointments_details`.`doctor_id` INNER JOIN `speciality` ON `speciality`.`id`= `doctors_speciality`.`speciality_id` LEFT join `patient_prescrition` ON `patient_prescrition`.`appointment_id` = `appointments_details`.`id` WHERE `appointments_details`.`patient_id`=$pid order by `appointments_details`.`schedule` DESC");
        while($row = mysqli_fetch_array($sql))
        {
            $shared = "";
            if($row['sharedPresc']==1)
            {
                $shared = "Shared"; 
            }else
            {
                if(strtotime($row['schedule']) > strtotime(date("Y-m-d")." 00:00:00"))
                {
                   $shared = "Not Shared"; 
                   if(date("Y-m-d",strtotime($row['schedule'])) == date("Y-m-d") && $row['status']!='CANCELED')
                   {
                       $shared .= "<button type='button' class='btn btn-info' id='share-".$row['id']."' onclick='myFunc(\"share\",\"$pid\",\"".$row['id']."\")'>Share Now</button>";
                   }
                }else
                {
                    $shared = "Not Shared"; 
                }
            }
            $status = "";
            $status1 = "";
            $pres = "NA";
            $live = "NA";
            if($row['status'] != 'SCHEDULED')
            {
                $status = $row['status']; 
                if($row['status'] == 'ATTENDED')
                {
                    $pres = "<button type='button' class='btn btn-info' id='pres-".$row['id']."' onclick='myFunc(\"pres\",\"$pid\",\"".$row['id']."\")'>View CAP</button>";
                }
            }else
            {
                if(strtotime($row['schedule']) > strtotime(date("Y-m-d")." 00:00:00"))
                {
                   $status = "SCHEDULED <button type='button' class='btn btn-danger' id='cancel-".$row['id']."' onclick='myFunc(\"cancel\",\"$pid\",\"".$row['id']."\")'>Cancel Now</button>";
                   $status1 = "<button type='button' class='btn btn-warning' id='reschedule-".$row['id']."' onclick='myFunc(\"reschedule\",\"$pid\",\"".$row['id']."\")'>Reschedule</button>";
                   $sql9= mysqli_query($con,"SELECT `live_track` FROM `appointments_details` WHERE doctor_id=".$row['doctor_id']." AND `schedule` BETWEEN ".date("Y-m-d")." 00:00:01 AND ".date("Y-m-d")." 23:59:59 AND status='ATTENDED' ORDER BY `attainded_at` DESC");
                   if($row9 = mysqli_fetch_array($sql9))
                   {
                       if($row9['live_track']!=NULL)
                       {
                        $live = $row9['live_track'];
                       }
                   }
                //   $live = date('d-m-Y H:i:s',strtotime($row['schedule']));
                //   if(date("Y-m-d",strtotime($row['schedule'])) == date("Y-m-d"))
                //   {
                //       $pres = "NA";
                //   }
                }else
                {
                    $status = "UNATTENDED";
                }
            }
        $tr .= "<tr>
                  <td>$i</td>
                  <td>".$row['user_name']." [ ".$row['degree']." ]</td>
                  <td>".$row['speciality']."</td>
                  <td>".date('d-m-Y H:i:s',strtotime($row['schedule']))."</td>
                  <td>$pres</td>
                  <td>$shared</td>
                  <td>$status.$status1</td>
                  <td>$live</td>
                </tr>";
        $i++;
        }
            return $tr;
    }
    function getModal($con,$typ,$pid,$apid)
    {
        $modal = "";
        switch($typ)
        {
            case 'share':
                $modal = "<div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title'>Share Prescription</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <p>Do you want to share the prescription for this appointment?</p>
                          </div>
                          <div class='modal-footer'>
                          <form action='#' method='POST'>
                            <input type='hidden' name='sharePre' value='$apid'>
                            <button type='submit' class='btn btn-primary'>Share Now</button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                          </form>
                          </div>
                        </div>
                      </div>";
                break;
            case 'pres':
                $sql = mysqli_query($con,"SELECT `id`, `complaints`, `advise`, `prescription`, `followup`, `timestmp` FROM `patient_prescrition` WHERE `appointment_id`=$apid");
                $row = mysqli_fetch_array($sql);
                $modal = "<div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title'>Prescribed by Doctor</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                          <div class='col-sm-12 table-responsive'>
                            <table class='table'>
                                <tead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Complans</th>
                                        <td>".$row['complaints']."</td>
                                    </tr>
                                    <tr>
                                        <th>Advice</th>
                                        <td>".$row['advise']."</td>
                                    </tr>
                                    <tr>
                                        <th>Prescription</th>
                                        <td>".$row['prescription']."</td>
                                    </tr>
                                    <tr>
                                        <th>Follow Up</th>
                                        <td>".date("d-m-Y",strtotime($row['followup']))."</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                          </div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                          </div>
                        </div>
                      </div>";
                break;
            case 'cancel':
                $modal = "<div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title'>Canlcel Appointment</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <p>Do you want to cancel this appointment?</p>
                          </div>
                          <div class='modal-footer'>
                          <form action='#' method='POST'>
                            <input type='hidden' name='cacleApnt' value='$apid'>
                            <button type='submit' class='btn btn-primary'>Cancel Now</button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                          </form>
                          </div>
                        </div>
                      </div>";
                break;
            case 'reschedule':
                $did = $_GET['appnt'];
                $str = "<option value=''>Select Week Days</option>";
                  $fire=mysqli_query($con,"SELECT `doctors_schedule`.`id`, `doctors_schedule`.`doctor_id`, `doctors_schedule`.`hospital_id`, `doctors_schedule`.`week_days`, `doctors_schedule`.`from_1`, `doctors_schedule`.`to_1`, `doctors_schedule`.`time_per_patient` FROM `doctors_schedule` inner join `appointments_details` on `appointments_details`.`doctor_id`=`doctors_schedule`.`id` WHERE `appointments_details`.`id`=$did");
                  if($row=mysqli_fetch_array($fire))
                  {
                      $dy = explode("-",$row['week_days']);
                      $i=0;
                      $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                      $d1 = ['M','T','W','T','F','S','S'];
                      while($i<7)
                      {
                          if($dy[$i]==$d1[$i])
                          {
                              $str .= "<option value='".$d1[$i]."-".$i."-".$row['doctor_id']."'>".$days[$i]."</option>";
                          }else
                          {
                              $str .= "<option value='' disabled>".$days[$i]."</option>";
                          }
                          $i++;
                      }
                  }
                $modal = "<div class='modal-dialog' role='document'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title'>Rechedule Appointment</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                              <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>
                          <div class='modal-body'>
                            <div class='row p-t-20'>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='control-label'>Select Week Day</label>
                                        <select class='form-control custom-select' data-placeholder='Choose a Week Day' tabindex='1' id='weekDay' onchange='getSch(this);'>
                                        $str
                                        </select>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='control-label'>Select Time Slot</label>
                                        <select class='form-control custom-select' data-placeholder='Choose a Time Slot' tabindex='1' id='timeSlot' >
                                        </select>
                                    </div>
                                </div>
                            </div>
                          </div>
                          <div class='modal-footer'>
                          <form action='#' method='POST'>
                            <input type='hidden' name='cacleApnt' value='$apid'>
                            <button type='button' class='btn btn-success' onclick='bookNow(\"$did\")'> <i class='fa fa-check'></i> Update Now</button>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                          </form>
                          </div>
                        </div>
                      </div>";
                break;
        }
        return $modal;
    }
}
?>