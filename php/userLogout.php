<?php
  session_start();
  unset($_SESSION['LoggedIn']);
  unset($_SESSION["Email"]);
  unset($_SESSION["Password"]);
  session_destroy();
   
  header("location:http://192.168.1.118:8080/HDS/index.php");