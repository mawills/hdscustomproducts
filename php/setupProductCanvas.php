<?php
include 'serverConnect.php';

$sql="SELECT * FROM customizableareas WHERE productid = '".$q."'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)) {
  echo $row['attributes'];
}