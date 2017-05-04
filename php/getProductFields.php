<?php
require 'serverConnect.php';

$q = intval($_GET['q']);

$sql="SELECT * FROM field_headers WHERE id = '".$q."'";
$result = mysqli_query($conn,$sql);

echo '<h2>Customizable Options:</h2>';
echo '<ul>';
while($row = mysqli_fetch_array($result)) {
  echo '<li>' . $row['name'] . '</li>';
}
echo '</ul>';