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

  $.get("php/setupProductCanvas.php?q="+str, function(data) {
    console.log(data);
    console.log(data[549]);
    console.log(data[550]);
    console.log(data[551]);
    console.log(data[552]);
    console.log(data[553]);
    canvas.loadFromJSON(data, canvas.renderAll.bind(canvas));
  });
}

// Resizes the canvas to fit the background image, unless the background image is > max dimensions, instead scales background image
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
// TODO: Make sure the product doesn't already exist in the database
function saveNewProduct() {
  var name = prompt("Please enter a name for your product");
  while(name == null) {
    prompt("A name is required to save your product. Please choose a name.");
  }
  $.post("php/saveNewProduct.php",
  {
    name: name,
    attributes: JSON.stringify(canvas.toJSON())
  },
  alert("Your new product "+name+" has been saved."));
}

// Saves the changes to a product after a user edits it
function saveProduct() {
    console.log(JSON.stringify(canvas.toJSON()));
}

// Removes a product from the database
function deleteProduct() {
  
}

// Called when user submits design. Exports the content of the canvas to SVG format and displays it
// TODO: Also emails a copy of the SVG to an HDS employee
function submitCanvas() {
  window.open("data:image/svg+xml;utf8," + canvas.toSVG());
}
