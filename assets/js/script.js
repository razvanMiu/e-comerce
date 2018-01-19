
function showToggle(dropdownDiv) {
  document.getElementById(dropdownDiv).classList.toggle("show");
}
// Close the dropdown if the user clicks outside of it
/*
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}*/

window.onscroll = function (e) {
  // called when the window is scrolled.
  var dropdowns = document.getElementsByClassName("show");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      dropdowns[i].classList.remove('show');
    }
}
