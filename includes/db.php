<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$db_name = "petshop_db";
$port = "3307";

$conn = mysqli_connect($host, $user, $password, $db_name, $port);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());

}
?>