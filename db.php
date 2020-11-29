<?php


// $connection = mysqli_connect('localhost','id15471223_admin','JCibDV@dG[9*m71w','id15471223_helth_crowd');

// if(mysqli_connect_errno()){
//     echo 'Connection invalid!!!</br>';
//     echo mysqli_connect_error();
//     exit();
// }

$servername = "localhost";
$username = "id15492860_admin";
$password = "m==?w{TsNl3Z{YO6";
$database = "id15492860_helth";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$connection = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
