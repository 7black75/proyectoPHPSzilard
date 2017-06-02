<?PHP
// Versión del autor.php para el usuario registrado normal

print '
            <nav id = "naveg">
                <ul>
                    <li><a href="index.php" >Inicio</a></li>
                    <li><a class = "active" href="#">Autor</a></li>
                    <li><a href="tienda.php">Tienda</a></li>
                    <li><a href="contacta.php">Contacta</a></li>
                </ul>
';

print "
			<div id = \"login\">
				<img id = \"candado\" src = \"img/lock.png\" alt = \"lock\"> <a href = \"logout.php\"> Bienvenido, <span id = \"user\">".$_SESSION["nombre_usuario"]."</span>. Cerrar sesión </a>
			</div>
";

print '
			<div id = "userPanel">
				<img id = "settingsImg" src = "img/settings.png" alt = "ajustes"> <a href = "userPanel.php"> Administración del usuario </a>
			</div>
		</nav>
		<!-- La sección contenedor, incluye todo el contenido de la página, exceptuando el nav (barra de navegación horizontal superior)-->
		<section id = "contenedor">
			<header>
				<img id = "nLogo" src = "img/nBanner.png" alt = "banner">
			</header>
			<section id = "autor">
				<article id = "bio">
					<img id = "imagenAutor" src = "img/autor1.jpg" alt = "autor">
					<div id = "cajaTexto">
					<p id = "parrafoAutor"> Santiago García- Clairac es escritor de literatura infantil y juvenil, conocido por ser el autor de la trilogía de fantasía El Ejército Negro (trilogía).

Nació en Mont-de-Marsan, Francia el 30 de julio de 1944.
<br><br>
Ha trabajado como creativo, desarrollando spots, cortometrajes y videoclips. Algunos de sus trabajos han recibido importantes premios. Su anuncio Avión en la Castellana para Repsol entró en el Libro Guinness de los récords por el rodaje más espectacular. Además, ha realizado los storyboards de varios largometrajes, entre los que se encuentran El penalti más largo del mundo y El club de los suicidas.<br><br> Ha sido profesor de Publicidad en el Instituto de Formación Empresarial de Madrid, durante quince años. Ha impartido clases de la asignatura de Creatividad Publicitaria en la Universidad CEADE, durante varios años.

Comenzó a publicar en 1994, centrando sus creaciones en el ámbito de la literatura infantil y la literatura juvenil de género fantástico y realista.

<br><br>Su primer libro, Maxi el aventurero, dio inicio a una colección protagonizada por el mismo personaje: Maxi y la banda de los tiburones; Maxi, presidente; Maxi el agobiado y Maxi y el malvado angelito.

También se publicaron cuatro cómics de Maxi: Maxi en Nueva York; Maxi en África; Maxi en el Amazonas y Maxi en el Polo Norte.

En 2004, obtiene el Premio Cervantes Chico.
<br><br>
Es co-creador de Festibook, Festival Transfronterizo del Literatura Juvenil. </p>
					</div>
					<img id = "imagenAutorUno" src = "img/autor2.jpg" alt = "autor">
				</article>
							<article id = "slider">
					<div class = "slides">
';
					$consulta = mysqli_query($conexion, "SELECT imagen from libros", MYSQLI_STORE_RESULT);
					while($fila = mysqli_fetch_array($consulta)){
						print '<div class = "divSlide">
							<img src = "'.$fila['imagen'].'" alt = "imagen">
						</div>
						';
					}
print '
					</div>
				</article>
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
		</section>
';

?>