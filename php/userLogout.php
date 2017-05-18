<?php
  session_start();
  unset($_SESSION["email"]);
  unset($_SESSION["password"]);
  session_destroy();
   
  header("location:http://localhost:8080/HDS/index.php");