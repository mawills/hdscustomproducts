
var placeholderTextArray;

// Called when user submits design. Exports the content of the canvas to SVG format and displays it
// TODO: Also stored in a user's "history" of designs
// TODO: Also emails a copy of the SVG to an HDS employee
function submitCanvas() {
  window.open("data:image/svg+xml;utf8," + canvas.toSVG());
}

// Called when user selects a product from the drop-down menu. Updates the page with new product info/canvas
function updateSelection(str) {
  canvas.clear();
  updateFields(str);
  setupProductCanvas(str);
}

// Returns field header strings from database to display on page
function updateFields(str) {
  if (str=="") {
    document.getElementById("productFields").innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  } else {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("productFields").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","php/getProductFields.php?q="+str,true);
  xmlhttp.send();
}

// Adds product image to canvas using product image URL from database
function getProductImage(str) {
  if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  } else {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      fabric.Image.fromURL(this.responseText, function(oImg) {
        canvas.add(oImg);
        canvas.sendToBack(oImg);
        oImg.selectable = false;
      });
    }
  }
  xmlhttp.open("GET","php/getProductImage.php?q="+str,true);
  xmlhttp.send();
}

// Returns the placeholder text for the fabric.js Textboxes
function getPlaceholderText(str) {
  if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  } else {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      placeholderTextArray = this.responseText.split("\r\n");
    }
  }

  xmlhttp.open("GET","php/getPlaceholderText.php?q="+str,true);
  xmlhttp.send();
}

// Updates the canvas with the selected product image and customizable attributes
function setupProductCanvas(str) {
  if (str=="") { 
    return; 
  }

  getProductImage(str);
  getPlaceholderText(str);

  if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  } else {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      var productCanvasSetupArray = this.responseText.split("}");
      for(var i = 0; i < productCanvasSetupArray.length-1; i++) {
        productCanvasSetupArray[i] += "}";
        console.log(placeholderTextArray);
        console.log(productCanvasSetupArray);
        canvas.add(new fabric.Textbox(placeholderTextArray[i],JSON.parse(productCanvasSetupArray[i])));
      }
    }
  }
  xmlhttp.open("GET","php/setupProductCanvas.php?q="+str,true);
  xmlhttp.send();
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