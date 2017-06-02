<?PHP
// Versión del userPanel.php para el usuario normal

	// --------------------------------------------------------------------------------------------- //
	// Se recoge la variable de enlace 'Exito' en caso de haberlo, lo cual imprime un mensaje u otro //
	// --------------------------------------------------------------------------------------------- //

	if(isset($_GET['exito'])){
		$exito = $_GET["exito"];
		if($exito == 1){
			print '<div id = "valido"><p>Nombre de usuario cambiado</p></div>';
		} else if ($exito == 2){
			print '<div id = "valido"><p>Nombre completo cambiado</p></div>';
		} else if($exito == 3){
			print '<div id = "valido"><p>Contraseña cambiada</p></div>';
		} else if($exito == 4){
			print '<div id = "valido"><p>Email cambiado</p></div>';
		} else if($exito == 5){
			print '<div id = "valido"><p>Dirección cambiada</p></div>';
		} else if($exito == 6){
			print '<div id = "valido"><p>Teléfono cambiado</p></div>';
		} else {
			print '';
		}
	}

	// ----------------------- //
	// Se imprime el documento //
	// ----------------------- //

print '
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
                    <img id = \"candado\" src = \"img/lock.png\" alt = \"lock\"> <a href = \"logout.php\"> Bienvenido, <span id = \"user\">".$_SESSION["nombre_usuario"]."</span>. Cerrar sesión </a>
                </div>
";

print '
                <div class = "active" id = "userPanel">
                    <img id = "settingsImg" src = "img/settings.png" alt = "ajustes"> <a id = "userPanelA" href = "userPanel.php"> Administración del usuario </a>
                </div>
		    </nav>
		<!-- La sección contenedor, incluye todo el contenido de la página, exceptuando el nav (barra de navegación horizontal superior)-->
		<section id = "contenedor">
			<header>
				<img id = "nLogo" src = "img/nBanner.png" alt = "banner">
			</header>
			<!-- La sección contactar contiene los 3 contactar a mostrar -->
			<section id = "info">
';
                        echo '<table id = "tablaUsuarios">
						<tr>
                                    <th class = "columnas"> ID Usuario </th>
                                    <th class = "columnas"> Nombre de usuario </th>
                                    <th class = "columnas"> Nombre completo </th>
                                    <th class = "columnas"> Email </th>
                                    <th class = "columnas"> Dirección </th>
                                    <th class = "columnas"> Teléfono </th>
                                    <th class = "columnas"> Tipo de usuario </th>
                        </tr>
						';
						$usuario = mysqli_query($conexion, "SELECT * from user where ID = ".$_SESSION['ID_Usuario']."", MYSQLI_STORE_RESULT);
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
								</tr>
								';
						}
						echo '
						</table><br><br><br>
						';
print '
			</section>
			<section id = "informacion">
				 <img src = "img/infoUserPanel.png" alt = "info" style = "width: 150px; height: 150px;"> <h3> En la sección inferior puedes modificar los datos de tu cuenta </h3>
			</section>
			<section id = "usuario">
                 <article class = "modif">
                     <img src = "img/uP/1.png" alt = "1"><br><br>
					 <form method = "post">
                     <input type = "text" name = "username" placeholder = "Nombre de usuario" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder = \'Nombre de usuario\'">
                     <input class = "inputButtons" type = "submit" name = "cambiarUser" value = "Modificar">
					 </form>
					
                </article>
				<article class = "modif">
					<img src = "img/uP/2.png" alt = "2"><br><br>
					<form method = "post">
					<input type = "text" name = "fullname" placeholder = "Nombre completo" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder = \'Nombre completo\'">
                     <input class = "inputButtons" type = "submit" name = "cambiarNombre" value = "Modificar">
					 </form>
				</article>
				<article class = "modif">
					<img src = "img/uP/3.png" alt = "3"> <br><br>
					<form method = "post">
					<input type = "password" name = "password" placeholder = "Contraseña" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder = \'Contraseña\'">
					<input class = "inputButtons" type = "submit" name = "cambiarContra" value = "Modificar">
					</form>
				</article>
				<article class = "modif">
					<img src = "img/uP/4.png" alt = "4"> <br><br>
					<form method = "post">
					<input type = "text" name = "email" placeholder = "Email" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder = \'Email\'">
					<input class = "inputButtons" type = "submit" name = "cambiarEmail" value = "Modificar">
					</form>
					</article>
				<article class = "modif">
					<img src = "img/uP/5.png" alt = "5"> <br><br>
					<form method = "post">
					<input type = "text" name = "address" placeholder = "Dirección" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder = \'Dirección\'">
					<input class = "inputButtons" type = "submit" name = "cambiarDirecc" value = "Modificar">
					</form>
					</article>
					<article class = "modif">
						 <img src = "img/uP/6.png" alt = "6"><br><br>
						 <form method = "post">
						 <input type = "number" name = "telefono" placeholder = "Teléfono" onfocus = "this.placeholder = \'\'" onblur = "this.placeholder = \'Teléfono\'">
						 <input class = "inputButtons" type = "submit" name = "cambiarTlf" value = "Modificar">
						 </form>
					</article>
			</section>
						<section id = "infoPedidos">
				 <img src = "img/indexImg2.png" alt = "info" style = "width: 150px; height: 150px;"> <h3> Aquí puedes comprobar tus pedidos realizados </h3>
			</section>
			<section id = "pedidos">
';
				$usuarioActual = $_SESSION['ID_Usuario'];
				$consulta = MYSQLI_QUERY($conexion, "SELECT * FROM venta WHERE Usuario = $usuarioActual");
				$numeroPedidos = mysqli_num_rows($consulta);
				if($numeroPedidos < 1){
					print '<table id = "tablaPedidos">
				<tr>
					<th class = "columnas"> - </th>
					<th class = "columnas"> Sin pedidos </th>
					<th class = "columnas"> - </th>
				</tr>
				<tr>
					<td><p> - </p></td>
					<td><p> No tienes pedidos </p></td>
					<td><p> - </p></td>
				</tr></table>
				';
				} else {
					print '<table id = "tablaPedidos">
				<tr>
					<th class = "columnas"> Numero de pedido </th>
					<th class = "columnas"> Libros comprados </th>
					<th class = "columnas"> Precio total pedido </th>
					<th class = "columnas"> Estado </th>
				</tr>';
				
				while($fila = mysqli_fetch_array($consulta)){
					print "<tr>
								<td>".$fila['ID']."</td>
								<td>".$fila['Libros']."</td>
								<td>".$fila['Precio']." €</td>
								<td>".$fila['Estado']."</td>
							</tr>
					";
				}
					print '</table>';
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
		</section>
';
?>