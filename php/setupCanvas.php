<?php
require 'serverConnect.php';

$id = intval($_GET['id']);

$sql="SELECT * FROM images WHERE ID = '".$id."'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)) {
  echo $row['Attributes'];
}