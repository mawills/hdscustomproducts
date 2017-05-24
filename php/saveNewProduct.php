<?php
require 'serverConnect.php';

$userID = intval($_SESSION['UserID']);
$name = $_POST['name'];
$attributes = $_POST['attributes'];

$sql = "INSERT INTO `products` (`UserID`, `Name`, `Attributes`) VALUES ('$userID', '$name', '$attributes')";
$result = mysqli_query($conn,$sql);

if(!$result) {
    die("There was an error while saving the product: " + mysql_error());
}

echo "Your new product ".$name." was saved successfully.";