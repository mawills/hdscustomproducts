<?php
require "serverConnect.php";

$salt = "Yoshiba the red Shiba Inu";
$email = $_POST['email'];
$password = $_POST['password'];
$email = stripslashes(mysqli_real_escape_string($conn,$email));
$password = hash('sha256',hash('md5',hash('md5',$salt.$password) . hash('sha256',$salt.$password)));

$sql = "SELECT * FROM users WHERE Email='$email' and Password='$password'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) == 1) {
  $_SESSION['Email'] = $email;
  $_SESSION['LoggedIn'] = true;
  
  $sql = "SELECT ID FROM users WHERE Email='$email'";
  $result = mysqli_query($conn,$sql);
  $_SESSION['UserID'] = $result->fetch_row()[0];

  header("location:http://192.168.1.118:8080/HDS/index.php");
} else {
  header("location:http://192.168.1.118:8080/HDS/index.php");
}