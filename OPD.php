<?php
if(isset($_GET['typ']) && isset($_GET['did']))
{
    include('config.php');
    $db = new DbCon();
    $connection = $db->getCon();
    $opd = new OPD();
    $modal = $opd->createModal($connection,$_GET['typ'],$_GET['did']);
    echo $modal;
}
class OPD 
{
    // Properties
    public $patient;
    public $doctor;
    public $schedule;
    public function __constructor()
    {
        date_default_timezone_set('Europe/London');
    }
    function checkStart($con,$uid)
    {
        date_default_timezone_set('Europe/London');
        $d1 = ['M','T','W','T','F','S','S'];
        $fire = mysqli_query($con,"SELECT `id`, `hospital_id`, `week_days`, `from_1`, `to_1`, `time_per_patient` FROM `doctors_schedule` WHERE `doctor_id`=$uid");
        if($row = mysqli_fetch_array($fire))
        {
            $day = date('L');
            $dday = explode("-",$row['week_days']);
            if($dday[$day]!='@')
            {
                $ti = date('H:i:s');
                if($ti>$row['from_1'].":00" && $ti<$row['to_1'].":00")
                {
                    $dtf = date('Y-m-d H:i:s');
                    
                    $fire1 = mysqli_query($con,"SELECT count(`id`) as cnt FROM `appointments_details` WHERE `doctor_id`=1 AND (`schedule`>$dtf AND `schedule`<$dtf) AND `attainded_at` is NULL AND `status`='SCHEDULED'");
                    error_log($fire1,0);
                    $row1 = mysqli_fetch_array($fire1);
                    if($row1['cnt']>0)
                    {
                        return 1;
                    }
                }
            }
            return 0;
        }
    }
    function getTodaySchedule($con,$uid)
    {
        date_default_timezone_set('Europe/London');
        $dt = date("Y-m-d");
        $tr = "";
        $i = 1;
        $d1 = ['M','T','W','T','F','S','S'];
        $fire = mysqli_query($con,"SELECT `appointments_details`.`id`, `appointments_details`.`patient_id`, `appointments_details`.`schedule`, `appointments_details`.`attainded_at`, `appointments_details`.`status`, `appointments_details`.`booked_at`,`appointments_details`.`sharedPresc`, `user_details`.`user_name` FROM `appointments_details` inner join `user_details` on `appointments_details`.`patient_id` = `user_details`.`user_id` WHERE `appointments_details`.`doctor_id`=$uid AND `appointments_details`.`schedule` between '$dt 00:00:00' AND '$dt 23:59:59' order by `appointments_details`.`schedule` asc");
        while($row = mysqli_fetch_array($fire))
        {
            $shr = "";
            $apid = $row['id'];
            if($row['sharedPresc']==1)
            {
                $shr = "<button type='button' onclick='callModal(\"shared\",\"$apid\")' class='btn btn-success'>View</button>";
            }else
            {
                $shr = "Not Shared";
            }
            $action ="";
            switch($row['status'])
            {
                case 'SCHEDULED':
                    $action = "<button type='button' onclick='callModal(\"schedule\",\"$apid\")' class='btn btn-warning'>Attend</button>";
                    break;
                case 'CANCELED':
                    $action = "Cancled";
                    break;
                case 'ATTENDED':
                    $action = "<button type='button' onclick='callModal(\"attended\",\"$apid\")' class='btn btn-success'>Attended</button>";
                    break;
            }
            $tr .= "<tr>
                    <td>$i</td>
                    <td>".$row['user_name']."</td>
                    <td>".$row['schedule']."</td>
                    <td><button type='button' onclick='callModal(\"history\",\"$apid\")' class='btn btn-info'>View</button></td>
                    <td>$shr</td>
                    <td>".$row['status']."</td>
                    <td>$action</td>
                    </tr>";
            $i++;
        }
        return $tr;
    }
    function createModal($con,$typ,$aid)
    {
        $mdl = "";
        switch($typ)
        {
            case 'shared':
                $mdl .= "<div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    <h4 class='modal-title' style='text-align-last: center'>Register</h4>
                                </div>
                                <div class='modal-body'>
                                <table class='table table-responsive'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                        <th>Complaint</th>
                                        <th>Advice</th>
                                        <th>Prescription</th>
                                    </tr>
                                </thead>
                                <tbody>";
                                $i = 1;
                $sqlHis = mysqli_query($con,"SELECT `appointments_details`.`id`, `appointments_details`.`attainded_at`, `patient_prescrition`.`complaints`, `patient_prescrition`.`advise`, `patient_prescrition`.`prescription`, `patient_prescrition`.`followup`,`appointments_details`.`status`,`user_details`.`user_name` FROM `appointments_details` inner join `patient_prescrition` on `patient_prescrition`.`appointment_id` = `appointments_details`.`id` inner join `user_details` on `user_details`.`user_id`=`appointments_details`.`doctor_id` WHERE `appointments_details`.`patient_id`=(SELECT `appointments_details`.`patient_id` FROM `appointments_details` WHERE `appointments_details`.`id`=$aid) AND `appointments_details`.`status`='ATTENDED' order by `appointments_details`.`schedule` asc");
                while($rowHis = mysqli_fetch_array($sqlHis))
                {
                    $mdl .= "<tr>
                            <td>$i</td>
                            <td>".$rowHis['user_name']."</td>
                            <td>".$rowHis['attainded_at']."</td>
                            <td>".$rowHis['complaints']."</td>
                            <td>".$rowHis['advise']."</td>
                            <td>".$rowHis['prescription']."</td>
                            </tr>
                            ";
                    $i++;
                }
                $mdl .= "</tbody>
                            </table>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                </div>
                            </div>
                        </div>";
                break;
            case 'schedule':
                 $mdl .= "<div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                <h4 class='modal-title' style='text-align-last: center'>Attend</h4>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                </div>
                                <form action='#' method='POST'>
                                <div class='modal-body'>
                                <div class='form-group' style='margin-bottom: 5px;'>
                                    <label for='complaints-text' class='col-form-label'>Complaints:</label>
                                    <textarea class='form-control' id='complaints-text' name='complaints' required></textarea>
                                  </div>
                                  <div class='form-group' style='margin-bottom: 5px;'>
                                    <label for='advice-name' class='col-form-label'>Advice:</label>
                                    <input type='text' class='form-control' id='advice-name' name='advice' required>
                                  </div>
                                  <div class='form-group' style='margin-bottom: 5px;'>
                                    <label for='prescription-text' class='col-form-label'>Prescrition:</label>
                                    <textarea class='form-control' id='prescription-text' name='prescription' required></textarea>
                                  </div>
                                  <div class='form-group' style='margin-bottom: 5px;'>
                                    <label for='followup' class='col-form-label'>Next Follow Up:</label>
                                    <input type='date' class='form-control' id='followup' name='followup' required>
                                  </div>
                                </div>
                                <div class='modal-footer'>
                                    <input type='hidden' name='aid' value='$aid'>
                                    <input type='hidden' name='typ' value='scheduled'>
                                    <button type='submit' class='btn btn-primary'>Save</button>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                </div>
                                </form>
                            </div>
                        </div>";
                break;
            case 'attended':
                $sqlAtn = mysqli_query($con,"SELECT `complaints`, `advise`, `prescription`, `followup`, `timestmp` FROM `patient_prescrition` WHERE  `appointment_id`=$aid");
                $rowAtn = mysqli_fetch_array($sqlAtn);
                 $mdl .= "<div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                <h4 class='modal-title' style='text-align-last: center'>Attend</h4>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                </div>
                                <form action='#' method='POST'>
                                <div class='modal-body'>
                                <div class='form-group' style='margin-bottom: 5px;'>
                                    <label for='complaints-text' class='col-form-label'>Complaints:</label>
                                    <textarea class='form-control enbFld' id='complaints-text' name='complaints' disabled required >".$rowAtn['complaints']."</textarea>
                                  </div>
                                  <div class='form-group' style='margin-bottom: 5px;'>
                                    <label for='advice-name' class='col-form-label'>Advice:</label>
                                    <input type='text' class='form-control enbFld' id='advice-name' name='advice' disabled required value='".$rowAtn['advise']."'>
                                  </div>
                                  <div class='form-group' style='margin-bottom: 5px;'>
                                    <label for='prescription-text' class='col-form-label'>Prescrition:</label>
                                    <textarea class='form-control enbFld' id='prescription-text' name='prescription' disabled required >".$rowAtn['prescription']."</textarea>
                                  </div>
                                  <div class='form-group' style='margin-bottom: 5px;'>
                                    <label for='followup' class='col-form-label'>Next Follow Up:</label>
                                    <input type='date' class='form-control enbFld' id='followup' name='followup' disabled required value='".$rowAtn['followup']."'>
                                  </div>
                                </div>
                                <div class='modal-footer'>
                                    <input type='hidden' name='aid' value='$aid'>
                                    <button type='button' class='btn btn-primary' onclick='enableFields()'>Edit</button>
                                    <button type='submit' class='btn btn-warning'>Update</button>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                </div>
                                </form>
                            </div>
                        </div>";
                break;
            case 'history':
                $mdl .= "<div class='modal-dialog modal-lg'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h4 class='modal-title' style='text-align-last: center'>History</h4>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                </div>
                                <div class='modal-body'>
                                <table class='table table-responsive'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Complaint</th>
                                        <th>Advice</th>
                                        <th>Prescription</th>
                                        <th>Next Follow up</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>";
                                $i = 1;
                $sqlHis = mysqli_query($con,"SELECT `appointments_details`.`id`, `appointments_details`.`attainded_at`, `patient_prescrition`.`complaints`, `patient_prescrition`.`advise`, `patient_prescrition`.`prescription`, `patient_prescrition`.`followup`,`appointments_details`.`status` FROM `appointments_details` inner join `patient_prescrition` on `patient_prescrition`.`appointment_id` = `appointments_details`.`id` WHERE `appointments_details`.`patient_id`=(SELECT `appointments_details`.`patient_id` FROM `appointments_details` WHERE `appointments_details`.`id`=$aid) AND `appointments_details`.`doctor_id`=(SELECT `appointments_details`.`doctor_id` FROM `appointments_details` WHERE `appointments_details`.`id`=$aid) AND `appointments_details`.`status` NOT LIKE 'SCHEDULED' order by `appointments_details`.`schedule` asc");
                while($rowHis = mysqli_fetch_array($sqlHis))
                {
                    $mdl .= "<tr>
                            <td>$i</td>
                            <td>".$rowHis['attainded_at']."</td>
                            <td>".$rowHis['status']."</td>
                            <td>".$rowHis['complaints']."</td>
                            <td>".$rowHis['advise']."</td>
                            <td>".$rowHis['prescription']."</td>
                            <td>".$rowHis['followup']."</td>
                            </tr>
                            ";
                    $i++;
                }
                $mdl .= "</tbody>
                            </table>
                            </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                </div>
                            </div>
                        </div>";
                break;
        }
        return $mdl;
    }
}
  ?>