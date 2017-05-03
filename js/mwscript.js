var CANVAS_MAX_WIDTH = 700;
var CANVAS_MAX_HEIGHT = 600;

// Called when user selects a product from the drop-down menu. Updates the page with new product info/canvas
function updateSelection(str) {
  canvas.clear();
  setupProductCanvas(str);
}

// Updates the canvas with the selected product image and placeholder text/images
function setupProductCanvas(str) {
  if (str=="") { 
    return; 
  }

  var placeholderTextArray;

  $.get("php/getPlaceholderText.php?q="+str).then(function(placeholderText) {
    placeholderTextArray = placeholderText.split("\r\n");
    return $.get("php/getProductImage.php?q="+str);

  }).then(function(productImage) {
    fabric.Image.fromURL(productImage, function(oImg) {
        scaleCanvasSizeAndBackgroundImage(oImg);

        canvas.setBackgroundImage(oImg, canvas.renderAll.bind(canvas));
      });
    return $.get("php/setupProductCanvas.php?q="+str)

  }).then(function(productCanvas) {
    var productCanvasSetupArray = productCanvas.split("}");
    productCanvasSetupArray.splice(-1,1);
    for(var i = 0; i < productCanvasSetupArray.length; i++) {
      productCanvasSetupArray[i] += "}";
      canvas.add(new fabric.Textbox(placeholderTextArray[i],JSON.parse(productCanvasSetupArray[i])));
    }
  });
}

function scaleCanvasSizeAndBackgroundImage(oImg) {
  if(oImg.height > CANVAS_MAX_HEIGHT) {
    if(oImg.height > oImg.width) {
      var scalingFactor = canvas.height / oImg.height;
      oImg.scale(scalingFactor);
    } 
    canvas.setHeight(CANVAS_MAX_HEIGHT);
  } else {
    canvas.setHeight(oImg.height);
  }
  if(oImg.width > CANVAS_MAX_WIDTH) {
    if(oImg.width > oImg.height) {
      var scalingFactor = canvas.width / oImg.width;
      oImg.scale(scalingFactor);
    } 
    canvas.setWidth(CANVAS_MAX_WIDTH);
  } else {
    canvas.setWidth(oImg.width);
  }
}

// Adds a new product to the database
function saveNewProduct() {

}

// Saves the changes to a product after a user edits it
function saveProduct() {

}

// Removes a product from the database
function deleteProduct() {
  
}

// Called when user submits design. Exports the content of the canvas to SVG format and displays it
// TODO: Also emails a copy of the SVG to an HDS employee
function submitCanvas() {
  window.open("data:image/svg+xml;utf8," + canvas.toSVG());
}
