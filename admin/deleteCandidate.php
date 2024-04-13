<?php
session_start();

require "../config/connection.php";

$id = $_GET['id'];

$sql = "DELETE FROM `candidate` WHERE `candidate`.`candidateNationalId` = '$id'";

if ($conn->query($sql)) {
    $_SESSION['success'] = "You have successfuly deleted a candidate!";
    header("location:index.php");
}
