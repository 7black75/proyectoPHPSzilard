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
	$rutaInclude     = 		$jsonPropiedades['indexInclude'];
	set_include_path 		($rutaInclude);

	// --------------------------------------- //
	// Acción ejecutada por el botón suscribir //
	// --------------------------------------- //

	if(isset($_REQUEST['enviar'])){
		$email = $_REQUEST['email'];
		// Se comprueba si el email ya existe en la base de datos (tabla 'suscribir')
		$resultado = mysqli_query($conexion, "SELECT email FROM suscribir WHERE email like '$email'", MYSQLI_STORE_RESULT); 
		// Se cuenta el numero de filas de la consulta anterior
		$numFilas = mysqli_num_rows($resultado);
		// Si el email introducido no tiene el formato adecuado o ya existe en la base de datos, se imprime un cuadro de error
		if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) || ($numFilas > 0)) {
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$_SESSION["error"] = 1;
				header("location: /proyecto/error.php?error=4");
			}
			if($numFilas > 0){
				$_SESSION["error"] = 1;
				header("location: /proyecto/error.php?error=5");
			}
		}
	}
?>
<!DOCTYPE HTML>
<html lang = "es">
	<head>
		<meta charset = "utf-8">
		<title> Inicio - El Ejército Negro </title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<!-- Link de JQuery y del Script común para el efecto de la barra de navegación -->
		<script src="js/jquery.min.js"></script>
		<script type = "text/javascript" src = "js/JQueryComun.js"></script>
		<!-- Archivo JavaScript común para el efecto 'onmouseover' del '.active' -->
		<script type = "text/javascript" src = "js/scriptBarra.js"></script>
		<!-- Se incluye un archivo de estilos css común a todas las páginas, y el css correspondiente a la página actual -->
		<link rel='stylesheet' href = "css/comun.css" type = "text/css">
		<link rel='stylesheet' href = "css/index.css" type = "text/css">
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