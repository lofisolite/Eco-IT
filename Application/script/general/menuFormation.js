

jQuery(document).ready(() => {
    // menu - suivre une formation
    $('#menu-burger-show').click(function (){
        $('#menu-formation').addClass('show-menu');
        $('#menu-formation').removeClass('hide-menu');
    });

    $('#menu-burger-exit').click(function (){
        $('#menu-formation').addClass('hide-menu');
    });
  });
    

  