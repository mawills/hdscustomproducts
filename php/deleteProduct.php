<?php
require 'serverConnect.php';

$id = intval($_POST['id']);

$sql = "DELETE FROM `products` WHERE `products`.`ID` = '$id'";
$result = mysqli_query($conn,$sql);

if(!$result) {
    die("There was an error while deleting the product: " + mysql_error());
}
echo "The product has been removed.";
header("location:http://localhost:8080/HDS/index.php");