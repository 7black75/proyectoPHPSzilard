<?PHP
    // ---------------------------- //
	// Configuración de la conexión //
	// ---------------------------- //

    SESSION_START();
	// Archivo de propiedades .json
	$propiedades     = 		file_get_contents("properties/host-properties.json"); 
	// Se cargan los datos del json en un array
	$jsonPropiedades = 		json_decode($propiedades, true);
	// Se usan los datos del array $jsonPropiedades para configurar la conexión. Sirve para en caso de necesitar cambiar los datos de conexión, se cambie un único archivo, en vez de cambiar todos los archivos .php del proyecto

	$host            = 		$jsonPropiedades['host']; 
	$hostUser        = 		$jsonPropiedades['hostUser']; 
	$hostPasswd      = 		$jsonPropiedades['hostPasswd'];
	$hostDb          = 		$jsonPropiedades['hostDb'];
	
	// Conexión a la base de datos con las variables de arriba
	$conexion        = 		mysqli_connect($host, $hostUser, $hostPasswd) or die ("No se ha podido realizar la conexión con la base de datos");
	mysqli_set_charset 		($conexion, "utf8");
	mysqli_select_db 		($conexion, $hostDb) or die ("No se ha podido seleccionar la base de datos, o esta no existe");

    // Se especifica la ruta de los archivos a incluir
	$rutaInclude     = 		$jsonPropiedades['carritoInclude'];
	set_include_path 		($rutaInclude);

    // ------------------------------------------------------------------------- //
    // Acciones ejecutadas por los botones 'Finalizar compra' y 'Vaciar carrito' //
    // ------------------------------------------------------------------------- //

    $usuarioActual = $_SESSION['ID_Usuario'];
    $articulosCarrito = $_SESSION['addCarrito'];
    $articulosCarritoString = "";
    $compra = $_SESSION['compra'];
    // Conversión de array a string (para guardar los articulos comprados en la base de datos a través de una variable)
    foreach($articulosCarrito as $indiceCarrito => $clave){
        $consultaAux = mysqli_query($conexion, "SELECT * FROM libros WHERE ID = $articulosCarrito[$indiceCarrito]");
        $datos = mysqli_fetch_array($consultaAux);
        $datosNombre = $datos['nombre'];
        $articulosCarritoString = $articulosCarritoString . "\'" ."$datosNombre". "\'<br>";
    }

   
    // Al pulsar el boton Finalizar compra
    if(isset($_REQUEST['finCompra'])){
        $precioFinal = $_SESSION['precioTotal'];
        $finalizarCompra = MYSQLI_QUERY($conexion, "INSERT INTO venta (Usuario, Libros, Precio) VALUES ($usuarioActual, '".$articulosCarritoString."', $precioFinal)", MYSQLI_STORE_RESULT) or die ("$precioFinal");
        $_SESSION['addCarrito'] = null;
        $articulosCarrito = null;
        
        header('location: /proyecto/tienda.php?exito=1');
    }

    //Vaciar carrito
    if(isset($_REQUEST['vaciarCarrito'])){
        $_SESSION['addCarrito'] = null;
        $articulosCarrito = null;
        header('location: /proyecto/tienda.php?exito=2');
    }
?>
<!DOCTYPE HTML>
<?PHP
    if($compra == 1){
        print '
        <html lang = "es">
            <head>
                <title> Carrito de compra </title>
                <meta charset = "utf-8">
                <link rel = "stylesheet" href = "css/carrito.css" type = "text/css">
            </head>
            <body>
                <section id = "contenido">
                    <section id = "usuario">
        ';
                    if($_SESSION['tipo_usuario'] == "ADMINISTRADOR"){
                        include('Admin.php'); // Versión del administrador
                    } else {
                        include('NormalUser.php'); // Versión del usuario normal
                    }
        print '
                    </section>
                    <section id = "info">
                        <img src = "img/indexImg2.png" alt = "info" style = "width: 150px; height: 150px;"> <h3> Este es tu carrito. Revisa los artículos que haya en él y procede a finalizar la compra. </h3>
                    </section>
                    <section id = "carrito">
';
                        $articulosCarrito = $_SESSION['addCarrito'];
                        $precioTotal = 0;
                        foreach($articulosCarrito as $indice => $key){
                            $consulta = MYSQLI_QUERY($conexion, "SELECT * FROM libros WHERE ID = $articulosCarrito[$indice]");
                            $fila = mysqli_fetch_array($consulta);
                            print "
							<ul class = \"producto\">
								<li class = \"imgElemento\"> <img src = ".$fila['imagen']." alt = \"en1\"> </li>
								<li class = \"elementoProducto\"> <span class = \"tipoDato\"> Nombre del libro: </span> <span class = \"dato\">".$fila['nombre']." </span></li>
								<li class = \"elementoProducto\"> <span class = \"tipoDato\"> Año de publicación: </span> <span class = \"dato\">".$fila['anyo']." </span></li>
								<li class = \"elementoProducto\"> <span class = \"tipoDato\"> Precio del libro: </span> <span class = \"dato\">".$fila['precio']." € </span></li>
								<li class = \"elementoProducto\"> <span class = \"tipoDato\"> Resumen: </span> <span class = \"dato\">".$fila['sinopsis']." </span></li>
							</ul>
						";
                        $precioTotal = $precioTotal + $fila['precio'];
                        $_SESSION['precioTotal'] = $precioTotal;
                        }
                       
                        print "<article id = \"checkout\">
                            <span class = \"tipoDato\"> Precio total: </span> <span class = \"dato\"> $precioTotal €</span><br><br>
                            <form method = \"post\">
                                <input id = \"finalizar\" type = \"submit\" name = \"finCompra\" value = \"Finalizar compra\">
                                <input id = \"vaciar\" type = \"submit\" name = \"vaciarCarrito\" value = \"Vaciar carrito\">
                            </form>
                        </article>
                        ";
print '
                    </section>
                </section>
            </body>
        </html>
    ';
    } else {
        header('location: /proyecto/tienda.php');
    }
?>
