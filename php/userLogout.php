<?php
  session_start();
  unset($_SESSION['LoggedIn']);
  unset($_SESSION["Email"]);
  unset($_SESSION["Password"]);
  session_destroy();
   
  header("location:http://localhost:8080/HDS/index.php");