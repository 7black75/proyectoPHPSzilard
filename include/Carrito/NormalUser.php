<?PHP
    print "<span class = \"normal\">Bienvenido/a </span> <span id = \"user\">".$_SESSION['nombre_usuario']."</span><span class = \"normal\"> - Artículos en tu carrito:</span> <span id = \"numero\">".count($_SESSION['addCarrito'])."</span>";
?>