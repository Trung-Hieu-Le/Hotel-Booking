<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$database = "hoteldb";

$conn = mysqli_connect($server,$username,$password,$database);

if(!$conn){
    die("<script>alert('connection Failed.')</script>");
}
// else{
//     echo "<script>alert('connection successfully.')</script>";
// }
?>