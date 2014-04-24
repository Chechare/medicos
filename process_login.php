<?php 
include 'connect.php';
include 'driver.php';
sec_session_start(); //Nuestra manera personalizada segura de iniciar sesión php.
 
if(isset($_POST['user'], $_POST['password'])) {
   $user = $_POST['user'];
   $password = $_POST['password']; //La contraseña con hash
   if(login($user, $password, $conn) == true) {
        //Inicio de sesión exitosa
      header( 'Location: admin.php' ) ;
   } else {
        //Inicio de sesión fallida
      header('Location: ./login.php?err=1');
   }
} else {
   //Las variaciones publicadas correctas no se enviaron a esta página
echo 'Solicitud no válida';
}
?>