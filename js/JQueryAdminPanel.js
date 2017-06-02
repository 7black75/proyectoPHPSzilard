// Similar a JQueryComun.js pero con ciertas variaciones propias del AdminPanel.php
    var $w = $(window).scroll(function(){
        if ( $w.scrollTop() > 100 ) {   
            $('#naveg').css({"border-bottom":"7px solid #e17d00"}); 
            $('.active').css({"box-shadow":"0px 0px 5px 3px rgba(0,0,0,0.75)"});
            $('.navegRapida').css({"position":"fixed"});
            $('.navegRapida').css({"top":"53px"});
            $('.active').attr("onmouseover","blanco()");
            $('.active').attr("onmouseout","normal()");
    // Al volver arriba, se quitan los estilos otorgados
        } else if ($w.scrollTop() < 100){
            $('#naveg').css({"border-bottom":"none"});
            $('.active').css({"box-shadow":"none"});
            $('.navegRapida').css({"position":"static"});
            $('.navegRapida').css({"top":"none"});
            $('.active').attr("onmouseover","");
            $('.active').attr("onmouseout","");
        }
    });