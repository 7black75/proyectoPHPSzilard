<?PHP
// Versión del contacta.php para el usuario no registrado.

print'
    <nav id = "naveg">
			<ul>
				<li><a href="index.php" >Inicio</a></li>
				<li><a href="autor.php">Autor</a></li>
				<li><a class = "active" href="#">Contacta</a></li>
			</ul>
			<div id = "login">
				<img id = "candado" src = "img/lock.png" alt = "lock"> <a href = "login.php"> Iniciar sesión </a>
			</div>
		</nav>
		<!-- La sección contenedor, incluye todo el contenido de la página, exceptuando el nav (barra de navegación horizontal superior)-->
		<section id = "contenedor">
			<header>
				<img id = "nLogo" src = "img/nBanner.png" alt = "banner">
			</header>
			<!-- La sección contactar contiene los 3 contactar a mostrar -->
			<section id = "info">
				<img src = "img/contacta.png" alt = "contacta">
				<span> ¿Tienes algo que decir? ¡Escríbelo! </span>
			</section>
			<section id = "contactar">
				<form id = "formulario" method = "post">
					<input type = "text" name = "nombre" placeholder = "Nombre" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder = \'Nombre\'" REQUIRED><br>
					<input type = "text" name = "email" placeholder = "Correo electrónico" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder = \'Correo electrónico\'" REQUIRED><br>
					<textarea name = "mensaje" placeholder = "Mensaje (500 caracteres máx.)" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder = \'Mensaje (500 caracteres máx.)\'" REQUIRED></textarea><br><br>
					<input id = "subButton" type = "submit" name = "enviar" value = "Enviar">
				</form>';
					// Si se pulsa el botón enviar se ejecuta el script
					if(isset($_REQUEST['enviar'])){
						$nombre = $_REQUEST['nombre'];
						$email = $_REQUEST['email'];
						$mensaje = $_REQUEST['mensaje'];
						 if(filter_var($email, FILTER_VALIDATE_EMAIL)){
							$consulta = mysqli_query($conexion, "INSERT INTO contactar (nombre, email, mensaje) VALUES ('$nombre', '$email', '$mensaje')", MYSQLI_STORE_RESULT);
						print '<div id = "valido"><p>¡Tu mensaje ha sido enviado!</p></div>';
							}
						
					}
            print '
			</section>
			<!-- Pie de la página. Incluye mi nombre y los enlaces a la biografía del Autor (Wikipedia) y a su página oficial -->
			<footer>
				<p> SZILARD TOTH © TODOS LOS DERECHOS RESERVADOS </p>
				<!-- Div empleado para mover ambos enlaces como un conjunto -->
				<div id = "divAux">
					<a class = "link" target = "_blank" href = "https://es.wikipedia.org/wiki/Santiago_Garc%C3%ADa-Clairac"></a>
					<a class = "link" target = "_blank" href = "http://www.loslibrosdesantiago.com/"></a>
				</div>
			</footer>
		</section>';
?>