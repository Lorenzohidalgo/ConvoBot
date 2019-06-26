$(document).ready(function () {
    $("#sidebar").mCustomScrollbar({
        theme: "minimal"
    });

    $('#dismiss, .overlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').addClass('active');
        $('.overlay').addClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });

    $('#nav-icon0').click(function(){
            $(this).toggleClass('open');
            
            setTimeout( function(){ 
            $('#nav-icon0').toggleClass('open');
    }  , 1000 );

    
        });

 
     $('#success-alert').fadeIn().delay(7000).fadeOut();
  
  

});