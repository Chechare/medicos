<?php
include "connect.php";
include "driver.php";
sec_session_start();

if(login_check($mysqli)){
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
				$stmt = $mysqli->query('SELECT * FROM patient_data ORDER BY pfname' );

				if(($stmt->num_rows) > 0){
					// Fetch the results of the query
					print "<table class='responsive' >\n";
					echo "<tr>\n <th>ID</th>\n <th>Nombre(s)</th>\n <th>Apellido(s)</th>\n <th>Télefono</th>\n <th>Correo Eléctronico</th>\n </tr>\n";
	
					while ($row= $stmt->fetch_assoc()) {
					    print "<tr>\n";
					    foreach ($row as $item) {
					        print "    <td  style='text-align: center'>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
					    }
						print "	   <td><form action='paciente.php' method='post'>
						<input type='hidden' name='pid' value='".$row['pid']."'/>
						<input type='hidden' name='fname' value='".$row['pfname']."'/>
						<input type='hidden' name='lname' value='".$row['plname']."'/>
						<input type='hidden' name='phone' value='".$row['phone']."'/>
						<input type='hidden' name='mail' value='".$row['email']."'/>
						<input type='hidden' name='mod' value=true/>
						<input type='submit' value='Modificar' class='button' style='height:2.3rem;font-size: 1.2rem; padding:0.2rem 0.1rem 0.1rem 0.2rem;' >
						</form></td>\n";
					    print "</tr>\n";
					    print "</tr>\n";
					}
					print "</table>\n";
				}else{
					echo 
				"	<div class='panel callout radius'>
				  		<h5>¡No hay pacientes registrados!</h5>
				  		<p>Registre pacientes para poder mostrarlos en esta vista. 
				  		Una vez registrados usted podra modificar los datos del paciente si asi lo desea.</p>
					</div>";
				}
				//cerrar conexion
				$stmt->close();
				$mysqli->close();
			?>
		</div>
		<div class="large-12 column" style="height:20%;" align="center">
	   		<input type="button" value="Agregar Nuevo" class="button" Style="background-color:GRAY" onClick="openModal()">
		</div>

<?php if(isset($_POST['mod'])){ ?>
		<div id="mod" class="reveal-modal open" data-reveal=""  style="visibility: visible; display: block; opacity: 1 "  align="left">
	        <fieldset>
	        <legend><h4>Modificar Paciente</h4></legend>     	
	     	<form action="queriesInsert.php" method="post">
	     	<div class="row">	     	
	     	<input type="hidden" name="ID" value=<?php echo "'".$_POST['pid']."'" ?>> </input>	     
	        <div class="large-6 column">
	        <label>Nombre(s)</label>
	        <input type="text" name="fname" value=<?php echo "'".$_POST['fname']."'" ?>> </input>
	    	</div>
	    	<div class="large-6 column">
	        <label>Apellido(s)</label>
	        <input type="text" name="lname" value=<?php echo "'".$_POST['lname']."'" ?>> </input>
	    	</div>
	    	<div class="large-4 column">
	        <label>Teléfono</label>
	        <input type="text" name="phone" value=<?php echo "'".$_POST['phone']."'" ?>> </input>
	    	</div>
	    	<div class="large-8 column">
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

	<div id="agregar" class="reveal-modal" data-reveal="" align="left">
	        <fieldset>
	        <legend><h4>Agregar Nuevo</h4></legend>     	
	     	<form action="queriesInsert.php" method="post">

	     	<div class="row">
	     	<div class="large-1 column">
	        <label>ID</label>
	        <input type="text" name="ID" > </input>
	        </div>
	        <div class="large-5 column">
	        <label>Nombre(s)</label>
	        <input type="text" name="fname"> </input>
	    	</div>
	    	<div class="large-6 column">
	        <label>Apellido(s)</label>
	        <input type="text" name="lname"> </input>
	    	</div>
	    	<div class="large-4 column">
	        <label>Teléfono</label>
	        <input type="text" name="phone"> </input>
	    	</div>
	    	<div class="large-8 column">
			<label>E-Mail</label>
	        <input type="text" name="mail"> </input>
	    	</div>
	   		</div>

	       </fieldset>
	       
			<input type="submit" name="agregarPaciente" value="Agregar" class="button" >
			<input type="button" value="Cancelar" class="button" Style="background-color:GRAY" onclick="closeModal()">
			
			</form>
	    </div>

	</body>

		<script>
		 function closeModal(){ 
	        $('#agregar').foundation('reveal', 'close'); //Cierra ventana emergente
			$('#mod').foundation('reveal', 'close'); //Cierra ventana emergente
			$('#mod').foundation('reveal', 'close');

	      }	
	      function openModal(){
	      	$('#agregar').foundation('reveal', 'open');
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