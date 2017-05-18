<?php
require "serverConnect.php";

$email = $_POST['email'];
$password = $_POST['password'];
$email = stripslashes(mysqli_real_escape_string($conn,$email));
$password = md5(stripslashes(mysqli_real_escape_string($conn,$password)));

$sql = "SELECT * FROM users WHERE Email='$email' and Password='$password'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) == 1) {
  $_SESSION['Email'] = $email;
  header("location:http://localhost:8080/HDS/index.php");
} else {
  header("location:http://localhost:8080/HDS/index.php");
}