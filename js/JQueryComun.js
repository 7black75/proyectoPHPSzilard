// Función JQuery que hace que al bajar 100px en la página, se añadan algunos estilos al nav y a la clase .active
// La idea es que al tocar el nav el border-bottom del header, este parezca que se ha quedado pegado al nav
    var $w = $(window).scroll(function(){
        if ( $w.scrollTop() > 100 ) {   
            $('nav').css({"border-bottom":"7px solid #e17d00"}); 
            $('.active').css({"box-shadow":"0px 0px 5px 3px rgba(0,0,0,0.75)"});
            $('.active').attr("onmouseover","blanco()");
            $('.active').attr("onmouseout","normal()");
    // Al volver arriba, se quitan los estilos otorgados
        } else if ($w.scrollTop() < 100){
            $('nav').css({"border-bottom":"none"});
            $('.active').css({"box-shadow":"none"});
            $('.active').attr("onmouseover","");
            $('.active').attr("onmouseout","");
        }
    });