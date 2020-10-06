function handleImageSelection(event) {
  var selectionValue = event && event.target.value;
  var editButton = document.querySelector("#editTemplateSettings");
  var image = document.querySelector("img.preview");
  var placeholder = document.querySelector(".placeholder");
  if (selectionValue) {
    editButton.removeAttribute("disabled");
    editButton.parentElement.setAttribute("href", "tsettings.php/" + selectionValue);
    editButton.title = "Click to open the template editor";
    image.setAttribute("src", "image.php/" + selectionValue + "?t1=0123456789")
    image.style.display = "block";
    placeholder.style.display = "none";
  }
  else {
    editButton.setAttribute("disabled", "disabled");
    editButton.title = "Select a template first";
    image.style.display = "none";
    placeholder.style.display = "block";
  }
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

handleImageSelection();
handleFileInputChange();
