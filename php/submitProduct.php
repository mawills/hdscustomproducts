<?php
require "serverConnect.php";

$recipient = "mwills@hdsideas.com";
$sender = $_SESSION['Email'];
$subject = "New Product From " + $sender;
$msg = "data:image/svg+xml;utf8," +  $_POST['data'];

mail($recipient,$sender,$subject,$msg);