<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>HDS Custom Products Database</title>

<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/hds.css" rel="stylesheet">
<script src='lib/fabric.js-1.7.9/dist/fabric.js'></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h1 class="text-center">HDS Custom Products</h1>
    </div>
  </div>
  <hr>
</div>
<div class="container">
  <div class="row text-center">
    <div class="col-lg-4">
      <h2>Select Product: </h2>
      <form>
      <select name="products" onchange="updateSelection(this.value)">
      <option value="">Choose a Product Below...</option>
      <?php
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "hds_custom_products";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $products = "SELECT * FROM products";
        $result = $conn->query($products);

        echo $products;

        if ($result->num_rows > 0) {
            $menu = "";
            while($row = $result->fetch_assoc()) {
              $menu .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
            }
        }
        echo $menu;  
      ?>
      </select>
      </form>
      <div id="productFields"></div>      
    </div>
    <div class="col-md-8">
      <h2>Product Image:</h2>
      <div id="productCanvasContainer">
        <canvas id="c" width="800" height="600"></canvas>
      </div>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="text-justify col-sm-4"> </div>
    <div class="col-sm-4 text-justify"> </div>
    <div class="col-sm-4 text-justify" id="submit-button-container">
      <button onclick="submitCanvas()">Continue</button>
    </div>
  </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>
<script src="js/mwscript.js"></script>

</body>
</html>
