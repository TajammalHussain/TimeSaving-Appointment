<?php
if(isset($_GET['getDoc']))
{
    include('config.php');
    $db = new DbCon();
    $connection = $db->getCon();
    $book = new BookAppointment();
    $appo = $book->getCatDoctors($connection,$_GET['getDoc']);
    echo $appo;
}
if(isset($_GET['getDays']))
{
    include('config.php');
    $db = new DbCon();
    $connection = $db->getCon();
    $book = new BookAppointment();
    $appo = $book->getDays($connection,$_GET['getDays']);
    echo $appo;
}
if(isset($_GET['getSch']))
{
    include('config.php');
    $db = new DbCon();
    $connection = $db->getCon();
    $book = new BookAppointment();
    $appo = $book->getSchedule($connection,$_GET['getSch']);
    echo $appo;
}
if(isset($_GET['bookNow']))
{
    include('config.php');
    $db = new DbCon();
    $connection = $db->getCon();
    $book = new BookAppointment();
    $appo = $book->bookNow($connection,$_GET['bookNow']);
    echo $appo;
}
if(isset($_GET['reSch']))
{
    include('config.php');
    $db = new DbCon();
    $connection = $db->getCon();
    $book = new BookAppointment();
    $appo = $book->reSch($connection,$_GET['reSch']);
    echo $appo;
}


class BookAppointment {
  // Properties
  public $patient;
  public $doctor;
  public $schedule;
  
  public function __constructor()
  {
      date_default_timezone_set('Europe/London');
  }
  
  function getCategory($con) {
      $str = "<option value=''>Select Category</option>";
      $fire=mysqli_query($con,"SELECT `id`, `speciality` FROM `speciality`");
      while($row=mysqli_fetch_array($fire))
      {
          $str .= "<option value='".$row['id']."'>".$row['speciality']."</option>";
      }
      return $str;
  }
  function getScheduled($con,$uid)
  {
      $date = date('Y-m-d');
      $fire=mysqli_query($con,"SELECT count(`id`) as id1 FROM `appointments_details` WHERE `patient_id`=$uid AND `schedule`>'".$date."'");
      $row = mysqli_fetch_array($fire);
      return $row['id1'];
  }
  function getTotalScheduled($con,$uid)
  {
      $date = date('Y-m-d');
      $fire=mysqli_query($con,"SELECT count(`id`) as id1 FROM `appointments_details` WHERE `patient_id`=$uid");
      $row = mysqli_fetch_array($fire);
      return $row['id1'];
  }
  function getScheduledD($con,$uid)
  {
      $date = date('Y-m-d');
      $fire=mysqli_query($con,"SELECT count(`id`) as id1 FROM `appointments_details` WHERE `doctor_id`=$uid AND `schedule`>'".$date."'");
      $row = mysqli_fetch_array($fire);
      return $row['id1'];
  }
  function getTotalScheduledD($con,$uid)
  {
      $date = date('Y-m-d');
      $fire=mysqli_query($con,"SELECT count(`id`) as id1 FROM `appointments_details` WHERE `doctor_id`=$uid");
      $row = mysqli_fetch_array($fire);
      return $row['id1'];
  }
  function getCatDoctors($con,$did) {
      $str = "<option value=''>Select Doctor</option>";
      $fire=mysqli_query($con,"SELECT `user_details`.`user_id`, `user_details`.`user_name`,`doctors_speciality`.`degree` FROM `user_details` inner join `doctors_speciality` ON `doctors_speciality`.`user_id`=`user_details`.`user_id` WHERE `doctors_speciality`.`speciality_id`=$did");
      
      while($row=mysqli_fetch_array($fire))
      {
          $str .= "<option value='".$row['user_id']."'>Dr. ".$row['user_name']."-[ ".$row['degree']." ]</option>";
          $str++;
      }
      return $str;
  }
  function getSchedule($con,$did)
  {
      $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
      $d1 = ['M','T','W','T','F','S','S'];
      $str = "<option value=''>Select Time Slot</option>";
      $schedule = explode("-",$did);
      $fire=mysqli_query($con,"SELECT `id`, `doctor_id`, `hospital_id`, `week_days`, `from_1`, `to_1`, `time_per_patient` FROM `doctors_schedule` WHERE `doctor_id`=".$schedule[2]);
      if($row=mysqli_fetch_array($fire))
      {
          $br = explode("-",$row['week_days']);
          if($schedule[0]==$br[$schedule[1]])
          {
              $start = strtotime($row['from_1']);
              $end = strtotime($row['to_1']);
              global $tts;
              $tts = array();
              $j=0;
                while ($start < $end)
                {
                  $tts[$j] = date("H:i", $start);
                  $start += 10 * 60;
                  $j++;
                }
                $date = date('Y-m-d');
                $date = strtotime($date);
                $i=0;
                while($i<7)
                {
                    $dt[$i] = date('Y-m-d', strtotime("+".$i." day", $date));
                    if(date('l', strtotime($dt[$i]))==$days[$schedule[1]])
                    {
                        $tt = array();
                        $l=0;
                        $k=0;
                        $fire1 = mysqli_query($con,"SELECT `schedule` FROM `appointments_details` WHERE doctor_id=".$schedule[2]." AND `schedule`>'".$dt[$i]." 00:00:00' AND `schedule`<'".$dt[$i]." 23:59:59' order by schedule asc");
                        while($row1 = mysqli_fetch_array($fire1))
                        {
                            $tt1 = $dt[$i]." ".$tts[$k].":00";
                            while($row1['schedule'] >= $tt1 && $tts[$k]!=NULL)
                            {
                                if($row1['schedule'] != $tt1)
                                {
                                    $tt[$l] = $tt1;
                                    $str .= "<option value='".strtotime($tt[$l])."-".$schedule[2]."'>".date('l dS F Y H:i:s', strtotime($tt[$l]))."</option>";
                                    $l++;
                                }
                                else
                                {
                                    $k++;
                                    break;
                                }
                                $k++;
                                $tt1 = $dt[$i]." ".$tts[$k].":00";
                                
                            }
                        }
                        while($tts[$k]!=NULL)
                        {
                            $tt[$l] = $dt[$i]." ".$tts[$k].":00";
                            $str .= "<option value='".strtotime($tt[$l])."-".$schedule[2]."'>".date('l jS F Y H:i:s', strtotime($tt[$l]))."</option>";
                            $l++;
                            $k++;
                        }
                        break;
                    }
                    $i++;
                }
          }
      }
      return $str;
  }
  function getDays($con,$did)
  {
      $str = "<option value=''>Select Week Days</option>";
      $fire=mysqli_query($con,"SELECT `id`, `doctor_id`, `hospital_id`, `week_days`, `from_1`, `to_1`, `time_per_patient` FROM `doctors_schedule` WHERE `doctor_id`=".$did);
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
          return $str;
      }
  }
  function bookNow($con,$did)
  {
      $gtdt = explode("-",$did);
      $fire = mysqli_query($con,"INSERT INTO `appointments_details`(`patient_id`, `doctor_id`, `schedule`,`live_track`) VALUES (".$gtdt[2].",".$gtdt[1].",'".date('Y-m-d H:i:s',$gtdt[0])."','".date('Y-m-d H:i:s',$gtdt[0])."')");
      return "Done";
      
  }
  function reSch($con,$did)
  {
      $gtdt = explode("###",$did);
      $fire2 = mysqli_query($con,"SELECT schedule,doctor_id FROM `appointments_details` WHERE `id`=".$gtdt[0]);
      $row2 = mysqli_fetch_array($fire2);
      $fire1 = mysqli_query($con,"SELECT patient_id,schedule FROM `appointments_details` WHERE `schedule` BETWEEN '".date('Y-m-d',strtotime($row2['schedule']))." 00:00:01' AND '".date('Y-m-d',strtotime($row2['schedule']))." 23:59:59' AND `doctor_id`=".$row2['doctor_id']." AND status='SCHEDULED'");
      $uids= array();
      $insrt = array();
      if($row1 = mysqli_fetch_array($fire1))
      {
          $uids[0] = "New schedule is available @ ".$row2['schedule'];
          $uids[1] = $row1['patient_id'];
           $insrt[] = "(".$uids[1].",".$row2['doctor_id'].",'".$uids[0]."')";
      }
      $i=2;
      while($row1 = mysqli_fetch_array($fire1))
      {
          $uids[$i] = $row1['patient_id'];
          $insrt[] = "(".$uids[$i].",".$row2['doctor_id'].",'".$uids[0]."')";
          $i++;
      }
      $inst = "INSERT INTO `notification`(`uid`, `doctor_id`, `msg`) VALUES ".implode(",",$insrt);
      $sql7 = mysqli_query($con,$inst);
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
      
      $fire = mysqli_query($con,"UPDATE `appointments_details` SET `schedule`='".date('Y-m-d H:i:s',$gtdt[1])."' WHERE `id`=".$gtdt[0]);
      return "Done";
    }
}
?>