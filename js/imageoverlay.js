function selectImage(selectionValue) {
  var editButton = document.querySelector("#editTemplateSettings");
  var image = document.querySelector("img.preview");
  var placeholder = document.querySelector(".placeholder");
  var select = document.querySelector("select");
  if (selectionValue) {
    editButton.removeAttribute("disabled");
    editButton.parentElement.setAttribute("href", "tsettings.php/" + selectionValue);
    editButton.title = "Click to open the template editor";
    image.setAttribute("src", "image.php/" + selectionValue + "?t1=0123456789")
    image.style.display = "block";
    placeholder.style.display = "none";
    select.value = selectionValue;
  }
  else {
    editButton.setAttribute("disabled", "disabled");
    editButton.title = "Select a template first";
    image.style.display = "none";
    placeholder.style.display = "block";
  }
}

function handleImageSelection(event) {
  selectImage(event.target.value);
}

function handleFileInputChange(event) {
  var fileValue = event && event.target.value;
  var submitButton = document.querySelector("#uploadSubmitButton")
  if (fileValue) {
    submitButton.removeAttribute("disabled");
    submitButton.title = "Click to upload file";
  }
  else {
    submitButton.setAttribute("disabled", "disabled");
    submitButton.title = "Select a file to upload first";
  }
}

function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split('&');
  for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split('=');
    if (decodeURIComponent(pair[0]) == variable) {
      return decodeURIComponent(pair[1]);
    }
  }
  return null;
}

selectImage(getQueryVariable("open"));
handleFileInputChange();
