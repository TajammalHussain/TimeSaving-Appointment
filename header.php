<?php
// require __DIR__ . '/vendor/autoload.php';
// $options = array(
// 'cluster' => 'ap2',
// 'useTLS' => true
// );
// $pusher = new Pusher\Pusher(
// 'b20bc17a9833899f99aa',
// 'dc9a9fc1880c955d65b3',
// '1180768',
// $options
// );

// $data['message'] = 'hello world';
// $pusher->trigger('my-channel', 'my-event', $data);
?>

<header class="topbar">
<nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <!-- ============================================================== -->
    <!-- Logo -->
    <!-- ============================================================== -->
    <div class="navbar-header">
        <a class="navbar-brand" href="index.html">
            <!-- Logo icon --><b>
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <img src="../assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                <!-- Light Logo icon -->
                <img src="../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
            </b>
            <!--End Logo icon -->
            <!-- Logo text --><span>
             <!-- dark Logo text -->
             <img src="../assets/images/logo-text.png" alt="homepage" class="dark-logo" />
             <!-- Light Logo text -->    
             <img src="../assets/images/logo-light-text.png" class="light-logo" alt="homepage" /></span> </a>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse">
        <!-- ============================================================== -->
        <!-- toggle and nav items -->
        <!-- ============================================================== -->
        <ul class="navbar-nav mr-auto">
            <!-- This is  -->
            <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
            <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
   
        </ul>
    </div>
</nav>
</header>
<input type="hidden" name="uid" id="uid" value="<?php echo $_SESSION['uid'];?>">
<input type="hidden" name="utype" id="utype" value="<?php echo $_SESSION['utype'];?>">