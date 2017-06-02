<?php   
session_start(); //Te aseguras de usar la misma sesión
session_destroy(); //Termina la sesión
header("location:/proyecto/index.php"); //Te devuelve al index.php de forma instantánea
exit();
?>