<?php
require "serverConnect.php";

$recipient = "wattmills@gmail.com";
$sender = $_SESSION['Email'];
$subject = "New Image From " + $sender;
$msg = "data:image/svg+xml;utf8," +  $_POST['data'];

mail($recipient,$sender,$subject,$msg);