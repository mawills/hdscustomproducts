<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Create A New Product</title>

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
      <h1 class="text-center">Create a New Product</h1>
    </div>
  </div>
  <hr>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-4">
      <h2 class="text-center">Product Properties: </h2>
      <form id="newProductForm" action="updateNewProduct.php">
        <h3>Upload a Product Image:</h3>
        Upload from URL:<br>
        <input type="text" name='imgURL'>
        <input type="button" onclick="updateNewProduct()" value="Update"><br>
        Upload from Computer:<br>
        <input type="file" id="imgLoader"><br>
        <input type="button" onclick="updateNewProduct()" value="Update">
      </form>
      <div id="productFields"></div>      
    </div>
    <div class="col-md-8">
      <h2 class="text-center">Product Image:</h2>
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
      <button onclick="saveNewProduct()">Save</button>
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
