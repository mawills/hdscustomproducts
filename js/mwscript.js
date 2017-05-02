// Called when user selects a product from the drop-down menu. Updates the page with new product info/canvas
function updateSelection(str) {
  canvas.clear();
  updateFields(str);
  setupProductCanvas(str);
}

// Returns field header strings from database to display on page
// NOTE: NOT CURRENTLY IN USE
function updateFields(str) {
  if (str=="") {
    document.getElementById("productFields").innerHTML="";
    return;
  }
  /*if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  } else {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("productFields").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","php/getProductFields.php?q="+str,false);
  xmlhttp.send();*/
  $.get('php/getProductFields.php?q='+str, function(data) {
    $("#productFields").innerHTML=this.responseText;
  });
}

// Updates the canvas with the selected product image and customizable attributes
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
    for(var i = 0; i < productCanvasSetupArray.length-1; i++) {
      productCanvasSetupArray[i] += "}";
      canvas.add(new fabric.Textbox(placeholderTextArray[i],JSON.parse(productCanvasSetupArray[i])));
    }
  })
}

// Adds a new product to the database
function saveNewProduct() {

}

// Removes a product from the database
function deleteProduct() {
  
}

// Updates the canvas when a user is editing a new product to add to the database
function updateNewProduct() {
  document.getElementById("newProductForm").submit();
}

// Called when user submits design. Exports the content of the canvas to SVG format and displays it
// TODO: Also stored in a user's "history" of designs
// TODO: Also emails a copy of the SVG to an HDS employee
function submitCanvas() {
  window.open("data:image/svg+xml;utf8," + canvas.toSVG());
}
