<?php

function sec_session_start() {
        $session_name = 'sec_session_id'; //Configura un nombre de sesión personalizado
                        $secure = false; //Configura en verdadero (true) si utilizas https
                        $httponly = true; //Esto detiene que javascript sea capaz de accesar la identificación de la sesión.
                        ini_set('session.use_only_cookies', 1); //Forza a las sesiones a sólo utilizar cookies.
                        $cookieParams = session_get_cookie_params(); //Obtén params de cookies actuales.
                        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);        
                        session_name($session_name); //Configura el nombre de sesión a el configurado arriba.
                        session_start(); //Inicia la sesión php
                        session_regenerate_id(true); //Regenera la sesión, borra la previa.                 
}

function login($user, $password, $conn) {
   	//Uso de sentencias preparadas significa que la inyección de SQL no es posible.
	$query = oci_parse($conn, "SELECT password, id FROM admin WHERE username=:name");
	oci_bind_by_name($query,":name",$user);

	$r = oci_execute($query);
	if (!$r) {
	    $e = oci_error($query);
	    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	$row = oci_fetch_array($query);	
	$user_id=$row[1];
	$dbPass=$row[0];


	oci_close($conn);
            
    if($dbPass == $password) { //Revisa si la contraseña en la base de datos coincide con la contraseña que el usuario envió.
		//¡La contraseña es correcta!
        $user_browser = $_SERVER['HTTP_USER_AGENT']; //Obtén el agente de usuario del usuario
        $user_id = preg_replace("/[^0-9]+/", "", $user_id); //protección XSS ya que podemos imprimir este valor
        $_SESSION['user_id'] = $user_id;
        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $user); //protección XSS ya que podemos imprimir este valor
        $_SESSION['username'] = $username;
        $_SESSION['login_string'] = hash('sha512',$dbPass.$user_browser);
		echo $_SESSION['username'];
		return true;  //Inicio de sesión exitosa
    }else {
		return false; //La conexión no es correcta    
    }
}

function login_check($conn) {
	   //Revisa si todas las variables de sesión están configuradas.

	if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {

		$user_id = $_SESSION['user_id'];
		$login_string = $_SESSION['login_string'];
		$username = $_SESSION['username'];
		$user_browser = $_SERVER['HTTP_USER_AGENT']; //Obtén la cadena de caractéres del agente de usuario

		$query = oci_parse($conn, "SELECT password, id FROM admin WHERE username=:name");
		oci_bind_by_name($query,":name",$username);

		$r = oci_execute($query);
		if (!$r) {
		    $e = oci_error($query);
		    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}

		$row = oci_fetch_array($query);	
		$user_id=$row[1];
		$pass=$row[0];

		oci_close($conn);

		$login_check = hash('sha512',$pass.$user_browser);

		/*echo "<p></p>";
		echo "Generada por la sesion: ".$login_string;
		echo "<p></p>";
		echo "Generada para checar: ".$login_check;*/


		if($login_check == $login_string) {			
			return true; //¡¡¡¡Conectado!!!!
		} else {
			return false; //No conectado
		}
	} else {
		return false; //No conectado
	}
}

?>