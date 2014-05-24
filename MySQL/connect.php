<?php
define("HOST","localhost"); //Direccción del servidor
define("USER","root"); //Usuario para conectarse a la base de datos.
define("PASSWORD","rosc940127"); //Contraseña para conectarse a la base de datos.
define("DB","medicos"); //Nombre de la base de datos.

$mysqli = new mysqli(HOST, USER, PASSWORD, DB);

if (mysqli_connect_errno()) {
	$err=  mysqli_connect_error();
    echo "<meta charset='utf-8' /><html><b>Falló la conexión: </b>".$err." <html>";
    exit();
}

?>