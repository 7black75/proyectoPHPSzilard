<?PHP
// Versión del index.php para usuarios normales

print'
<nav id = "naveg">
			<ul>
				<li><a class = "active" href="#" >Inicio</a></li>
				<li><a href="autor.php">Autor</a></li>
				<li><a href="tienda.php">Tienda</a></li>
				<li><a href="contacta.php">Contacta</a></li>
			</ul>
			<div id = "login">
            ';
            print"
				<img id = \"candado\" src = \"img/lock.png\" alt = \"lock\"> <a href = \"logout.php\"> Bienvenido, <span id = \"user\">".$_SESSION["nombre_usuario"]."</span>. Cerrar sesión </a>
            ";
            print '
			</div>
			<div id = "userPanel">
				<img id = "settingsImg" src = "img/settings.png" alt = "ajustes"> <a href = "userPanel.php"> Administración del usuario </a>
			</div>
		</nav>
		<!-- La sección contenedor, incluye todo el contenido de la página, exceptuando el nav (barra de navegación horizontal superior)-->
		<section id = "contenedor">
			<header>
				<img id = "nLogo" src = "img/nBanner.png" alt = "banner">
			</header>
			<!-- La sección libros contiene los 3 libros a mostrar -->
			<section id = "libros">
				<!-- Primer libro -->
				<article class = "libro">
					<div id = "imgLibroUno"></div><br>
					<hr><p class = "nombreLibro"> El Ejército Negro - I. El Reino de los Sueños </p><hr>
					<p class = "parrafoLibro"> Arturo Adragón, un muchacho de catorce años, lleva una “A” marcada en su rostro, así como una serie de letras en el resto del cuerpo, lo que le hace ser objeto de burlas en el instituto. En La Fundación, su casa, Arturo se refugia en un ambiente lleno de tesoros medievales: espadas, escudos, pergaminos y libros que guardan secretos sobre su origen y el de su familia. Pero La Fundación está en peligro, alguien se quiere apropiar de todos estos tesoros y de grandes secretos que abren la puerta a los sueños de Arturo. Se trata de otro mundo emplazado en el siglo X, en plena Edad Media, otra dimensión donde los enemigos de Arturo son temibles dragones y reyes asesinos.</p>
				</article>
				<!-- Segundo libro -->
				<article class = "libro">
					<div id = "imgLibroDos"></div><br>
					<hr><p class = "nombreLibro"> El Ejército Negro - II. El Reino de la Oscuridad </p><hr>
					<p class = "parrafoLibro"> Continúan las aventuras de Arturo Adragón, tanto en el presente, donde tendrá que hacer frente a oscuros personajes que pretenden arrebatarle tanto a él como a su padre La Fundación del Libro donde viven; como en el pasado, donde sigue siendo un valeroso caballero que guía al Ejército Negro en su camino hacia la victoria difinitiva sobre las fuerzas del perverso Demónicus.</p>
				</article>
				<!-- Tercer libro -->
				<article class = "libro">
					<div id = "imgLibroTres"></div><br>
					<hr><p class = "nombreLibro"> El Ejército Negro - III. El Reino de la Luz</p><hr>
					<p class = "parrafoLibro"> Nuestro joven amigo está pasando difíciles momentos, tanto en el presente como en el pasado. Aún no ha desvelado los misterios que se ciernen sobre su origen y que comienzan en la noche de su nacimiento. Al lado de Arturo Adragón estará, como siempre, su fiel escudero Metáfora, que le ayudará en los dos mundos, tan distintos pero tan coincidentes en sus peligros y amenazas.<br> ¿Logrará Arturo superar las dificultades y encontrar el camino hacia la Luz? <br>Una novela que hará temblar los cimientos de la realidad. </p>
				</article>
			</section>
			<section id = "secciones">
				<!-- Usando iconos de bootstrap para la información de las secciones -->
				<article class = "elemento"> <!-- Autor -->
					<a href = "autor.php">
					 <img src = "img/indexImg1.png" alt = "autor"></a>
					 <p> ¿Quieres saber más del escritor del \'Ejército Negro\'? ¡Echa un vistazo a la sección \'Autor\'! Puedes visitar su página oficial desde el pie de esta página </p>
				</article>
				<article class="elemento"> <!-- Tienda -->
					<a href = "tienda.php">
					 <img src = "img/indexImg2.png" alt = "tienda"> </a>
					 <p> Si te gusta la trilogía y/o te gustaría adquirir algún otro libro de Santiago, visita la sección \'Tienda\' </p>
				</article>
				<article class="elemento"> <!-- Contacto -->
					 <a href = "contacta.php">
					 <img src = "img/indexImg3.png" alt = "contacta"></a>
					 <p> ¿Sabías que hay una sección de contacto? Si tienes cualquier sugerencia, duda o queja, escríbeme unas líneas, las leeré :) </p> 
				</article>
			</section>
			<section id = "suscribete">
				<form method="post" name="suscribir" id = "formulario">
				  <div class="header">
					 <p>SUSCRÍBETE</p>
				  </div>
				  <div class="description">
					<p>¿Deseas recibir las últimas noticias sobre el autor? ¡Suscríbete ahora!</p>
				  </div>
				  <div class="input">
					<input type="text" class="button" id="email" name="email" placeholder="NOMBRE@EJEMPLO.COM" REQUIRED>
					<input onclick = "mensaje()" type="submit" class="button" id="submit" name = "enviar" value="SUSCRIBETE">
				  </div>  
				</form>
';
				if(isset($_REQUEST['enviar'])){
				if((filter_var($email, FILTER_VALIDATE_EMAIL)) && ($numFilas == 0)){
						$consulta = mysqli_query($conexion, "INSERT INTO suscribir (email) VALUES ('$email')", MYSQLI_STORE_RESULT);
						print '<div id = "valido"><p>¡Te has suscrito correctamente!</p></div>';
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