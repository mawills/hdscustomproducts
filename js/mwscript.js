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



document.getElementById('addImage').addEventListener("change", function (e) {
  var file = e.target.files[0];
  var reader = new FileReader();
  reader.onload = function (f) {
    var data = f.target.result;                    
    fabric.Image.fromURL(data, function (img) {
      var oImg = img.set({left: 0, top: 0, angle: 00,width:100, height:100}).scale(0.9);
      canvas.add(oImg).renderAll();
      var a = canvas.setActiveObject(oImg);
      var dataURL = canvas.toDataURL({format: 'png', quality: 0.8});
    });
  };
  reader.readAsDataURL(file);
});



function addImage() {
  /*document.getElementById('addImage').addEventListener("change", function (e) {
  var file = e.target.files[0];
  var reader = new FileReader();
  reader.onload = function (f) {
    var data = f.target.result;                    
    fabric.Image.fromURL(data, function (img) {
      var oImg = img.set({left: 0, top: 0, angle: 00,width:100, height:100}).scale(0.9);
      canvas.add(oImg).renderAll();
      var a = canvas.setActiveObject(oImg);
      var dataURL = canvas.toDataURL({format: 'png', quality: 0.8});
    });
  };
  reader.readAsDataURL(file);
});*/

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
