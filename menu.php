<?php
//$sql="SELECT `ID` FROM `access_control` WHERE `userID`=".$_SESSION['uid']." AND `pageID`=".$_SESSION['page_id'];
?>

<aside class="left-sidebar">
<!-- Sidebar scroll-->
<div class="scroll-sidebar">
    <!-- User Profile-->
    <div class="user-profile">
        <div class="user-pro-body">
            <div><img src="../assets/images/users/2.jpg" alt="user-img" class="img-circle"></div>
            <div class="dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Steave Gection <span class="caret"></span></a>
                <div class="dropdown-menu animated flipInY">
                    <a href="logout.php" class="dropdown-item"><i class="fas fa-power-off"></i> Logout</a>
                    <!-- text-->
                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
        <ul id="sidebarnav">
            <li class="nav-small-cap">--- PERSONAL</li>
            <?php 
                    if($_SESSION['utype']==1)
                    {
                        ?>
                        <li>
                            <a class="waves-effect waves-dark" href="index.php" aria-expanded="false">
                                <i class="icon-speedometer"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="todayOPD.php" aria-expanded="false">
                                <i class="icon-speedometer"></i>
                                <span class="hide-menu">Today's OPD</span>
                            </a>
                        </li>
                        <?php
                    }else if($_SESSION['utype']==0)
                    {
                        ?>
                        <li>
                            <a class="waves-effect waves-dark" href="userIndex.php" aria-expanded="false">
                                <i class="icon-speedometer"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="userAppointments.php" aria-expanded="false">
                                <i class="icon-speedometer"></i>
                                <span class="hide-menu">Booked Appointments</span>
                            </a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="notifications.php" aria-expanded="false">
                                <i class="icon-speedometer"></i>
                                <span class="hide-menu">Notifications</span>
                            </a>
                        </li>
                        
                        <?php
                    }
                    ?>
            
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>
<!-- End Sidebar scroll-->
</aside>