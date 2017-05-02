<?php
require 'serverConnect.php';

$sql="SELECT * FROM fieldheaders WHERE id = '".$q."'";
$result = mysqli_query($conn,$sql);

echo '<h2>Customizable Options:</h2>';
echo '<ul>';
while($row = mysqli_fetch_array($result)) {
  echo '<li>' . $row['name'] . '</li>';
}
echo '</ul>';