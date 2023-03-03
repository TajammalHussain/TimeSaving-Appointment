<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
unset($_SESSION['uid']);
unset($_SESSION['load']);
session_unset();
session_destroy();
header("location: login.php");
?>