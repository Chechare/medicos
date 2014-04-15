<?php 
require_once("driver.php");
require_once("layout.php");

$driver = new dbDriver();
$err = isset($_GET["err"]) ? $_GET["err"] : 0;
$email = '';
$password = '';
if (isset($_GET["submit"])) {
	$driver->login($_POST["email"], $_POST["password"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/foundation.css" />
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
                    email : {
                        required : true, //para validar campo vacio
                        email    : true  //para validar formato email
                    },
                    password :{
                        required : true	
                    }
                },
                messages :{
                    email : {
                        required : "", //para validar campo vacio
                        email    : ""  //para validar formato email
                    },
                    password : {
                        required : ""	
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
<title>Pick A Partner</title>


    <div class="sticky">
        <nav class="top-bar" data-topbar data-options="sticky_on: large">
            <section class="top-bar-section">
                <ul class="title-area" >
                    <li class="name"><!-- Leave this empty --></li>
                    <li>
                        <a>
                            <img heigth="29px" width="73" src="./img/logoadview.png">

                        <b><font size="2.5" color="d4ee1c"> Appointment System </font></b> </a>
                        
                    </li>
                </ul>
    

            </section>

        </nav>
                </div>    <!--
    Comienza formulario de inicio de sesión.
    -->

	<form action="login.php?submit" enctype="multipart/form-data" id="login_form" class="form-horizontal" method="POST">
        <h2 class="text-center">Administración</h2>
			<?php
	switch ($err) {
	case 1:
		?>
		<div>
			<div class="alert alert-error alerta">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Ups!</strong> Wrong email and password combination.
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
            <input class="input-block-level first-input" type="text" id="email" name="email" placeholder="User">
        </div>
        <div>
            <input class="input-block-level last-input" type="password" id="password" name="password" placeholder="Password">
        </div>
        <div class="control-group">
            <div class"checkbox">
                <label class="checkbox">
                    <input type="checkbox"> Remember me
                </label>
                <button type="submit" class="btn btn-primary btn-block button-padding">Login</button>
            </div>
        </div>
    </form>
    <!--
    Termina formulario de inicio de sesión
    -->
    
    <script src="js/bootstrap.js"></script>
</body>
</html>
