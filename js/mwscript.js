var canvas = new fabric.Canvas('c');

// Called when user submits design. Exports the content of the canvas to SVG format and displays it
// TODO: Also stored in a user's "history" of designs
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

// Returns product image URL from database
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

// Updates the canvas with the selected product image and customizable attributes
function setupProductCanvas(str) {
  if (str=="") {
    document.getElementById("productCanvasContainer").innerHTML="";
    return;
  }
  getProductImage(str);

  if (window.XMLHttpRequest) {
    xmlhttp=new XMLHttpRequest();
  } else {
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      
    }
  }
  xmlhttp.open("GET","php/setupProductCanvas.php?q="+str,true);
  xmlhttp.send();

  var name = new fabric.Textbox('Sample Name', 
        { left: 135, 
          top: 200,
          width: 400, 
          hasControls: false,
          lockMovementX: true,
          lockMovementY: true,
          hasBorders: true,
          textAlign: "center"});
      var address = new fabric.Textbox('123 Sample Address', 
        { left: 135, 
          top: 300,
          width: 400, 
          hasControls: false,
          lockMovementX: true,
          lockMovementY: true,
          hasBorders: true,
          textAlign: "center"});
      var phone = new fabric.Textbox('123-456-7899', 
        { left: 135, 
          top: 350,
          width: 400, 
          hasControls: false,
          lockMovementX: true,
          lockMovementY: true,
          hasBorders: true,
          textAlign: "center"});
      canvas.add(name);
      canvas.add(address);
      canvas.add(phone);
}