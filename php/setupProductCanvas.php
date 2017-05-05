<?php
require 'serverConnect.php';

$q = intval($_GET['q']);

$sql="SELECT * FROM products WHERE ID = '".$q."'";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_array($result)) {
  echo $row['Attributes'];
}