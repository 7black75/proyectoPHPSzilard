<!DOCTYPE HTML>
<?PHP
    session_start();
    set_include_path("/proyecto/include/error");
    // Esta página sólo puede ser accedida en caso de haberse producido un error. $codError pilla el código de error generado por la página correspondiente.
    $codError = $_GET['error'];
    // Cada código de error equivale a un mensaje en el array
    $arrayError = array(
        // Códigos de error de autor.php 
        1 => "No has seleccionado ningún libro a eliminar.",
        2 => "Ese libro ya existe en la base de datos.",
        // Códigos de error generales
        3 => "Ese usuario ya existe. Inténtalo de nuevo.",
        4 => "Formato de correo incorrecto.",
        5 => "No puedes suscribirte, ya estás suscrito.", // No es un error general, es un error del index.php
        6 => "Falta rellenar algún campo. Revisa los datos introducidos.",
        // Códigos de error correspondientes a userPanel.php
        7 => "Nombre de usuario introducido no válido. Mínimo 5 caracteres y máximo 10 caracteres alfanuméricos.",
        8 => "Nombre no válido. Utiliza sólo letras.",
        9 => "Contraseña no válida. Mínimo 8 y máximo 12 caracteres alfanuméricos y algunos símbolos como *.-_?=",
        10 => "Dirección no válida. Máximo 50 caracteres alfanuméricos y algunos símbolos como ºª,/ y espacios",
        11 => "Teléfono no válido. Debes introducir 9 números. Ni más ni menos.",
        // Códigos de error correspondientes a tienda.php
        12 => "No has añadido ningún libro al carrito. Prueba a añadir al menos uno.",
        13 => "No has introducido nada en el campo de búsqueda. Introduce al menos una palabra. O prueba a buscar TODO",
        14 => "Has introducido un tipo de dato que no corresponde con el criterio elegido.",
        // Códigos de error correspondientes a adminPanel.php
        15 => "Falta rellenar algún campo de modificación del usuario. Prueba de nuevo.",
        16 => "No has seleccionado ningún usuario a eliminar. Prueba de nuevo.",
        17 => "No has seleccionado ningún libro a eliminar. Prueba de nuevo.",
        18 => "No has seleccionado ningún pedido a actualizar. Introduce el número (ID) del pedido y establece un estado.",
        19 => "Falta rellenar algún campo de modificación del libro. Prueba de nuevo."
    );
    // Dependiendo de qué tipo de error sea, pertenecerá a una página u otra. Entonces el botón de Volver devolverá al usuario a la página que generó el código de error. Para errores comunes a varias páginas, devuelve al usuario al index.php
    if(($codError == 1) || ($codError == 2)){
        $link = "autor.php";
    } else if (($codError == 7) || ($codError == 8) || ($codError == 9) || ($codError == 10) || ($codError == 11)){
        $link = "userPanel.php";
    } else if(($codError == 12) || ($codError == 13) || ($codError == 14)){
        $link = "tienda.php";
    } else if (($codError == 15) || ($codError == 16)){
        $link = "adminPanel.php";
    } else {
        $link = "index.php";
    }
    // Esta condición evita que se pueda acceder a esta página sin haberse generado ningún código de error.
    if($_SESSION["error"] == 1){ // Si se ha generado un error, se muestra la información del mismo.
    // Generación de página de error con mensaje correspondiente al error
    print "
        <html lang = \"es\">
            <head>
                <title> Error de operación </title>
                <meta charset = \"utf-8\">
                <link rel = \"stylesheet\" href = \"css/error.css\" type = \"text/css\">
            </head>
            <body>
                <div id = \"adminErr\">
                    <p> Error de operación </p>
                </div>
                <div id = \"cuadroError\">
                    <p id = \"unError\"> Parece que ha habido un error :( </p>
                    <p id = \"explicacion\"><span id = \"codError\">Código de error: $codError</span> - $arrayError[$codError] </p>
                </div>
                <a href = $link> <button id = \"botonVolver\"> Volver atrás </button></a>
            </body>
        </html>
    ";
    $_SESSION["error"] = 0; // Se borra el error, de modo que una vez se salga de error.php, no se pueda entrar por link.
    } else {
        header("location: /proyecto/403.html"); // Evita la entrada ilegítima a la página error.php
        exit();
    }
?>