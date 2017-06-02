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

	// -------------------------------------------------- //
	// Acción ejecutada por el botón 'Actualizar Usuario' //
	// -------------------------------------------------- //

	if(isset($_REQUEST['modifyUser'])){
		$idUser = $_REQUEST['iduser'];
		$username = $_REQUEST['username'];
		$fullname = $_REQUEST['fullname'];
		$email = $_REQUEST['email'];
		$address = $_REQUEST['address'];
		$tlf = $_REQUEST['tlf'];
		$rank = $_REQUEST['rank'];
		if((empty($idUser)) || (empty($username)) || (empty($fullname)) || (empty($email)) || (empty($address)) || (empty($tlf)) || (empty($rank))){
			$_SESSION['error'] = 1;
			header('location: /proyecto/error.php?error=15');
			exit();
		} else {
			$consultaUpdate = mysqli_query($conexion, "UPDATE user SET user = '".$username."', NOMBRE = '".$fullname."', EMAIL = '".$email."', DIRECCION = '".$address."', TELEFONO = '".$tlf."', RANGO = '".$rank."' WHERE ID = ".$idUser."") or die ("Fallo");
			header('location: /proyecto/adminPanel.php?exito=1');
		}
	}

	// ------------------------------------------------- //
	// Acción ejecutada por el boton 'Borrar usuario(s)' //
	// ------------------------------------------------- //

	if(isset($_REQUEST['deleteUser'])){
		$eliminar = $_REQUEST['borrarUsuario'];
		if($eliminar == null){
			$_SESSION["error"] = 1;
			header("location: /proyecto/error.php?error=16");
		} else {
			foreach($eliminar as $eli){
				$consultaBorrar = mysqli_query($conexion, "DELETE FROM user where ID = $eli", MYSQLI_STORE_RESULT) or die ("No se ha podido borrar el usuario");
				header("location: /proyecto/adminPanel.php?exito=2");
			}
		}
	}

	// ----------------------------------------------- //
	// Acción ejecutada por el botón 'Borrar libro(s)' //
	// ----------------------------------------------- //

	if(isset($_REQUEST['deleteBook'])){
		$eliminar = $_REQUEST['borrarLibro'];
		if($eliminar == null){
			$_SESSION['error'] = 1;
			header("location: /proyecto/error.php?error=17");
		} else {
			foreach($eliminar as $eli){
				$consultaBorrar = mysqli_query($conexion, "DELETE FROM libros where ID = $eli", MYSQLI_STORE_RESULT) or die ("No se ha podido borrar el libro");
				header("location: /proyecto/adminPanel.php?exito=3");
		}
	}
	}

	// ------------------------------------------------ //
	// Acción ejecutada por el botón 'Actualizar libro' //
	// ------------------------------------------------ //

	
	if(isset($_REQUEST['modifyBook'])){
		$idLibro = $_REQUEST['idbook'];
		$bookname = $_REQUEST['bookname'];
		$bookyear = $_REQUEST['bookyear'];
		$bookprice = $_REQUEST['bookprice'];
		$booktldr = $_REQUEST['booktldr'];
		if((empty($idLibro)) || (empty($bookname)) || (empty($bookyear)) || (empty($bookprice)) || (empty($booktldr))){
			$_SESSION['error'] = 1;
			header("location: /proyecto/error.php?error=19");
		} else {
			$consultaUpdate = mysqli_query($conexion, "UPDATE libros SET nombre = '".$bookname."', anyo = '".$bookyear."', precio = '".$bookprice."', sinopsis = '".$booktldr."' WHERE ID = ".$idLibro."", MYSQLI_STORE_RESULT) or die ("Fallo al actualizar libro");
			header("location: /proyecto/adminPanel.php?exito=4");
		}
	}

	// ------------------------------------------------- //
	// Acción ejecutada por el botón 'Actualizar pedido' //
	// ------------------------------------------------- //
	if(isset($_REQUEST['modifyPedido'])){
		$idpedido = $_REQUEST['idPedido'];
		$estado = $_REQUEST['status'];
		if((empty($idpedido)) || (empty($estado))){
			$_SESSION['error'] = 1;
			header("location: /proyecto/error.php?error=18");
		} else {
			$consultaUpdate = mysqli_query($conexion, "UPDATE venta SET Estado = '".$estado."' where ID = ".$idpedido."") or die ("Fallo al actualizar pedido");
			header("location: /proyecto/adminPanel.php?exito=5");
		}
	}
?>
<!DOCTYPE HTML>
<?PHP
	// --------------------------------------------------------------------------------------------- //
	// Se recoge la variable de enlace 'Exito' en caso de haberlo, lo cual imprime un mensaje u otro //
	// --------------------------------------------------------------------------------------------- //

	if(isset($_GET['exito'])){
		$exito = $_GET['exito'];
		if($exito == 1){
			print '<div id = "valido"><p>Usuario actualizado</p></div>';
		} else if ($exito == 2){
			print '<div id = "valido"><p>Usuario(s) eliminado(s) con éxito</p></div>';
		} else if ($exito == 3){
			print '<div id = "valido"><p>Libro(s) eliminado(s) con éxito</p></div>';
		} else if ($exito == 4){
			print '<div id = "valido"><p>Libro actualizado</p></div>';
		} else if ($exito == 5){
			print '<div id = "valido"><p>Estado del pedido actualizado</p></div>';
		}
}
	
if((!empty($_SESSION['nombre_usuario'])) && ($_SESSION['tipo_usuario']) == "ADMINISTRADOR"){
print '
<html lang = "es">
	<head>
		<title> Panel de administración </title>
		<meta charset = "utf-8">
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<link rel=\'stylesheet\' href = "css/adminPanel.css" type = "text/css">
		<script src="js/jquery.min.js"></script>
		<script type = "text/javascript" src = "js/JQueryAdminPanel.js">
		<script type = "text/javascript" src = "js/scriptBarra.js"></script>
	</head>
	<body>
            <nav id = "naveg">
                <ul>
                    <li><a href="index.php" >Inicio</a></li>
                    <li><a href="autor.php">Autor</a></li>
                    <li><a href="tienda.php">Tienda</a></li>
                    <li><a href="contacta.php">Contacta</a></li>
                </ul>
';
print "
                <div id = \"login\">
                    <img id = \"candado\" src = \"img/lock.png\" alt = \"lock\"> <a href = \"logout.php\"> Bienvenido, <span id = \"admin\">".$_SESSION["nombre_usuario"]."</span>. Cerrar sesión </a>
                </div>
";

print '
                <div id = "userPanel">
                    <img id = "settingsImg" src = "img/settings.png" alt = "ajustes"> <a id = "userPanelA" href = "userPanel.php"> Administración del usuario </a>
                </div>
		    </nav>
		<section id = "contenedor">
			<header>
				<img id = "nLogo" src = "img/nBanner.png" alt = "banner">
			</header>
			<section id = "contenido">
			<article class = "informacionUno">
				 <img src = "img/infoUserPanel.png" alt = "info" style = "width: 150px; height: 150px;"> <h3> Bienvenido al Panel de Administración. Elige la sección de la página que quieras gestionar. </h3>
			</article>
			<article id = "botonesAdmin">
				<div class = "tipoPanel">
					<a href = "aPUsuarios.php" id = "adminPanelUsers">Administrar usuarios</a>
					<p class = "parrafoTP"> En este panel podrás administrar los usuarios registrados en la página. Puedes borrar usuarios o modificar sus datos. </p>
				</div>
				<div class = "tipoPanel">
					<a href = "aPLibros.php" id = "adminPanelBooks">Administrar libros</a>
					<p class = "parrafoTP"> Aquí podrás administrar los libros del autor. Puedes modificar los ya existentes, eliminar libros o bien añadir más. </p>
				</div>
				<div class = "tipoPanel">
					<a href = "aPPedidos.php" id = "adminPanelPedidos">Administrar pedidos</a>
					<p class = "parrafoTP"> En el panel Pedidos podrás administrar estos, de forma que puedes actualizar su estado. \'Pendiente\' o \'Entregado\'. </p>	
				</div>
			</article>
';
/*
				<article class = "informacionUno">
					 <img src = "img/infoUserPanel.png" alt = "info" style = "width: 150px; height: 150px;"> <h3> En la sección inferior puedes modificar los usuarios de la página </h3>
				</article>
				<section id = "usuarios">
					<article id = "userTable">
';
					echo '<form id = "userForm" method = "post"><table id = "tablaUsuarios">
							<tr>
										<th class = "columnas"> ID Usuario </th>
										<th class = "columnas"> Nombre de usuario </th>
										<th class = "columnas"> Nombre completo </th>
										<th class = "columnas"> Email </th>
										<th class = "columnas"> Dirección </th>
										<th class = "columnas"> Teléfono </th>
										<th class = "columnas"> Tipo de usuario </th>
										<th class = "columnas"> Borrar </th>
							</tr>
							';
							$usuario = mysqli_query($conexion, "SELECT * from user", MYSQLI_STORE_RESULT);
							while ($fila = mysqli_fetch_array($usuario)) {
								echo '
									<tr>
										<td>'.$fila['ID'].'</td>
										<td>'.$fila['user'].'</td>
										<td>'.$fila['NOMBRE'].'</td>
										<td>'.$fila['EMAIL'].'</td>
										<td>'.$fila['DIRECCION'].'</td>
										<td>'.$fila['TELEFONO'].'</td>
										<td>'.$fila['RANGO'].'</td>
										<td class = "checkBorrar"><input type = "checkbox" name = "borrarUsuario[]" value = '.$fila['ID'].'></td>
									</tr>
									';
							}
							echo '
							</table>
							<br><br>
							<input id = "botonBorrar" type = "submit" name = "deleteUser" value = "Eliminar Usuario(s)">
							</form>
							<br>
							';
							print '
						</article>
						<article id = "userModify">
							<form id = "formTabla" method = "post">
								<table id = "addTabla">
										<tr>
											<th class = "columnas"> ID Usuario </th>
											<th class = "columnas"> Nombre de usuario </th>
											<th class = "columnas"> Nombre completo </th>
											<th class = "columnas"> Email </th>
											<th class = "columnas"> Dirección </th>
											<th class = "columnas"> Teléfono </th>
											<th class = "columnas"> Tipo de usuario </th>
										</tr>
										<tr>
											<td><input class = "tablaInput" type = "number" name = "iduser" placeholder = "ID Usuario"></td>
											<td><input class = "tablaInput" type = "text" name = "username" placeholder = "Nombre Usuario"></td>
											<td><input class = "tablaInput" type = "text" name = "fullname" placeholder = "Nombre"></td>
											<td><input class = "tablaInput" type = "email" name = "email" placeholder = "Correo"></td>
											<td><input class = "tablaInput" type = "text" name = "address" placeholder = "Dirección"></td>
											<td><input class = "tablaInput" type = "number" name = "tlf" placeholder = "Teléfono"></td>
											<td>
												<select class = "tablaInput" name = "rank">
													<option value = "" SELECTED>Rango</option>
													<option value = "ADMINISTRADOR">Administrador</option>
													<option value = "USUARIO">Usuario</option>
												</select>
											</td>
										</tr>
								</table>
								<input id = "botonModify" type = "submit" name = "modifyUser" value = "Actualizar Usuario">
							</form>
						</article>
				</section>
				<article class = "informacionUno">
					 <img src = "img/infoUserPanel.png" alt = "info" style = "width: 150px; height: 150px;"> <h3> En la sección inferior puedes modificar los libros de la página </h3>
				</article>
				<section id = "libros">
					<article id = "bookTable">
';
						echo '<form id = "bookForm" method = "post"><table id = "tablaLibros">
							<tr>
										<th class = "columnas"> ID Libro </th>
										<th class = "columnas"> Nombre </th>
										<th class = "columnas"> Año publicación </th>
										<th class = "columnas"> Precio </th>
										<th class = "columnas"> Resumen </th>
										<th class = "columnas"> Borrar </th>
							</tr>
							';
							$usuario = mysqli_query($conexion, "SELECT * from libros", MYSQLI_STORE_RESULT);
							while ($fila = mysqli_fetch_array($usuario)) {
								echo '
									<tr>
										<td>'.$fila['ID'].'</td>
										<td>'.$fila['nombre'].'</td>
										<td>'.$fila['anyo'].'</td>
										<td>'.$fila['precio'].'</td>
										<td>'.$fila['sinopsis'].'</td>
										<td class = "checkBorrar"><input type = "checkbox" name = "borrarLibro[]" value = '.$fila['ID'].'></td>
									</tr>
									';
							}
							echo '
							</table>
							<br><br>
							<input id = "botonBorrar" type = "submit" name = "deleteBook" value = "Eliminar Libro(s)">
							</form>
							<br>
							';
	print '
						</article>
						<article id = "bookManage">
							<form id = "formTabla" method = "post">
								<table id = "addTabla">
										<tr>
											<th class = "columnas"> ID Libro </th>
											<th class = "columnas"> Nombre </th>
											<th class = "columnas"> Año publicación </th>
											<th class = "columnas"> Precio </th>
											<th class = "columnas"> Resumen </th>
										</tr>
										<tr>
											<td><input class = "tablaInput" type = "number" name = "idbook" placeholder = "ID Libro"></td>
											<td><input class = "tablaInput" type = "text" name = "bookname" placeholder = "Nombre Libro"></td>
											<td><input class = "tablaInput" type = "number" name = "bookyear" placeholder = "Año publicación"></td>
											<td><input class = "tablaInput" type = "text" name = "bookprice" placeholder = "Precio"></td>
											<td><input class = "tablaInput" type = "text" name = "booktldr" placeholder = "Resumen"></td>
										</tr>
								</table>
								<input id = "botonModify" type = "submit" name = "modifyBook" value = "Actualizar Libro">
								
							</form>
						</article>
				</section>
				<article class = "informacionUno">
					 <img src = "img/infoUserPanel.png" alt = "info" style = "width: 150px; height: 150px;"> <h3> En la sección inferior puedes modificar los pedidos de la página </h3>
				</article>
				<section id = "pedidos">
					<article id = "pedidosTable">
';
					echo '<form id = "pedidosForm" method = "post"><table id = "tablaPedidos">
							<tr>
										<th class = "columnas"> ID Pedido </th>
										<th class = "columnas"> ID Usuario </th>
										<th class = "columnas"> Nombre Usuario </th>
										<th class = "columnas"> Libros comprados </th>
										<th class = "columnas"> Precio pedido </th>
										<th class = "columnas"> Estado </th>
							</tr>
							';
							$usuario = mysqli_query($conexion, "SELECT v.ID, v.Usuario, u.user as 'Nombre usuario', v.Libros, v.Precio, v.Estado FROM venta v inner join user u on u.ID = v.Usuario ORDER BY v.ID", MYSQLI_STORE_RESULT);
							while ($fila = mysqli_fetch_array($usuario)) {
								echo '
									<tr>
										<td>'.$fila['ID'].'</td>
										<td>'.$fila['Usuario'].'</td>
										<td>'.$fila['Nombre usuario'].'</td>
										<td>'.$fila['Libros'].'</td>
										<td>'.$fila['Precio'].' €</td>
										<td>'.$fila['Estado'].'</td>
									</tr>
									';
							}
							echo '
							</table>
							</form>
							<br>
							';
print '
					</article>
					<article id = "confirmarPedidos">
						<form id = "formTabla" method = "post">
								<table id = "addTabla">
										<tr>
											<th class = "columnas"> ID Pedido </th>
											<th class = "columnas"> Estado </th>
										</tr>
										<tr>
											<td><input class = "tablaInput" type = "number" name = "idPedido" placeholder = "ID Pedido"></td>
											<td>
												<select class = "tablaInput" name = "status">
													<option value = "" SELECTED>Estado</option>
													<option value = "Entregado">Entregado</option>
													<option value = "Pendiente">Pendiente</option>
												</select>
											</td>
										</tr>
								</table>
								<input id = "botonModify" type = "submit" name = "modifyPedido" value = "Actualizar estado del pedido">
								
							</form>
					</article>
				</section>
*/
print '
			</section>
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
';
} else {
	header('location: /proyecto/403.html'); // Sólo un administrador puede acceder a esta página. Se evita el acceso ilegítimo.
	exit();
}
?>