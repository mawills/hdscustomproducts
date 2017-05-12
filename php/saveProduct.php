<?php
require 'serverConnect.php';

$id = intval($_POST['id']);
$attributes = $_POST['attributes'];

$sql="UPDATE products SET Attributes='$attributes' WHERE ID='$id'";
$result = mysqli_query($conn,$sql);

if(!$result) {
    die("There was an error while saving the product: " + mysql_error());
}

echo "Your product was saved successfully.";