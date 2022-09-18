console.log("Hello World!");

// window.onload=function(){
//     var bouton = document.getElementById('btnMenu');
//     var nav = document.getElementById('nav');
//     bouton.onclick = function(e){
//         if(nav.style.display=="block"){
//             nav.style.display="none";
//         }else{
//             nav.style.display="block";
//         }
//     };
// };

// function afficheMenu(obj){
   
//     var idMenu     = obj.id;
//     var idSousMenu = 'sous' + idMenu;
//     var sousMenu   = document.getElementById(idSousMenu);
    
//     /*****************************************************/
//     /**   on cache tous les sous-menus pour n'afficher    **/
//     /** que celui dont le menu correspondant est cliqué **/
//     /** où 4 correspond au nombre de sous-menus         **/
//     /*****************************************************/
  
    
//     if(sousMenu){
//        //alert(sousMenu.style.display);
//        if(sousMenu.style.display == "block"){
//           sousMenu.style.display = "none";
//        }
//        else{
//           sousMenu.style.display = "block";
//        }
//     }
//  }

/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }
  
  // Close the dropdown menu if the user clicks outside of it
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
  }
       