<?php

session_start();


// if already login, redirect to flight logs management page
if (isset($_SESSION['user_id'])) {
    header("Location: views/manage_flight_logs.php");
    exit();
} else {
    // if not login, redirect to login page
    header("Location: views/login.php");
    exit();
}
?>
