<?php
	include 'driver.php';
	sec_session_start();
	//Desconfigura todos los valores de sesión
	$_SESSION = array();
	//Obtén parámetros de sesión
	$params = session_get_cookie_params();
	//Borra la cookie actual
	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	//Destruye sesión
	session_destroy();
	//Redigir a login.php con la dirección admin.php predeterminada
    header('Location: ./login.php');
?>