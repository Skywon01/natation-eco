console.log("Hello World!");

/* Au clic sur le bouton on change la classe */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }
  
  // Au clic hors de la zone, le menu disparait
  window.onclick= function(event) {
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
  }