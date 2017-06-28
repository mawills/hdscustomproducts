var CANVAS_MAX_WIDTH = 700;
var CANVAS_MAX_HEIGHT = 600;
var currentProduct = 0;
var canvasModified = false;

// Updates the canvas with the selected product image and placeholder text/images
function setupProductCanvas(productID) {
  if (productID=="") {
    return; 
  }
  if(!canvasModified)
  {
    currentProduct = productID;
    canvas.clear();
    $.get("php/setupProductCanvas.php?id="+productID, function(data) {
      canvas.loadFromJSON(data, canvas.renderAll.bind(canvas));
    });
  }
  else
  {
    if(confirm("Unsaved changes will be lost. Proceed?"))
    {
      currentProduct = productID;
      canvas.clear();
      $.get("php/setupProductCanvas.php?id="+productID, function(data) {
        canvas.loadFromJSON(data, canvas.renderAll.bind(canvas));
      });
      canvasModified = false;
    }
  }

  $("#save-product-button").addClass("disabled");
  $("#rasterize-svg").removeClass("disabled");
  $("#delete-product").removeClass("disabled");
  $("#save-new-product-button").removeClass("disabled");
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

String.prototype.escapeNewlineChars = function() {
  return this.replace(/\\/g, "\\\\");
}

// Adds a new product to the database
function saveNewProduct() {
  var name = prompt("Please enter a name for your product");
  while(name == "") {
    name = prompt("A name is required to save your product. Please choose a name.");
  }
  if(name != null) {
    $.post("php/saveNewProduct.php",
    {
      name: name,
      attributes: JSON.stringify(canvas).escapeNewlineChars()
    })
    .done(function(data) {
      // HACK: If successful, saveNewProduct.php echos "Your new product..."
      if(data[0] == 'Y') {
        alert(data);
        window.location.reload();
      } else {
        alert("There was an issue saving your product. Please try a name with 32 characters or fewer.");
      }
      
    });
  }
}

// Saves the changes to a product after a user edits it
function saveProduct() {
  if(currentProduct == 0)
    return alert("Please select a product or save a new product before saving.");

  $.post("php/saveProduct.php", 
    {
      id: currentProduct, 
      attributes: JSON.stringify(canvas).escapeNewlineChars()
    })
    .done(function(data) {
      alert(data);
    });

  canvasModified = false;
  $("#save-product-button").addClass("disabled");
}

// Removes a product from the database
function deleteProduct() {
  if(confirm("Are you sure?")) {
    $.post("php/deleteProduct.php", 
    {
      id: currentProduct, 
    })
    .done(function(data) {
      alert(data);
    });
  }
  window.location.reload();
}

// Called when user submits design. Exports the content of the canvas to SVG format and displays it
function submitCanvas() {
  window.open("data:image/svg+xml;utf8," + canvas.toSVG());
  $.post("php/submitProduct.php",
    {
      data: canvas.toSVG()
    })
}

function addTextbox() {
  var text = "Drag, resize, and edit this sample text!";
  var textboxSettings = {
    fontSize: 26,
    fontFamily: 'Arial',
    textAlign: 'left',  
    width: 300,
    height: 60,  
  }; 

  canvas.add(new fabric.Textbox(text, textboxSettings, {left: 0, top: 0}));
}

// Event handler for when the canvas has been modified
// Displays warning message when discarding unsaved changes
// Updates save/save new/delete/submit buttons
function canvasObjectEventHandler() {
  canvasModified = true;
  $("#save-product-button").removeClass("disabled");
  $("#save-new-product-button").removeClass("disabled");
};
canvas.on('object:selected', canvasObjectEventHandler);
canvas.on('object:removed', canvasObjectEventHandler);
canvas.on('object:moving', canvasObjectEventHandler);
canvas.on('object:modified', canvasObjectEventHandler);