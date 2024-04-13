<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "rdl";

$conn = new mysqli($servername, $username, $password,$database);

if ($conn->connect_error) {
    die("something went wrong during connection");
}
