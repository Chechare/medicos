<?php 
include 'connect.php';
include 'driver.php';
sec_session_start(); //Nuestra manera personalizada segura de iniciar sesión php.
 
if(isset($_POST['user'], $_POST['password'])) {
   $user = $_POST['user'];
   $password = $_POST['password']; //La contraseña con hash
   if(login($user, $password, $conn)){
        //Inicio de sesión exitosa
      if(!empty($_SESSION['url'])){
        $url = $_SESSION['url'];
      }else{
        $url = 'admin.php';
      }
      header('Location:'.$url);   
    } else {
      header('Location: login.php?err=1');  
        //Inicio de sesión fallida
      
   }
} else {
   //Las variaciones publicadas correctas no se enviaron a esta página
      echo 'Solicitud no válida';
}
?>