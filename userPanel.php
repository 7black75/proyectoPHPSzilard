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
	$rutaInclude     = 		$jsonPropiedades['userPanelInclude'];
	set_include_path 		($rutaInclude);

	// ------------------------------------------------------- //
	// Acciones ejecutadas por los botones de updatear usuario //
	// ------------------------------------------------------- //

	// Al cambiar el nombre de usuario se realizan una serie de comprobaciones y se valida el campo para evitar un SQLInjection
	if(isset($_REQUEST['cambiarUser'])){
		$sesionActiva = $_SESSION['nombre_usuario'];
		$username = $_REQUEST['username'];
		$resultado = mysqli_query($conexion, "SELECT user FROM user WHERE user like '$username'", MYSQLI_STORE_RESULT); 
		$numFilas = mysqli_num_rows($resultado);
		if(($numFilas > 0) || (empty($username))){
			if($numFilas > 0){
				$_SESSION["error"] = 1;
				header("location: /proyecto/error.php?error=3");
			} else if (empty($username)){
				$_SESSION["error"] = 1;
				header("location: /proyecto/error.php?error=6");
			}
			// Se compone de letras, numeros, y algunos simbolos. Min 5, max 10.
		} else if(preg_match('/^[a-zA-Z0-9_-]{5,10}$/', $username)){
			$modificar = mysqli_query($conexion, "UPDATE user SET user = '".$username."' where user like '".$sesionActiva."'", MYSQLI_STORE_RESULT) or die ("Fallo en la consulta");
			$_SESSION['nombre_usuario'] = $username;
			header("location: /proyecto/userPanel.php?exito=1");
			exit();
		} else {
			$_SESSION["error"] = 1;
			header("location: /proyecto/error.php?error=7");
		}	
	}

	// Se cambia el nombre completo del usuario. Se valida con php para evitar SQLInjection
	if(isset($_REQUEST['cambiarNombre'])){
		$sesionActiva = $_SESSION['nombre_usuario'];
		$fullname = $_REQUEST['fullname'];
		if(empty($fullname)){
			$_SESSION["error"] = 1;
			header("location: /proyecto/error.php?error=6");
			// Se compone de letras mayusculas y minusculas y espacios
		} else if(preg_match('/^[a-zA-Z ]{3,50}$/', $fullname)){
			$modificar = mysqli_query($conexion, "UPDATE user SET NOMBRE = '".$fullname."' where user like '".$sesionActiva."'", MYSQLI_STORE_RESULT) or die ("Fallo en la consulta");
			header("location: /proyecto/userPanel.php?exito=2");
			exit();
		} else {
			$_SESSION["error"] = 1;
			header("location: /proyecto/error.php?error=8");
		}
		
	}

	// Cambia la contraseña. Se valida con php.
	if(isset($_REQUEST['cambiarContra'])){
		$sesionActiva = 	$_SESSION['nombre_usuario'];
		$password     = 	$_REQUEST['password'];
		if(empty($password)){
			$_SESSION["error"] = 1;
			header("location: /proyecto/error.php?error=6");
			// Debe contener al menos 1 letra, y al menos 1 número. Se permite usar letras, números y ciertos símbolos (sin permitir comillas simples y dobles para evitar SQLInjection)
		} else if (preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%*]{8,12}$/', $password)){
		$modificar = mysqli_query($conexion, "UPDATE user SET passwd = '".md5($password)."' where user like '".$sesionActiva."'", MYSQLI_STORE_RESULT) or die ("Fallo en la consulta");
		header("location: /proyecto/userPanel.php?exito=3");
				exit();
		} else {
			$_SESSION["error"] = 1;
			header("location: /proyecto/error.php?error=9");
		}
	}

	// Cambia el email. Se valida con php
	if(isset($_REQUEST['cambiarEmail'])){
		$sesionActiva = $_SESSION['nombre_usuario'];
		$email = $_REQUEST['email'];
		if((!filter_var($email, FILTER_VALIDATE_EMAIL)) || (empty($email))){
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$_SESSION["error"] = 1;
				header("location: /proyecto/error.php?error=4");
			} else if (empty($email)){
				$_SESSION["error"] = 1;
				header("location: /proyecto/error.php?error=6");
			}
		} else {
			$modificar = mysqli_query($conexion, "UPDATE user SET EMAIL = '".$email."' where user like '".$sesionActiva."'", MYSQLI_STORE_RESULT) or die ("Fallo en la consulta");
			header("location: /proyecto/userPanel.php?exito=4");
			exit();
		}
	}

	// Se cambia la dirección del usuario. Se valida con php.
	if(isset($_REQUEST['cambiarDirecc'])){
			$sesionActiva = $_SESSION['nombre_usuario'];
			$address = $_REQUEST['address'];
			if(empty($address)){
				$_SESSION["error"] = 1;
				header("location: /proyecto/error.php?error=6");
				// Se compone de números, letras (minus y mayus), espacios y algunos símbolos. Mín 5 caracteres, max 50.
			} else if(preg_match('/^[0-9A-Za-z ºª\/,]{5,50}$/', $address)){ 
			$modificar = mysqli_query($conexion, "UPDATE user SET DIRECCION = '".$address."' where user like '".$sesionActiva."'", MYSQLI_STORE_RESULT) or die ("Fallo en la consulta");
			header("location: /proyecto/userPanel.php?exito=5");
			exit();
			} else {
				$_SESSION["error"] = 1;
				header("location: /proyecto/error.php?error=10");
			}
	}
	
	// Se cambia el número de teléfono. Se valida con php.
	if(isset($_REQUEST['cambiarTlf'])){
			$sesionActiva = $_SESSION['nombre_usuario'];
			$tlf = $_REQUEST['telefono'];
			if(empty($tlf)){
				$_SESSION["error"] = 1;
				header("location: /proyecto/error.php?error=6");
				// Se deben introducir 9 números únicamente.
			} else if (preg_match('/^(\d){9}$/', $tlf)){
			$modificar = mysqli_query($conexion, "UPDATE user SET TELEFONO = '".$tlf."' where user like '".$sesionActiva."'", MYSQLI_STORE_RESULT) or die ("Fallo en la consulta");
			header("location: /proyecto/userPanel.php?exito=6");
			exit();
			} else {
				$_SESSION["error"] = 1;
				header("location: /proyecto/error.php?error=11");
			}
	}
?>
<!DOCTYPE HTML>
<html lang = "es">
	<head>
		<meta charset = "utf-8">
		<title> Administración del usuario - El Ejército Negro </title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<!-- Link de JQuery y del Script común para el efecto de la barra de navegación -->
		<script src="js/jquery.min.js"></script>
		<script type = "text/javascript" src = "js/JQueryComun.js"></script>
		<!-- Archivo JavaScript común para el efecto 'onmouseover' del '.active' -->
		<script type = "text/javascript" src = "js/scriptBarra.js"></script>
		<!-- Se incluye un archivo de estilos css común a todas las páginas, y el css correspondiente a la página actual -->
		<link rel='stylesheet' href = "css/comun.css" type = "text/css">
		<link rel = "stylesheet" href = "css/userPanel.css" type = "text/css">
	</head>
	<body>
        <?PHP
			// --------------------------------------------------------- //
			// Distintas versiones de la página según el nivel de acceso //
			// --------------------------------------------------------- //

			// Se comprueba si la sesión (nombre de usuario de la sesión) está vacía. 
			if(empty($_SESSION['nombre_usuario'])){
				include('NoUser.php'); // Si no hay usuario, no puede acceder a esta página.
			} else if(!empty($_SESSION["nombre_usuario"]) && ($_SESSION["tipo_usuario"] == "ADMINISTRADOR")){
				include('Admin.php'); // Si el usuario logueado es un administrador, se llama a esta versión, dándole acceso a funciones respectivas de su rango. Su nombre sale en rojo.
            } else if(!empty($_SESSION["nombre_usuario"]) && ($_SESSION["tipo_usuario"] == "USUARIO")){
				include('NormalUser.php'); // Si el usuario logueado es un usuario normal, verá esta versión de la página. Su nombre saldrá en amarillo.
            }
        ?>
	</body>
</html>