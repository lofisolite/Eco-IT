    // buton haut page admin
    divButton = document.getElementById("divButton");
    window.onscroll = function() {scrollFunction()};
    if(divButton !== 'undefined'){
      function scrollFunction() {
        if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
            divButton.style.display = "block";
          } else {
            divButton.style.display = "none";
          }
      }
    }
    
    function upPage(){
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0; 
    }
    
