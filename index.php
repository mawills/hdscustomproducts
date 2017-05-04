<html lang="en" ng-app="kitchensink">
<head>
<title>HDS Custom Products</title>
<link rel="icon" href="assets/icon.png" type="image/x-icon">

<link href="css/master.css" rel="stylesheet">
<link href="css/prisim.css" rel="stylesheet">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/kitchensink.css" rel="stylesheet">
<link href="css/hds.css" rel="stylesheet">

<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/angular.min.js"></script>

<script async src="js/prisim.js"></script>
<script async src="js/fabric.js"></script>
<script async src="js/master.js"></script>
<script async src="js/paster.js"></script>
<script async src="js/utils.js"></script>
<script async src="js/app_config.js"></script>

<script defer src="js/mwscript.js" ></script>

</head>
<body>
<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <h1 class="text-center">HDS Custom Products</h1>
  </div>
</div>
<div class="row">
  <p class="text-center">The HDS Custom Produects web app is a quick and simple way to create product mock-ups and proofs to share with your HDS sales rep.</p>
</div>
<div class="row">
  <div class="col-lg-4 col-lg-offset-1">
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
</div>
  <div id="bd-wrapper" ng-controller="CanvasControls">

    <div style="position:relative;width:704px;float:left;" id="canvas-wrapper">

      <canvas id="canvas" style="border:2px solid #000000;"></canvas>

      <div id="color-opacity-controls" ng-show="canvas.getActiveObject()">
        <label for="opacity">Opacity: </label>
        <input value="100" type="range" bind-value-to="opacity">

        <label for="color" style="margin-left:10px">Color: </label>
        <input type="color" style="width:40px" bind-value-to="fill">
      </div>

      <div id="text-wrapper" style="margin-top: 10px" ng-show="getText()">

        <textarea bind-value-to="text"></textarea>

        <div id="text-controls">
          <label for="font-family" style="display:inline-block">Font family:</label>
          <select id="font-family" class="btn-object-action" bind-value-to="fontFamily">
            <option value="arial" selected>Arial</option>
            <option value="myriad pro">Myriad Pro</option>
            <option value="delicious">Delicious</option>
            <option value="verdana">Verdana</option>
            <option value="georgia">Georgia</option>
            <option value="courier">Courier</option>
            <option value="comic sans ms">Comic Sans MS</option>
            <option value="impact">Impact</option>
            <option value="monaco">Monaco</option>
          </select>
          <br>
          <label for="text-align" style="display:inline-block">Text align:</label>
          <select id="text-align" class="btn-object-action" bind-value-to="textAlign">
            <option>Left</option>
            <option>Center</option>
            <option>Right</option>
            <option>Justify</option>
          </select>
          <div>
            <label for="text-bg-color">Background color:</label>
            <input type="color" value="" id="text-bg-color" size="10" class="btn-object-action" bind-value-to="bgColor">
          </div>
          <div>
            <label for="text-lines-bg-color">Background text color:</label>
            <input type="color" value="" id="text-lines-bg-color" size="10" class="btn-object-action" bind-value-to="textBgColor">
          </div>
          <div>
            <label for="text-font-size">Font size:</label>
            <input type="range" value="" min="1" max="120" step="1" id="text-font-size" class="btn-object-action" bind-value-to="fontSize">
          </div>
          <div>
            <label for="text-line-height">Line height:</label>
            <input type="range" value="" min="0" max="10" step="0.1" id="text-line-height" class="btn-object-action" bind-value-to="lineHeight">
          </div>
        </div>
        <div id="text-controls-additional">
          <button type="button" class="btn btn-object-action" ng-click="toggleBold()" ng-class="{'btn-inverse': isBold()}">
            Bold
          </button>
          <button type="button" class="btn btn-object-action" id="text-cmd-italic" ng-click="toggleItalic()" ng-class="{'btn-inverse': isItalic()}">
            Italic
          </button>
          <button type="button" class="btn btn-object-action" id="text-cmd-underline" ng-click="toggleUnderline()" ng-class="{'btn-inverse': isUnderline()}">
            Underline
          </button>
          <button type="button" class="btn btn-object-action" id="text-cmd-linethrough" ng-click="toggleLinethrough()" ng-class="{'btn-inverse': isLinethrough()}">
            Linethrough
          </button>
          <button type="button" class="btn btn-object-action" id="text-cmd-overline" ng-click="toggleOverline()" ng-class="{'btn-inverse': isOverline()}">
            Overline
          </button>
        </div>
      </div>
    </div>

    <div id="commands" ng-click="maybeLoadShape($event)">

      <ul class="nav nav-tabs">
        <li><a href="#simple-shapes" data-toggle="tab">Text / Images</a></li>
        <li class="active"><a href="#object-controls-pane" data-toggle="tab">Controls</a></li>
      </ul>

      <div class="tab-content">

        <div class="tab-pane" id="simple-shapes">

          <p>Add <strong>text</strong> to canvas:</p>
          <p>
            <button class="btn" ng-click="addText()">Add text</button>
          </p>

          <p>Add <strong>simple shapes</strong> to canvas:</p>
          <p>
            <button type="button" class="btn rect" ng-click="addRect()">Rectangle</button>
            <button type="button" class="btn circle" ng-click="addCircle()">Circle</button>
            <button type="button" class="btn triangle" ng-click="addTriangle()">Triangle</button>
            <button type="button" class="btn line" ng-click="addLine()">Line</button>
            <button type="button" class="btn polygon" ng-click="addPolygon()">Polygon</button>
          </p>

          <p>Add <strong>image</strong> to canvas:</p>

          <form id="newProductForm" action="updateNewProduct.php">
            Upload from Computer:<br>
            <input type="file" id="addImage"><br>
          </form>
          <script>
            document.getElementById('addImage').addEventListener("change", function (e) {
              var file = e.target.files[0];
              var reader = new FileReader();
              reader.onload = function (f) {
                var data = f.target.result;                    
                fabric.Image.fromURL(data, function (img) {
                  var oImg = img.set({left: 0, top: 0, angle: 0});
                  canvas.add(oImg).renderAll();
                });
              };
              reader.readAsDataURL(file);
            });
          </script>

          <p>Set <strong>background image</strong> for canvas:</p>

          <form id="newProductForm" action="updateNewProduct.php">
            Upload from Computer:<br>
            <input type="file" id="addBackgroundImage""><br>
          </form>
          <script>
            document.getElementById('addBackgroundImage').addEventListener("change", function (e) {
              var file = e.target.files[0];
              var reader = new FileReader();
              reader.onload = function (f) {
                var data = f.target.result;                    
                fabric.Image.fromURL(data, function (oImg) {
                  scaleCanvasSizeAndBackgroundImage(oImg);
                  canvas.setBackgroundImage(oImg).renderAll();
                });
              };
              reader.readAsDataURL(file);
            });
          </script>

          <p><i>Note: Images must be <strong>.SVG</strong> (Scalable Vector Graphics) format to be useable for printing.</i></p>

        </div>

        <div class="tab-pane active" id="object-controls-pane">
          <div class="object-controls" object-buttons-enabled="getSelected()">

            <div style="margin-top:10px;">
              <p>
                <button class="btn btn-danger" id="remove-selected" ng-click="removeSelected()">
                  Remove selected object/group
                </button>
              </p>

              <button class="btn btn-lock btn-object-action" ng-click="setHorizontalLock(!getHorizontalLock())" ng-class="{'btn-inverse': getHorizontalLock()}">
                {[ getHorizontalLock() ? 'Unlock horizontal movement' : 'Lock horizontal movement' ]}
              </button>
              <br>
              <button class="btn btn-lock btn-object-action" ng-click="setVerticalLock(!getVerticalLock())" ng-class="{'btn-inverse': getVerticalLock()}">
                {[ getVerticalLock() ? 'Unlock vertical movement' : 'Lock vertical movement' ]}
              </button>
              <br>
              <button class="btn btn-lock btn-object-action" ng-click="setScaleLockX(!getScaleLockX())" ng-class="{'btn-inverse': getScaleLockX()}">
                {[ getScaleLockX() ? 'Unlock horizontal scaling' : 'Lock horizontal scaling' ]}
              </button>
              <br>
              <button class="btn btn-lock btn-object-action" ng-click="setScaleLockY(!getScaleLockY())" ng-class="{'btn-inverse': getScaleLockY()}">
                {[ getScaleLockY() ? 'Unlock vertical scaling' : 'Lock vertical scaling' ]}
              </button>
              <br>
              <button class="btn btn-lock btn-object-action" ng-click="setRotationLock(!getRotationLock())" ng-class="{'btn-inverse': getRotationLock()}">
                {[ getRotationLock() ? 'Unlock rotation' : 'Lock rotation' ]}
              </button>
            </div>

            <div style="margin-top:10px;">
              <button id="send-backwards" class="btn btn-object-action" ng-click="sendBackwards()">Send backwards</button>
              <button id="send-to-back" class="btn btn-object-action" ng-click="sendToBack()">Send to back</button>
            </div>

            <div style="margin-top:4px;">
              <button id="bring-forward" class="btn btn-object-action" ng-click="bringForward()">Bring forwards</button>
              <button id="bring-to-front" class="btn btn-object-action" ng-click="bringToFront()">Bring to front</button>
            </div>

          </div>
          <div style="margin-top:10px;" id="drawing-mode-wrapper">

            <button id="drawing-mode" class="btn btn-info" ng-click="setFreeDrawingMode(!getFreeDrawingMode())" ng-class="{'btn-inverse': getFreeDrawingMode()}">
              {[ getFreeDrawingMode() ? 'Exit free drawing mode' : 'Enter free drawing mode' ]}
            </button>

            <div id="drawing-mode-options" ng-show="getFreeDrawingMode()">
              <label for="drawing-mode-selector">Mode:</label>
              <select id="drawing-mode-selector" bind-value-to="drawingMode">
                <option>Pencil</option>
                <option>Circle</option>
                <option>Spray</option>
                <option>Pattern</option>
                <option>hline</option>
                <option>vline</option>
                <option>square</option>
                <option>diamond</option>
                <option>texture</option>
              </select>
              <br>
              <label for="drawing-line-width">Line width:</label>
              <input type="range" value="30" min="0" max="150" bind-value-to="drawingLineWidth">
              <br>
              <label for="drawing-color">Line color:</label>
              <input type="color" value="#005E7A" bind-value-to="drawingLineColor">
              <br>
              <label for="drawing-shadow-width">Line shadow width:</label>
              <input type="range" value="0" min="0" max="50" bind-value-to="drawingLineShadowWidth">
            </div>

            <div id="global-controls" style="margin-top:10px;">
              <p>
                <button class="btn btn-danger clear" ng-click="confirmClear()">Clear canvas</button>
              </p>
            </div>

          </div>
        </div>

      </div>

    </div>

  </div>

  <hr>

  <div class="row">
    <div class="col-lg-12">
      <button class="btn btn-success pull-right" id="rasterize-svg" ng-click="rasterizeSVG()" onclick="submitCanvas()">
        Submit
      </button>
      <button class="btn btn-object-action pull-right" id="save-new-product-button" onclick="saveNewProduct()">
        Save As New Product
      </button>
      <button class="btn btn-object-action pull-right" id="save-product-button" ng-click="saveProduct()">
        Save
      </button>
      <button class="btn btn-danger pull-right " id="delete-product" ng-click="deleteProduct()">
        Delete Product
      </button>
    </div>
  </div>

<script src="http://fabricjs.com/lib/font_definitions.js"></script>
<script src="http://fabricjs.com/js/kitchensink/app_config.js" ></script>
<script src="http://fabricjs.com/js/kitchensink/controller.js" ></script>

<script>
  //var kitchensink = {};
  var canvas = new fabric.Canvas('canvas');
  canvas.setHeight(600);
  canvas.setWidth(700);
</script>

</body>
</html>