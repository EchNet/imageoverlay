function handleImageSelection(event) {
  var selectionValue = event.target.value;
  var editButton = document.querySelector("#editTemplateSettings");
  if (selectionValue) {
    editButton.removeAttribute("disabled");
  }
  else {
    editButton.setAttribute("disabled", "disabled");
  }
  var image = document.querySelector("img.preview");
  if (selectionValue) {
    image.setAttribute("src", "images/" + selectionValue + ".jpg")
    image.style.visibility = "visible";
  }
  else {
    image.style.visibility = "hidden";
  }
}
