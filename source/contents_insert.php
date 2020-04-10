<?php 
// db연결부분
$servername = "localhost";
$username = "pi";
$password = "980809";

$conn = new mysqli($servername, $username, $password);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// db삽입부분
if($_POST[]
?>