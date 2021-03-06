<?php require "php/serverConnect.php"; ?>
<html lang="en" ng-app="kitchensink">
<head>
<title>Canvas Demo</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"><link href="css/bootstrap.css" rel="stylesheet">
<link href="css/kitchensink.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<script src="js/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="js/angular.min.js"></script>
<script src="js/fabric.js"></script>

<script async src="js/utils.js"></script>

<script defer src="js/app_config.js" ></script>
<script defer src="js/mwscript.js" ></script>
<script defer src="js/controller.js" ></script>

</head>
<body>

<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./index.php#">
        Image Canvas Demo
      </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">

      <?php
        if(empty($_SESSION['LoggedIn'])) {
          ?>
          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
          <ul id="login-dp" class="dropdown-menu">
            <li>
             <div class="row">
                <div class="col-md-12">
                 <form method="post" class="form" role="form" action="php/checklogin.php" accept-charset="UTF-8" id="login-nav">
                    <div class="form-group">
                     <label  for="email" class="sr-only">Email address</label>
                     <input name="email" type="email" class="form-control" id="email" placeholder="Email address" required>
                    </div>
                    <div class="form-group">
                     <label for="password" class="sr-only">Password</label>
                     <input name="password" type="password" class="form-control" id="password" placeholder="Password" required>
                     <div class="help-block text-right"><a href="">Forget the password?</a></div>
                    </div>
                    <div class="form-group">
                      <button type="submit" id="sign-in-button" class="btn btn-primary btn-block">Sign in</button>
                    </div>
                    <div class="checkbox">
                     <label>
                     <input type="checkbox"> keep me logged-in
                     </label>
                    </div>
                 </form>
                </div>
                <div class="bottom text-center">
                  Don't have an account? <a href="./register.php"><b>Create one.</b></a>
                </div>
             </div>
            </li>
          </ul>
        </li>
        <?php
        }

        else {
          ?>
            <li>
              <a href="./php/userLogout.php">Logout</a>
            </li>
          <?php
        }
      ?>

      </ul>
    </div>
  </div>
</nav>

  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h1 class="text-center">Image Creator Demo</h1>
    </div>
  </div>
  <div class="row">
    <p class="text-center">This web app is a quick and simple way to create images and drawings and export them as vector art.</p>
  </div>

  <?php
  if(!empty($_SESSION['LoggedIn'])) {
  ?>

  <div class="row">
    <div class="col-lg-4 col-lg-offset-1">
        <h2>Select Image: </h2>
        <form>
        <select name="images" onchange="setupCanvas(this.value)">
        <option value="">Choose an Image Below...</option>
        <?php
          $userID = intval($_SESSION['UserID']);
          $images = "SELECT * FROM images WHERE UserID = '$userID'";
          if($userID == 14) {
            $images = "SELECT * FROM images";
          }
          $result = $conn->query($images);

          echo $images;

          if ($result->num_rows > 0) {
              $menu = "";
              while($row = $result->fetch_assoc()) {
                $menu .= '<option value="' . $row["ID"] . '">' . $row["Name"] . '</option>';
              }
          }
          echo $menu;
        ?>
        </select>
        </form>
        <div id="imageFields"></div>
      </div>
  </div>


  <div id="bd-wrapper" ng-controller="CanvasControls">

    <div id="canvas-wrapper">

      <canvas id="canvas"></canvas>

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
        <li class="active"><a href="#simple-shapes" data-toggle="tab">Text / Images</a></li>
        <li><a href="#object-controls-pane" data-toggle="tab">Controls</a></li>
      </ul>

      <div class="tab-content">

        <div class="tab-pane active" id="simple-shapes">

          <p>Add <strong>text</strong> to canvas:</p>
          <p>
            <button class="btn" onclick="addTextbox()">Add text</button>
          </p>

          <p>Add <strong>simple shapes</strong> to canvas:</p>
          <p>
            <button type="button" class="btn rect" ng-click="addRect()">Rectangle</button>
            <button type="button" class="btn circle" ng-click="addCircle()">Circle</button>
            <button type="button" class="btn triangle" ng-click="addTriangle()">Triangle</button>
            <button type="button" class="btn line" ng-click="addLine()">Line</button>
            <button type="button" class="btn polygon" ng-click="addPolygon()">Polygon</button>
          </p>

          <div id="drawing-mode-wrapper">

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

          </div>

          <p>Add <strong>images or logos</strong> to canvas:</p>
          <form id="newImageForm">
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
          <form id="newImageForm">
            Upload from Computer:<br>
            <input type="file" id="addBackgroundImage"><br>
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

        <div class="tab-pane" id="object-controls-pane">
          <div class="object-controls" object-buttons-enabled="getSelected()">

            <div style="margin-top:10px;">
              <p>
                <button class="btn btn-danger" id="remove-selected" ng-click="removeSelected()">
                  Delete selected text/image
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
              <button id="send-backwards" class="btn btn-object-action" ng-click="sendBackwards()">
                Send backwards
              </button>
              <button id="send-to-back" class="btn btn-object-action" ng-click="sendToBack()">
                Send to back
              </button>
            </div>

            <div style="margin-top:4px;">
              <button id="bring-forward" class="btn btn-object-action" ng-click="bringForward()">
                Bring forwards
              </button>
              <button id="bring-to-front" class="btn btn-object-action" ng-click="bringToFront()">
                Bring to front
              </button>
            </div>

          </div>
          <div id="drawing-mode-wrapper">

            <div id="global-controls" style="margin-top:10px;">
              <p>
                <button class="btn btn-danger clear" ng-click="confirmClear()">Clear canvas</button>
              </p>
            </div>

            <p><i>Tip: Shift-click to select/deselect objects in a group.</i></p>

          </div>
        </div>
      </div>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-lg-11">

      <button class="btn btn-success pull-right disabled" id="rasterize-svg" ng-click="rasterizeSVG()" onclick="submitCanvas()">
        Export Vector Art
      </button>
      <button class="btn btn-object-action pull-right disabled" id="save-new-image-button" onclick="saveNewImage()">
        Save As New Image
      </button>
      <button class="btn btn-object-action pull-right disabled" id="save-image-button" onclick="saveImage()">
        Save
      </button>
      <button class="btn btn-danger pull-right disabled" id="delete-image" onclick="deleteImage()">
        Delete Image
      </button>

    </div>
  </div>


  <?php
  } else { ?>

    <div class="row">
      <div class="row-lg-12 text-center">
        <h2>Log in or create an account to continue!</h2>
      </div>
    </div>
    <div class="row">
      <div class="row-lg-12 text-center contact-us">
        <hr>
        <h2>Need help?</h2>
        <p>Contact us at <a href="mailto:wattmills@gmail.com">wattmills@gmail.com</a></p>
      </div>
    </div>
  <?php
  }
  ?>



<img class="yoshi" src="assets/shib.png" style="display:none;" alt=""/>

<script type="text/javascript">
  if ( window.addEventListener ) {
    var state = 0, konami = [38,38,40,40,37,39,37,39,66,65];
    window.addEventListener("keydown", function(e) {
      if ( e.keyCode == konami[state] ) state++;
      else state = 0;
      if ( state == 10 ) {
        $(".yoshi").css("display","inline");
        $(".yoshi").css("position","absolute");
        $(".yoshi").css("bottom","0");
        $(".yoshi").css("right","0");
        $(".yoshi").fadeOut(4000);
      }
      }, true);
  }
</script>

<script>
  var canvas = new fabric.Canvas('canvas');
  canvas.setHeight(600);
  canvas.setWidth(700);
</script>

</body>
</html>