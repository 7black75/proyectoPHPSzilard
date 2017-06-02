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

	// ------------------------------------------------------------------- //
	// Adquiere el valor de la variable "exito" enviada desde register.php //
	// ------------------------------------------------------------------- //

	@$ex = $_GET['exito'];
	if($ex == true){
		print '<div id = "valido"><p>¡Te has registrado correctamente! Ahora puedes acceder</p></div>';
	}

	// ----------------------------------- //
	// Acción ejecutada por el botón login //
	// ----------------------------------- //

	if(isset($_REQUEST['login'])){
		$user = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$resultadoConsulta = mysqli_query($conexion, "SELECT * FROM user WHERE user = '".$user."'", MYSQLI_STORE_RESULT);
		$fila = mysqli_fetch_array($resultadoConsulta);
		$idUsuario = $fila["ID"];
		$pass = $fila["passwd"];
		$usr = $fila['user'];
		$tipoUser = $fila["RANGO"];
		if(($pass == md5($password)) && (strtolower($user) == strtolower($usr))){
			$_SESSION["ID_Usuario"] = $idUsuario;
			$_SESSION["nombre_usuario"] = $usr;
			$_SESSION["tipo_usuario"] = $tipoUser;
			$_SESSION["error"] = null;
			$_SESSION['compra'] = 0;
			header("Location: index.php");
		} else {
			print '
				<div id = "errorLogin">
					<p id = "eLTexto"> Fallo al iniciar sesión </p> <p id = "eLExplicacion"> Nombre de usuario o contraseña incorrectos. Vuelve a intentarlo. </p>
				</div>
			';
		}
		
	}
?>
<!DOCTYPE HTML>
<html lang = "es">
	<head>
		<meta charset = "utf-8">
		<title> El Ejército Negro - Login </title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link rel='stylesheet' href = "css/login.css" type = "text/css">
	</head>
	<body>
		<?PHP
			if(empty($_SESSION["nombre_usuario"])){
			print '
			<section id = "contenedor">
				<form id = "formulario" method = "post">
					<h3 id = "titulo"> Inicio de sesión </h3>
					<input id = "nombreUsuario" type = "text" name = "username" placeholder = "Nombre de Usuario" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder =\'Nombre de Usuario\'"><br><br>
					<input id = "contraUsuario" type = "password" name = "password" placeholder = "Contraseña" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder =\'Contraseña\'"> <br><br>
					<input id = "botonLogin" type = "submit" name = "login" value = "Iniciar sesion"><br><br><br>
					<button id = "redirRegister"><a href = "register.php"> ¿No tienes cuenta? ¡Regístrate! </a></button>
				</form>
			</section>';
			} else {
				print '<section id = "contenedor">
					<div id = "logueado">
						<p> Ya has iniciado sesión. </p> <p id = "explicacion"> No puedes acceder a esta página porque ya iniciaste sesión. Regresa al inicio. </p><button id = "botonVolver"><a href = "index.php"> Volver </a></button>
					</div>
				</section>';
			}
		?>
	</body>
</html>