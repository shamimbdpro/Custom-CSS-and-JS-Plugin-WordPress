function openCity(evt, cityName) {
  var i, editor_tabcontent, tablinks;
  editor_tabcontent = document.getElementsByClassName("editor_tabcontent");
  for (i = 0; i < editor_tabcontent.length; i++) {
    editor_tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
