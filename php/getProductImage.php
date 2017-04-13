<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "hds_custom_products";
$canvasHeight = "500px";
$canvasWidth = "500px";

$q = intval($_GET['q']);

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die('Could not connect: ' . mysqli_error($conn));
}

mysqli_select_db($conn,"ajax_demo");
$sql="SELECT * FROM product WHERE id = '".$q."'";
$result = mysqli_query($conn,$sql);

/* while($row = mysqli_fetch_array($result)) {
  echo $row['img'];
} */

echo "
<script src='lib/fabric.js-1.7.9/dist/fabric.js'></script>
<canvas id='c'></canvas>
<script>
var canvas = new fabric.Canvas('c');

var rect = new fabric.Rect({
  left: 100,
  top: 100,
  fill: 'red',
  width: 20,
  height: 20
});

canvas.add(rect);
</script>";
mysqli_close($conn);
?>
</body>
</html>