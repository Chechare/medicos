<?php 
include "driver.php";

$err = isset($_GET["err"]) ? $_GET["err"] : 0;
$user = '';
$password = '';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="js/vendor/modernizr.js"></script>    
    <meta charset="utf-8">
    
    <title>Adview: Appointment System | Administración</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/login_form.css" rel="stylesheet">
    <link href="css/general_style.css" rel="stylesheet">
    
	<script src="js/jquery.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#login_form").validate({
                highlight: function(element, errorClass) {
                    $(element).addClass("input-error");
                },
                rules :{
                    user : {
                        required : true, //para validar campo vacio
                    },
                    password :{
                        required : true	
                    }
                },
                messages :{
                    user : {
                        required : "Requerido" //para validar campo vacio
                    },
                    password : {
                        required : "Requerido"	
                    }
                },
                errorElement: "div",
                wrapper: "div",  // a wrapper around the error message
                errorPlacement: function(error, element) {
                    offset = element.offset();
                    error.insertBefore(element)
                    //error.addClass('message-form');  // add a class to the wrapper
                    error.css('position', 'absolute');
                    error.css('left', offset.left + element.outerWidth() + 10);
                    error.css('top', offset.top + 5);
                }
            });
            
        });
    </script>
</head>
<body>
    <!--
    Comienza formulario de inicio de sesión.
    -->

	<form action="process_login.php" enctype="multipart/form-data" id="login_form" class="form-horizontal" method="POST">
        <h2 class="text-center">Administración</h2>
			<?php
	switch ($err) {
	case 1:
		?>
		<div>
			<div class="alert alert-error alerta">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Ups!</strong> Usuario y/o Contraseña incorrectos. Intente de nuevo.
			</div>
		</div>
		<?php
		break;
	case 2:
		?>
		<div>
			<div class="alert alert-error alerta">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Ups!</strong> You must login first.
			</div>
		</div>
		<?php
		break;
	}
	?>
        <div>
            <input class="input-block-level first-input" type="text" id="user" name="user" placeholder="Usuario">
        </div>
        <div>
            <input class="input-block-level last-input" type="password" id="password" name="password" placeholder="Contraseña">
        </div>
        <div class="control-group">
            <div class"checkbox">
              
                <button type="submit" class="btn btn-primary btn-block button-padding">Iniciar Sesión</button>
            </div>
        </div>
    </form>
    <!--
    Termina formulario de inicio de sesión
    -->
    
    <script src="js/bootstrap.js"></script>
</body>
</html>
