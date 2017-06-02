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
	$rutaInclude     = 		$jsonPropiedades['autorInclude'];
	set_include_path 		($rutaInclude);

	// ---------------------------------------------------------- //
	// Acción ejecutada por el botón de borrar libro en autor.php //
	// ---------------------------------------------------------- //

	if(isset($_REQUEST['borrar'])){
		@$eliminar = $_REQUEST['eliminar'];
		if($eliminar == null){
			$_SESSION["error"] = 1;
			header("location: /proyecto/error.php?error=1");
		} else {
			header("location: /proyecto/autor.php?exito=1");
			foreach($eliminar as $eli){
				$consultaBorrar = mysqli_query($conexion, "DELETE FROM libros where ID = $eli", MYSQLI_STORE_RESULT) or die ("No se ha podido borrar el libro");
			}
		}
	}

	// ------------------------------------------------------- //
	// Acción ejecutada por el botón añadir libro en autor.php //
	// ------------------------------------------------------- //

	if(isset($_REQUEST['addLibro'])){
		$nombreLibro = $_REQUEST['nombreLibro'];
		$anyoLibro = $_REQUEST['anyoLibro'];
		$sinopsisLibro = $_REQUEST['sinopsisLibro'];
		$precioLibro = $_REQUEST['precioLibro'];
		$comprobacion = mysqli_query($conexion, "SELECT * FROM libros where nombre like '".$nombreLibro."'", MYSQLI_STORE_RESULT) or die ("No se ha podido comprobar el numero de coincidencias");
		$numFilas = mysqli_num_rows($comprobacion);
		if($numFilas > 0){
			$_SESSION["error"] = 1;
			header("location: /proyecto/error.php?error=2");
		} else {
			if((empty($nombreLibro)) || (empty($anyoLibro)) || (empty($precioLibro)) || (empty($sinopsisLibro))){
				$_SESSION["error"] = 1;
				header("location: /proyecto/error.php?error=6");
			} else {
				$add = mysqli_query($conexion, "INSERT INTO libros (nombre, anyo, sinopsis, precio) VALUES ('".$nombreLibro."', $anyoLibro, '".$sinopsisLibro."','".$precioLibro."')", MYSQLI_STORE_RESULT);
				header("location: /proyecto/autor.php?exito=2");
			}
		}
	}
?>
<!DOCTYPE HTML>
<html lang = "es">
	<head>
		<meta charset = "utf-8">
		<title> Autor - El Ejército Negro </title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<!-- Link de JQuery y del Script común para el efecto de la barra de navegación -->
		<script src="js/jquery.min.js"></script>
		<script type = "text/javascript" src = "js/JQueryComun.js"></script>
		<!-- Script local de configuración del Slide en JQuery -->
		<script src="js/jquery.slides.js"></script>
		<script>
			$(function(){
				$(".slides").slidesjs({
					play: {
					active: true,
					effect: "slide",
					interval: 3000,
					auto: true,
					swap: true,
					pauseOnHover: false,
					restartDelay: 2500
					}
				});
			});
		</script>
		<!-- Archivo JavaScript común para el efecto 'onmouseover' del '.active' -->
		<script type = "text/javascript" src = "js/scriptBarra.js"></script>
		<!-- Link de css común y link de la página autor.php -->
		<link rel='stylesheet' href = "css/comun.css" type = "text/css">
		<link rel='stylesheet' href = "css/autor.css" type = "text/css">
	</head>
	<body>
		<?PHP
			// --------------------------------------------------------- //
			// Distintas versiones de la página según el nivel de acceso //
			// --------------------------------------------------------- //
			
			// Se comprueba si la sesión (nombre de usuario de la sesión) está vacía. 
			if(empty($_SESSION["nombre_usuario"])){
				include('NoUser.php'); // Si el usuario no está logeado, se llama a esta versión de la página. La versión estándar
			 } else if (!empty($_SESSION["nombre_usuario"]) && ($_SESSION["tipo_usuario"] == "ADMINISTRADOR")){
				include('Admin.php'); // Si el usuario logueado es un administrador, se llama a esta versión, dándole acceso a funciones respectivas de su rango. Su nombre sale en rojo.
			} else if (!empty($_SESSION["nombre_usuario"]) && ($_SESSION["tipo_usuario"] == "USUARIO")){
				include('NormalUser.php'); // Si el usuario logueado es un usuario normal, verá esta versión de la página. Su nombre saldrá en amarillo.
			}
		?>
	</body>
</html>