<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "hnf";
$connect = mysqli_connect($host, $username, $password);
mysqli_select_db($connect, $database);
?>