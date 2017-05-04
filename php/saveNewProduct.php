<?php
require 'serverConnect.php';

$productID = "1337";
$attributes = "test";
$placeholder = "TEST";

if(isset($_POST['done'])) {
    $name = $_POST['name'];
    $imgURL = $_POST['imgURL'];

    echo $name;
    echo $imgURL;

    mysqli_query($conn,"INSERT INTO products (name, imgURL) VALUES ('$name','$imgURL')");
    
}