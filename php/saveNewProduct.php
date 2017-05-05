<?php
require 'serverConnect.php';

$name = $_POST['name'];
$attributes = $_POST['attributes'];

echo $attributes;

mysqli_query($conn,"INSERT INTO products (name, attributes) VALUES ('$name','$attributes')");