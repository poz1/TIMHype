<?php

header("Access-Control-Allow-Origin: *");

$servername = "40.68.216.131";  
$username = "hypeTIM";
$password = "hypermedia";
$dbname = "HypeTIM_DB";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
$conn->set_charset('utf8mb4');  
 
    /* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>