<?php
include "connect.php";
include "driver.php";
sec_session_start();

if(login_check($conn)){
?>
	<!doctype html>
	<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<script src="js/vendor/jquery.js"></script>
		<script src="js/foundation.min.js"></script>
		<script src="js/vendor/modernizr.js"></script>    
		<link rel="stylesheet" href="css/foundation.css" />
		<!-- Tablas resposivas -->
		<link type="text/css" media="screen" rel="stylesheet" href="responsive-tables/responsive-tables.css" />  
		<script type="text/javascript" src="responsive-tables/responsive-tables.js"></script>
	</head>

	<body style="background-color:white">
		<div class="large-12 column" style="height:20%;" align="center">
			<h1 >Pacientes</h1>
		</div>
		<div class="large-12 column vscrollbar" align="center" style="height:60%;"  >
			<?php
				include "connect.php";

				// Prepare the statement
				//El querie tal como lo usarias en el DBM, parse lo prepara, recive la coneccion y el string
				$stid = oci_parse($conn, 'SELECT * FROM patient_data ORDER BY pfname');
				if (!$stid) {
				    $e = oci_error($conn);
				    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
				}

				// Perform the logic of the query
				// Ejecuta el querie
				$r = oci_execute($stid);
				if (!$r) {
				    $e = oci_error($stid);
				    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
				}

				// Fetch the results of the query
				//Toma los datos, revisa y mientras alla una fila crea una para la tabla. El foreach recorre las columnas que regresa el resultado
				print "<table class='responsive' >\n";
				echo "<tr>\n <th>Nombre(s)</th>\n <th>Apellido(s)</th>\n <th>Télefono</th>\n <th>Correo Eléctronico</th>\n </tr>\n";

				while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				    print "<tr>\n";
				    foreach ($row as $item) {
				        print "    <td  style='text-align: center'>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				    }
				    print "</tr>\n";
				}
				print "</table>\n";

				//cerrar conexion
				oci_free_statement($stid);
				oci_close($conn);
			?>
		</div>
		<div class="large-12 column" style="height:20%;" align="center">
	   		      <input type="button" value="Modificar" class="button" Style="background-color:GRAY">
		</div>


	 


	</body>


		<script>
		 function closeModal(){ 
	        $('#agregar').foundation('reveal', 'close'); //Cierra ventana emergente
	      }	
		</script>


	<script>
	$(document).foundation();
	</script>
	</body>
	</html>

<?php
	}else{		
   	 	$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
   		$_SESSION['url'] =$url;
   		header('Location: ./login.php?err=2');
	}
?>