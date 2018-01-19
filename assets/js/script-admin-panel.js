

var imageData = new Image();

function showToggle(dropdownDiv, li) {

  document.getElementById(li).classList.toggle("greenBorder");
  document.getElementById(dropdownDiv).classList.toggle("show");
}

function myFunction() {
  var file = document.getElementById('iamgeUpload').value;
  var device = document.getElementsByName('device');

  var filePath = file.substring(file.lastIndexOf("\\") + 1, file.length);

  for(var i = 0; i < device.length; i++) {
    if(device[i].checked) {
      var fileFullPath = "assets\\images\\" + device[i].value + "\\" + filePath;
    }
  }

  checkImageExists(fileFullPath, function(existsImage) {
    if(existsImage == true) {
      document.getElementById('deviceImage').src = fileFullPath;
      document.getElementById('deviceImage').style.display = "block";
    }
    else {
    // image not exist
    document.getElementById('deviceImage').style.display = "none";
    alert("You should choose the right device!");
    }

    document.getElementById('iamgeUpload').value = null;
    imageData = null;
    imageData = new Image();
  });
}

function checkImageExists(imageUrl, callBack) {
  imageData.onload = function() {
    callBack(true);
  };
  imageData.onerror = function() {
    callBack(false);
  };
  imageData.src = imageUrl;
}
