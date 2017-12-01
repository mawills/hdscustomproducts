<?php
session_start();

$dbhost = "127.0.0.1";
$dbuser = "root";
$dbpass = "";
$dbname = "image_canvas_database";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
  die('Could not connect: ' . mysqli_error($conn));
}
mysqli_select_db($conn,$dbname) or die('Error connecting to database: ' . mysqli_error());