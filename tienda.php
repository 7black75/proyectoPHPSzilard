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
	$rutaInclude     = 		$jsonPropiedades['tiendaInclude'];
	set_include_path 		($rutaInclude);


	// ----------------------------------------------- //
	// Acción ejecutada por el boton 'Procesar compra' //
	// ----------------------------------------------- //

	$compra = 0;
	$_SESSION['compra'] = 0;
	if(isset($_REQUEST['procesar'])){
		$addToCart = $_REQUEST['addProduct'];
		$addLibrosToCart = array();
		if($addToCart == null){
			$_SESSION['error'] = 1;
			header('location: /proyecto/error.php?error=12');
		} else {
			$_SESSION['compra'] = 1;
			foreach($addToCart as $indice => $key){
				$_SESSION["addCarrito"][$indice] = $addToCart[$indice];
			}
			header('location: /proyecto/carrito.php');
		}
	}

	// Validación del tipo de búsqueda
	if(isset($_REQUEST['buscar'])){
		$busqueda = $_REQUEST['busqueda'];
		$criterio = $_REQUEST['criterio'];
		if($criterio == "TODO"){
			header('location: /proyecto/tienda.php');
		}
		if(($busqueda == "") && ($criterio != "TODO")){
			$_SESSION['error'] = 1;
			header('location: /proyecto/error.php?error=13');
			exit();	
		} 
		if($criterio == 'anyo'){
			if(!preg_match('/^(\d){4}$/', $busqueda)){
				$_SESSION['error'] = 1;
				header('location: /proyecto/error.php?error=14');
				exit();
			}
		} else if ($criterio == 'precio'){
			if(!preg_match('/^[\d.]{0,7}$/', $busqueda)){
				$_SESSION['error'] = 1;
				header('location: /proyecto/error.php?error=14');
				exit();
			}
	}
	}

						
	// Configuración de la paginación
	// Paginación únicamente presente en el criterio de busqueda "TODOS LOS LIBROS"
	$limite = 4;
	$paginaActual = 1;
	$consultaDos = mysqli_query($conexion, "SELECT * from libros", MYSQLI_STORE_RESULT);
	$numFilasDos = mysqli_num_rows($consultaDos);
	$numFilasAux = $numFilasDos-2;
	if(isset($_GET['pag'])){
	$pag = $_GET['pag'];
	switch($pag){
		case ($pag<0):
			$paginaActual = 1;
			$pag = 0;
			break;
		case ($pag == 0):
			$paginaActual = 1;
			break;
		case (($pag>0) && ($pag<$numFilasAux)):
			$paginaActual = $pag/$limite+1;
			break;
		case(($pag>0) && ($pag==$numFilasAux)):
			$paginaActual = $pag/$limite+1;
			break;
		case (($pag>=$numFilasDos)):
			header("location: /proyecto/tienda.php?pag=".($numFilasDos-2)."");
			$paginaActual = $pag/$limite+1;
			break;
	}
} else {
	$pag = 0;
	$paginaActual = 1;
}
					
?>
<!DOCTYPE HTML>
<html lang = "es">
	<head>
		<meta charset = "utf-8">
		<title> Tienda - El Ejército Negro </title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> 
		<!-- Link de JQuery y del Script común para el efecto de la barra de navegación -->
		<script src="js/jquery.min.js"></script>
		<script type = "text/javascript" src = "js/JQueryComun.js"></script>
		<!-- Archivo JavaScript común para el efecto 'onmouseover' del '.active' -->
		<script type = "text/javascript" src = "js/scriptBarra.js"></script>
		<!-- Link del CSS común y el correspondiente a la página -->
		<link rel='stylesheet' href = "css/comun.css" type = "text/css">
		<link rel='stylesheet' href = "css/tienda.css" type = "text/css">
	</head>
    <body>
		<nav id = "naveg">
			<ul>
				<li><a href="index.php" >Inicio</a></li>
				<li><a href="autor.php">Autor</a></li>
				<li><a class = "active" href="#">Tienda</a></li>
				<li><a href="contacta.php">Contacta</a></li>
			</ul>
			<?PHP
				// Si no hay ningún usuario logueado, se manda al visitante a NoUser.php, que lo mandará a la página de login
				if(empty($_SESSION["nombre_usuario"])){
					include("NoUser.php");
					// Si el usuario es un administrador, se mostrará el contenido de Admin.php
				} else if (!empty($_SESSION["nombre_usuario"]) && ($_SESSION['tipo_usuario'] == "ADMINISTRADOR")){
					include("Admin.php");
					// Si el usuario es un usuario normal, se mostrará el contenido de NormalUser.php
				} else if (!empty($_SESSION["nombre_usuario"]) && ($_SESSION['tipo_usuario'] == "USUARIO")){
					include("NormalUser.php");
				}
			?>
			<!-- Pie de la página. Incluye mi nombre y los enlaces a la biografía del Autor (Wikipedia) y a su página oficial -->
			<footer>
				<p> SZILARD TOTH © TODOS LOS DERECHOS RESERVADOS </p>
				<!-- Div empleado para mover ambos enlaces como un conjunto -->
				<div id = "divAux">
					<a class = "link" target = "_blank" href = "https://es.wikipedia.org/wiki/Santiago_Garc%C3%ADa-Clairac"></a>
					<a class = "link" target = "_blank" href = "http://www.loslibrosdesantiago.com/"></a>
				</div>
			</footer>
		</section>
        </body>
    </html>