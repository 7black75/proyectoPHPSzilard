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

	// --------------------------------------- //
	// Acción ejecutada por el botón registrar //
	// --------------------------------------- //

	if(isset($_REQUEST['register'])){
		$user      		= 		$_REQUEST['username'];
		$password  		= 		$_REQUEST['password'];
		$fullName  		= 		$_REQUEST['fullname'];
		$email     		= 		$_REQUEST['email'];
		$direccion 		= 		$_REQUEST['address'];
		$tlf       		= 		$_REQUEST['telefono'];
		$consulta  		= 		mysqli_query($conexion, "SELECT user FROM user WHERE user like '$user'", MYSQLI_STORE_RESULT); 
		$numFilas  		= 		mysqli_num_rows($consulta);
		if($numFilas > 0){
			$_SESSION["error"] = 1;
			header("location: /proyecto/error.php?error=3");
		} else {
			$resultadoConsulta = mysqli_query($conexion, "INSERT INTO user (user, passwd, NOMBRE, EMAIL, DIRECCION, TELEFONO, RANGO) VALUES ('".$user."','".md5($password)."', '".$fullName."', '".$email."', '".$direccion."', '".$tlf."', 'USUARIO')", MYSQLI_USE_RESULT) or die ("Fallo en la consulta");
			header("Location: /proyecto/login.php?exito=true");
			exit();
		}
	}
?>
<!DOCTYPE HTML>
<html lang = "es">
	<head>
		<meta charset = "utf-8">
		<title> El Ejército Negro - Registro </title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link rel = "stylesheet" href = "css/register.css" type = "text/css">
	</head>
	<body>
		<?PHP
			// ----------------------------------------------------------------- //
			// Generación del documento y validación de campos a través de HTML5 //
			// ----------------------------------------------------------------- //

			print '<section id = "contenedor">';
			print '<form id = "formulario" method = "post">
					<h3 id = "titulo"> Registro </h3>
				   <input id = "nombreUsuario" pattern = "[a-zA-Z0-9_-]{5,10}"type = "text" name = "username" REQUIRED placeholder = "Nombre de Usuario" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder =\'Nombre de Usuario\'"><br><br>
				   <input id = "contraUsuario" pattern = "(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%*]{8,12}"type = "password" name = "password" REQUIRED placeholder = "Contraseña" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder =\'Contraseña\'"> <br><br>
				   <input id = "nombreCompleto" pattern = "[a-zA-Z ]{3,50}"type = "text" name = "fullname" REQUIRED placeholder = "Nombre Completo" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder =\'Nombre Completo\'"> <br><br>
				   <input id = "email" type = "email" name = "email" REQUIRED placeholder = "Correo electrónico" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder =\'Correo electrónico\'"> <br><br>
				   <input id = "direccion" type = "text" pattern = "[0-9A-Za-z ºª\/,]{5,50}" name = "address" REQUIRED placeholder = "Dirección" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder =\'Dirección\'"> <br><br>
				   <input id = "tlf" type = "number" pattern = "(\d){9}"name = "telefono" REQUIRED placeholder = "Teléfono" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder =\'Teléfono\'"> <br><br>
				   <input id = "botonLogin" type = "submit" name = "register" value = "Registro"><br><br>
				   </form>
				</section>';
		?>
	</body>
</html>