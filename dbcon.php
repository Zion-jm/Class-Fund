<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "class_fund";

$conn = new mysqli($servername, $username, $password, $dbname);

if(!$conn) {
    die("Connection Failed: " . mysqli_error($conn));
}
?>