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
$cats = $book->getCategory($connection);
$scheduled = $book->getScheduled($connection,$_SESSION['uid']);
$tscheduled = $book->getTotalScheduled($connection,$_SESSION['uid']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $page_title;?></title>
        <?php include('head.php');?>
    </head>
    <body class="skin-default-dark fixed-layout">
        <input type="hidden" value="<?php echo $_SESSION['uid'];?>" id='uid'>
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
                    
                   <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Book New Appointment</h4>
                            </div>
                            <div class="card-body">
                                <form action="#">
                                    <div class="form-body">
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Category</label>
                                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="docCat" onchange="getDoc(this);">
                                                        <?php
                                                         echo $cats;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Select Doctors</label>
                                                    <select class="form-control custom-select" data-placeholder="Choose a Doctors" tabindex="1" id="docId"  onchange="getDays(this);">
                                                        <option value=''>Select Doctor</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Select Week Day</label>
                                                    <select class="form-control custom-select" data-placeholder="Choose a Week Day" tabindex="1" id="weekDay" onchange="getSch(this);">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Select Time Slot</label>
                                                    <select class="form-control custom-select" data-placeholder="Choose a Time Slot" tabindex="1" id="timeSlot" >
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-actions">
                                        <button type="button" class="btn btn-success" onclick='bookNow();'> <i class="fa fa-check"></i> Save</button>
                                        <button type="button" class="btn btn-inverse">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                    
                    
                    <?php
                        include('right_sidebar.php');
                    ?>
                </div>
            </div>
            
            <?php
                include('footer.php');
            ?>
        </div>
        
        <?php
            include('footerScript.php');
        ?>
        <script>
        function getDoc(sel)
        {
            
            $.ajax({
              method: 'GET',
              url: 'BookAppointment.php',
              data: {'getDoc' : sel.value}, 
              success: function(response){ 
                  document.getElementById('docId').innerHTML = response;
              },
               error: function(jqXHR, textStatus, errorThrown) { 
                   alert("error");
               }
            });
        }
        function getDays(sel)
        {
            $.ajax({
              method: 'GET',
              url: 'BookAppointment.php',
              data: {'getDays' : sel.value}, 
              success: function(response){ 
                  document.getElementById('weekDay').innerHTML = response;
              },
               error: function(jqXHR, textStatus, errorThrown) { 
                   alert("error-"+jqXHR);
               }
            });
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
        function bookNow()
        {
            var uid = document.getElementById('uid').value;
            var gt = document.getElementById('timeSlot').value;
            $.ajax({
              method: 'GET',
              url: 'BookAppointment.php',
              data: {'bookNow' : gt+"-"+uid}, 
              success: function(response){ 
                  if(response=="Done")
                  {
                      alert("Appointment booked successfully.");
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