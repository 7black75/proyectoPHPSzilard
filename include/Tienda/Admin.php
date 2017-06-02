<?PHP
	// ------------------------------------------------------------------ //
	// Adquiere el valor de la variable "exito" enviada desde carrito.php //
	// ------------------------------------------------------------------ //

	if(isset($_GET['exito'])){
		$exito = $_GET["exito"];
		if($exito == 1){
			print '<div id = "valido"><p>Compra finalizada. Revisa tus pedidos en el panel de usuario.</p></div>';
		} else if ($exito == 2) {
			print '<div id = "valido"><p>Carrito vaciado con exito.</p></div>';
		} else {
			print '';
		}
	}

	// ----------------------- //
	// Se imprime el documento //
	// ----------------------- //

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
		<!-- La sección contenedor, incluye todo el contenido de la página, exceptuando el nav (barra de navegación horizontal superior)-->
		<section id = "contenedor">
			<header>
				<img id = "nLogo" src = "img/nBanner.png" alt = "banner">
			</header>
			<section id = "informacion">
				<img src = "img/indexImg2.png" alt = "info" style = "width: 150px; height: 150px;"> <h3> Aquí podrás adquirir todos los libros de Santiago. ¡Echa un vistazo! </h3>
			</section>
			<section id = "tienda">
			<article id = "criterio">
				<form id = "formCriterio" method = "post"><span id = "eligeCriterio">Elige un criterio de búsqueda:</span><br> <select id = "comboCriterio" name = "criterio">
					<option value="TODO" SELECTED>TODOS LOS LIBROS</option>
					<option value="nombre">TITULO</option>
					<option value="anyo">AÑO PUBLICACION</option>
					<option value="precio">PRECIO</option>
					<option value="sinopsis">RESUMEN</option>
				</select> <input id = "campoCriterio" type = "text" name = "busqueda" placeholder = "Palabras a buscar" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder = \'Palabras a buscar\'"> <br><br> <input id = "botonCriterio" type = "submit" name = "buscar" value = "Buscar"><br><br><span id = "user"> <a id = "anclaTienda"></a>* Por defecto se muestran todos los libros de forma paginada</span> </form>
			</article>
			
			
';
					// Según el criterio elegido, se imprime la tienda
						
					if(!isset($_REQUEST['buscar'])){
						$productos = mysqli_query($conexion, "SELECT * FROM libros LIMIT $pag, $limite", MYSQLI_STORE_RESULT);
						print"
								<section id = \"paginacion\">
									<a id = \"anterior\" href=\"?pag=".($pag-4)."#anclaTienda\">Anterior</a> <span id = \"paginaActual\"> | Página: ".$paginaActual." | </span> <a id = \"siguiente\" href = \"?pag=".($pag+4)."#anclaTienda\">Siguiente</a>
								</section>
							";
						include('printTienda.php');
						print"
								<section id = \"paginacion\">
									<a id = \"anterior\" href=\"?pag=".($pag-4)."#anclaTienda\">Anterior</a> <span id = \"paginaActual\"> | Página: ".$paginaActual." | </span> <a id = \"siguiente\" href = \"?pag=".($pag+4)."#anclaTienda\">Siguiente</a>
								</section>
						";
					} else if(isset($_REQUEST['buscar'])){
						
						$busqueda = $_REQUEST['busqueda'];
						$criterio = $_REQUEST['criterio'];
						if($criterio == "TODO"){
							$pag = 0;
							print"
								<section id = \"paginacion\">
									<a id = \"anterior\" href=\"?pag=".($pag-4)."#anclaTienda\">Anterior</a> <span id = \"paginaActual\"> | Página: ".$paginaActual." | </span> <a id = \"siguiente\" href = \"?pag=".($pag+4)."#anclaTienda\">Siguiente</a>
								</section>
							";
							$productos = mysqli_query($conexion, "SELECT * FROM libros LIMIT $pag, $limite", MYSQLI_STORE_RESULT);
							include('printTienda.php');
							print"
								<section id = \"paginacion\">
									<a id = \"anterior\" href=\"?pag=".($pag-4)."#anclaTienda\">Anterior</a> <span id = \"paginaActual\"> | Página: ".$paginaActual." | </span> <a id = \"siguiente\" href = \"?pag=".($pag+4)."#anclaTienda\">Siguiente</a>
								</section>
							";
						} else {
							if($criterio == 'anyo'){
								if(preg_match('/^(\d){4}$/', $busqueda)){
									$productos = mysqli_query($conexion, "SELECT * FROM libros WHERE $criterio like '%".$busqueda."%'", MYSQLI_STORE_RESULT) or die ("fallo");
									include('printTienda.php');
								} 
							} else if ($criterio == 'precio'){
								if(preg_match('/^[\d.]{0,5}$/', $busqueda)){
									$productos = mysqli_query($conexion, "SELECT * FROM libros WHERE $criterio like '".$busqueda."'", MYSQLI_STORE_RESULT) or die ("fallo");
									include('printTienda.php');
								} 
							} else {
								$productos = mysqli_query($conexion, "SELECT * FROM libros WHERE $criterio like '%".$busqueda."%'", MYSQLI_STORE_RESULT) or die ("fallo");
								include('printTienda.php');
							}
							

					}
					}
					print '<a href = "adminPanel.php">
			<button id = "adminPanelTab">
				<img id = "adminIcon" src = "img/adminIcon.png" alt = "adminicon"><p id = "aPText"> Administración </p>
			</button>
			</a>';
?>