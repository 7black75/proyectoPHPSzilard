// Funciones JavaScript que sólo funcionan mientras se haya producido el efecto de la función JQuery del nav
// Al pasar el ratón por la clase .active su fondo se volverá blanco, junto con el border-bottom generado por el JQuery
    function blanco(){
        var nav = document.getElementById("naveg");
        nav.style.borderBottom = "7px solid white";
        var loginbox = document.getElementById("login");
        loginbox.style.borderLeft = "1px solid #fff";
        var userBox = document.getElementById("userPanel");
        userBox.style.borderRight = "1px solid #fff";

    }
    // Al quitar el ratón, vuelve a su color original
    function normal(){
        var nav = document.getElementById("naveg");
        nav.style.borderBottom = "7px solid #e17d00";
        var loginbox = document.getElementById("login");
        loginbox.style.borderLeft = "1px solid #e17d00";
        var userBox = document.getElementById("userPanel");
        userBox.style.borderRight = "1px solid #e17d00";

    }