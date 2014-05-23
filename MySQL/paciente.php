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
				echo "<tr>\n <th>ID</th>\n <th>Nombre(s)</th>\n <th>Apellido(s)</th>\n <th>Télefono</th>\n <th>Correo Eléctronico</th>\n </tr>\n";

				while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				    print "<tr>\n";
				    foreach ($row as $item) {
				        print "    <td  style='text-align: center'>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				    }
					print "	   <td><form action='paciente.php' method='post'>
					<input type='hidden' name='pid' value='".$row['PID']."'/>
					<input type='hidden' name='fname' value='".$row['PFNAME']."'/>
					<input type='hidden' name='lname' value='".$row['PLNAME']."'/>
					<input type='hidden' name='phone' value='".$row['PHONE']."'/>
					<input type='hidden' name='mail' value='".$row['EMAIL']."'/>
					<input type='hidden' name='mod' value=true/>
					<input type='submit' value='Modificar' class='button' style='height:2.3rem;font-size: 1.2rem; padding:0.2rem 0.1rem 0.1rem 0.2rem;' >
					</form></td>\n";
				    print "</tr>\n";
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

<?php if($_POST['mod']){ ?>
		<div id="mod" class="reveal-modal open" data-reveal="" style="visibility: visible; display: block; opacity: 1 " align="left">
	        <fieldset>
	        <legend><h4>Modificar Paciente</h4></legend>     	
	     	<form action="queriesInsert.php" method="post">

	     	<div class="row">
	     	<div class="large-1 column">
	        <label>ID</label>
	        <input type="text" name="ID" value=<?php echo "'".$_POST['pid']."'" ?>> </input>
	        </div>
	        <div class="large-5 column">
	        <label>Nombre(s)</label>
	        <input type="text" name="fname" value=<?php echo "'".$_POST['fname']."'" ?>> </input>
	    	</div>
	    	<div class="large-6 column">
	        <label>Apellido(s)</label>
	        <input type="text" name="lname" value=<?php echo "'".$_POST['lname']."'" ?>> </input>
	    	</div>
	    	<div class="large-10 column">
	        <label>Teléfono</label>
	        <input type="text" name="phone" value=<?php echo "'".$_POST['phone']."'" ?>> </input>
	    	</div>
	    	<div class="large-2 column">
			<label>E-Mail</label>
	        <input type="text" name="mail" value=<?php echo "'".$_POST['mail']."'" ?>> </input>
	    	</div>
	   		</div>

	       </fieldset>
	       
			<input type="submit" name="modPaciente" value="Modificar" class="button" >
			<input type="button" value="Cancelar" class="button" Style="background-color:GRAY" onclick="closeModal()">
			
			</form>
	    </div>
		<?php } ?>
	 


	</body>


		<script>
		 function closeModal(){ 
	        $('#agregar').foundation('reveal', 'close'); //Cierra ventana emergente
			$('#mod').foundation('reveal', 'close'); //Cierra ventana emergente
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