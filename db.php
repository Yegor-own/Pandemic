<?php

$servername = ""; //I hide it for security
$username = ""; //I hide it for security
$password = ""; //I hide it for security
$database = ""; //I hide it for security

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$connection = mysqli_connect($servername, $username, $password, $database);
// Check connection   
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
