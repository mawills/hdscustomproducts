var CANVAS_MAX_WIDTH = 700;
var CANVAS_MAX_HEIGHT = 600;
var currentImage = 0;
var canvasModified = false;

// Updates the canvas with the selected image image and placeholder text/images
function setupCanvas(imageID) {
  if (imageID=="") {
    return; 
  }
  if(!canvasModified)
  {
    currentImage = imageID;
    canvas.clear();
    $.get("php/setupCanvas.php?id="+imageID, function(data) {
      canvas.loadFromJSON(data, canvas.renderAll.bind(canvas));
    });
  }
  else
  {
    if(confirm("Unsaved changes will be lost. Proceed?"))
    {
      currentImage = imageID;
      canvas.clear();
      $.get("php/setupCanvas.php?id="+imageID, function(data) {
        canvas.loadFromJSON(data, canvas.renderAll.bind(canvas));
      });
      canvasModified = false;
    }
  }

  $("#save-image-button").addClass("disabled");
  $("#rasterize-svg").removeClass("disabled");
  $("#delete-image").removeClass("disabled");
  $("#save-new-image-button").removeClass("disabled");
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

function saveNewImage() {
  var name = prompt("Please enter a name for your image");
  while(name == "") {
    name = prompt("A name is required to save your image. Please choose a name.");
  }
  if(name != null) {
    $.post("php/saveNewImage.php",
    {
      name: name,
      attributes: JSON.stringify(canvas).escapeNewlineChars()
    })
    .done(function(data) {
      // HACK: If successful, saveNewImage.php echos "Your new image..."
      if(data[0] == 'Y') {
        alert(data);
        window.location.reload();
      } else {
        alert("There was an issue saving your image. Please try a name with 32 characters or fewer.");
      }
      
    });
  }
}

function saveImage() {
  if(currentImage == 0)
    return alert("Please select an image or save a new image before saving.");

  $.post("php/saveImage.php", 
    {
      id: currentImage, 
      attributes: JSON.stringify(canvas).escapeNewlineChars()
    })
    .done(function(data) {
      alert(data);
    });

  canvasModified = false;
  $("#save-image-button").addClass("disabled");
}

function deleteImage() {
  if(confirm("Are you sure?")) {
    $.post("php/deleteImage.php", 
    {
      id: currentImage, 
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
  $.post("php/submitImage.php",
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
  $("#save-image-button").removeClass("disabled");
  $("#save-new-image-button").removeClass("disabled");
};
canvas.on('object:selected', canvasObjectEventHandler);
canvas.on('object:removed', canvasObjectEventHandler);
canvas.on('object:moving', canvasObjectEventHandler);
canvas.on('object:modified', canvasObjectEventHandler);