<?php
require 'serverConnect.php';

$sql="SELECT * FROM customizable_areas WHERE productid = '".$q."'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)) {
  echo $row['attributes'];
}