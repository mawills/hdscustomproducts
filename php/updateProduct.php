<?php
require 'serverConnect.php';

$id = intval($_GET['id']);
$productID = intval($_GET['productID']);
$attributes = intval($_GET['attributes']);

mysql_query("INSERT INTO products VALUES ('','$productID','$attributes')") or die ("The query could not be completed.")

//$sql="INSERT INTO products (id, productID, attributes) VALUES ('$id', '$productID', '$attributes')";
$result = mysqli_query($conn,$sql);