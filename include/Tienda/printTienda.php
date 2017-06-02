<?PHP
		// --------------------------------- //
		// Genera el contenido de tienda.php //
		// --------------------------------- //

					print "<article class = \"articulo\"><form id = \"formTienda\" method = \"post\">";
                    $numFilas = mysqli_num_rows($productos);
                    if($numFilas == 0){
                        print '
                            <article id = "sinResultados">
                                <img src = "img/sadface.png" alt = "fallo"><span class = "normal"> No hay resultados </span>
                            </article>
                        ';
                    } else {
                        while ($fila = mysqli_fetch_array($productos)) {
						print "
							<ul class = \"producto\">
								<li class = \"imgElemento\"> <img src = ".$fila['imagen']." alt = \"en1\"> </li>
								<li class = \"elementoProducto\"> <span class = \"tipoDato\"> Nombre del libro: </span> <span class = \"dato\">".$fila['nombre']." </span></li>
								<li class = \"elementoProducto\"> <span class = \"tipoDato\"> Año de publicación: </span> <span class = \"dato\">".$fila['anyo']." </span></li>
								<li class = \"elementoProducto\"> <span class = \"tipoDato\"> Precio del libro: </span> <span class = \"dato\">".$fila['precio']." € </span></li>
								<li class = \"elementoProducto\"> <span class = \"tipoDato\"> Resumen: </span> <span class = \"dato\">".$fila['sinopsis']." </span></li>
								<li class = \"addToCart\"> <input class = \"cbox\" type = \"checkbox\" name = \"addProduct[]\" value = ".$fila['ID']."> <div class = \"textoCBox\"> Añadir al carrito </div></li>
							</ul>
						";
				    	}
						
						
                        print "<input id = \"procesar\" type = \"submit\" name = \"procesar\" value = \"Procesar compra\"></form>";
					    print "</article></section>";
                    }
?>