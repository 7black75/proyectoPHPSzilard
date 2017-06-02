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

    // -------------------------------------- //
    // Acción ejecutada por el botón 'Buscar' //
    // -------------------------------------- //


    // ------------------------------ //
    // Configuración de la paginación //
    // ------------------------------ //

    $limite = 4;
	$paginaActual = 1;
	$consultaDos = mysqli_query($conexion, "SELECT * from user", MYSQLI_STORE_RESULT);
	$numFilasDos = mysqli_num_rows($consultaDos);
	$numFilasAux = $numFilasDos-2;
	if(isset($_GET['pag'])){
	$pag = $_GET['pag'];
	switch($pag){
		case ($pag<0):
			$paginaActual = 1;
			$pag = 0;
			break;
		case ($pag == 0):
			$paginaActual = 1;
			break;
		case (($pag>0) && ($pag<$numFilasAux)):
			$paginaActual = $pag/$limite+1;
			break;
		case(($pag>0) && ($pag==$numFilasAux)):
			$paginaActual = $pag/$limite+1;
			break;
		case (($pag>=$numFilasDos)):
			header("location: /proyecto/aPUsuarios.php?pag=".($numFilasDos-2)."");
			$paginaActual = $pag/$limite+1;
			break;
	}
} else {
	$pag = 0;
	$paginaActual = 1;
}

?>
<!DOCTYPE HTML>
<?PHP
    print "
        <html lang = \"es\">
            <head>
                <meta charset = \"utf-8\">
                <title> Administración de Usuarios </title>
                <link rel='stylesheet' href = \"css/ComunPaneles.css\" type = \"text/css\">
                <link rel='stylesheet' href = \"css/APUser.css\" type = \"text/css\">
            </head>
            <body>
                <div id = \"barraSuperior\">
                    <span class = \"superiorSpanNormal\"> Bienvenido/a </span><span class = \"superiorSpanRango\">".$_SESSION['nombre_usuario']."</span><span class = \"superiorSpanNormal\"> - </span><a id = \"enlaceSuperior\" href = \"/proyecto/adminPanel.php\"> Volver al panel de administrador </a>
                </div>
                <header class = \"informacionUno\">
                      <img src =  \"img/infoUserPanel.png\" alt = \"info\" style = \"width: 150px; height: 150px;\"> <h3> Este es el panel de Administración de Usuarios. </h3>
                </header>
                <section id = \"contenedor\">
                    <section id = \"usuarios\">
                        <article id = \"criterio\">
                            <form id = \"formCriterio\" method = \"post\"><span id = \"eligeCriterio\">Selecciona un usuario para la búsqueda:</span><br> <select id = \"comboCriterio\" name = \"criterio\">
                                <option value=\"TODO\" SELECTED>TODOS LOS USUARIOS</option>
";
                            $consultaUsuarios = mysqli_query($conexion, "SELECT user from user", MYSQLI_STORE_RESULT);
                            while($filaUsuarios = mysqli_fetch_array($consultaUsuarios)){
                                echo "<option value = ".$filaUsuarios['user'].">".$filaUsuarios['user']."</option>";
                            }
print "
                            </select> 
                         <br><br> <input id = \"botonCriterio\" type = \"submit\" name = \"buscar\" value = \"Buscar\"><br><br><span id = \"user\"> <a id = \"anclaTienda\"></a>* Por defecto se muestran todos los usuarios de forma paginada</span> </form>
		            	</article>
				    	<article id = \"userTable\">
";
                        if(!isset($_REQUEST['buscar'])){
print "
                        <section id = \"paginacion\">
									<a id = \"anterior\" href=\"?pag=".($pag-4)."\">Anterior</a> <span id = \"paginaActual\"> | Página: ".$paginaActual." | </span> <a id = \"siguiente\" href = \"?pag=".($pag+4)."\">Siguiente</a>
						</section>
                            <form id = \"userForm\" method = \"post\"><table id = \"tablaUsuarios\">
                                <tr>
                                            <th class = \"columnas\"> ID Usuario </th>
                                            <th class = \"columnas\"> Nombre de usuario </th>
                                            <th class = \"columnas\"> Nombre completo </th>
                                            <th class = \"columnas\"> Email </th>
                                            <th class = \"columnas\"> Dirección </th>
                                            <th class = \"columnas\"> Teléfono </th>
                                            <th class = \"columnas\"> Tipo de usuario </th>
                                            <th class = \"columnas\"> Borrar </th>
                                </tr>
";
                                $usuario = mysqli_query($conexion, "SELECT * from user LIMIT $pag, $limite", MYSQLI_STORE_RESULT);
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
print "
                                    </table>
                                    <br><br>
                                    <input id = \"botonBorrar\" type = \"submit\" name = \"deleteUser\" value = \"Eliminar Usuario(s)\">
                                </form>
								<section id = \"paginacion\">
									<a id = \"anterior\" href=\"?pag=".($pag-4)."#anclaTienda\">Anterior</a> <span id = \"paginaActual\"> | Página: ".$paginaActual." | </span> <a id = \"siguiente\" href = \"?pag=".($pag+4)."#anclaTienda\">Siguiente</a>
								</section>
";
                        } else {
                            print "
                            <form id = \"userForm\" method = \"post\"><table id = \"tablaUsuarios\">
                                <tr>
                                            <th class = \"columnas\"> ID Usuario </th>
                                            <th class = \"columnas\"> Nombre de usuario </th>
                                            <th class = \"columnas\"> Nombre completo </th>
                                            <th class = \"columnas\"> Email </th>
                                            <th class = \"columnas\"> Dirección </th>
                                            <th class = \"columnas\"> Teléfono </th>
                                            <th class = \"columnas\"> Tipo de usuario </th>
                                            <th class = \"columnas\"> Borrar </th>
                                </tr>
";
                                
                                $criterio = $_REQUEST['criterio'];
                                if($criterio == "TODO"){
                                    $usuario = mysqli_query($conexion, "SELECT * from user", MYSQLI_STORE_RESULT);
                                } else {
                                    $usuario = mysqli_query($conexion, "SELECT * from user where user like '".$criterio."'", MYSQLI_STORE_RESULT);
                                }
                                
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
print "
                                    </table>
                                    <br><br>
                                    <input id = \"botonBorrar\" type = \"submit\" name = \"deleteUser\" value = \"Eliminar Usuario(s)\">
                                </form>
";
                        }
print "
                                <br>
                        </article>
                </section>
            </body>
        </html>
";
?>