<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "hds_custom_products";

$q = intval($_GET['q']);

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die('Could not connect: ' . mysqli_error($conn));
}

mysqli_select_db($conn,"ajax_demo");
$sql="SELECT * FROM product WHERE id = '".$q."'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)) {
  echo $row['img'];
}

mysqli_close($conn);
