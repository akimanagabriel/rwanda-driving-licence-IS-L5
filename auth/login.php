<?php
session_start();
require_once "../config/connection.php";

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    $_SESSION['error'] = "method not allowed";
    return header("location:../");
}

extract($_POST);
// echo $adminName,"<br/>", $adminPassword;

// select from db
$sql = "SELECT * FROM `admin` WHERE `adminName` = '$adminName' AND `password` = '$adminPassword'";

$user = $conn->query($sql)->fetch_object();

if ($user == null) {
    $_SESSION['error'] = "invalid credentials";
    return header("location:../");
}


// after successfull credential verification
// set authenticated session data
$_SESSION['auth'] = $user;
// redirect user to admin page
header("location:../admin");
