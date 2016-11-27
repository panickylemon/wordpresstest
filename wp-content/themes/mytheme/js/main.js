$(document).ready(function(){

    $(".burger_menu").click(function() {
        $(".nav_mobile").slideToggle("slow");
        $(".burger_menu").hide();
        $(".burger_menu_close").show();
    });
    $(".burger_menu_close").click(function() {
        $(".nav_mobile").slideToggle("slow");
        $(".burger_menu").show();
        $(".burger_menu_close").hide();
    });
});



function windowSize() {
    if ($(window).width() >= '524') {
        $('.burger_menu').hide();
    }
    else  {
        $('.burger_menu').show();
    }
}
$(window).on('load resize', windowSize);


$(window).resize(function(){
    $(".burger_menu_close").hide();
    $(".nav_mobile").hide();
});
// вызовем событие resize
$(window).resize();