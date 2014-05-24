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
			<h1 >Horarios de Atención</h1>
		</div>
	<div class="row">
			<form action="horario.php" method="get">
				<h3><div class="large-2 column left" style="padding:0.36rem 0.39rem 0.5rem 4.2rem">Médico:</div>
					<div class="large-8 column left">
					<select name='dr' onchange='this.form.submit()'>
					<?php
						//iniciar la conexión
						include "connect.php";

						// Prepare the statement
						//El querie tal como lo usarias en el DBM, parse lo prepara, recive la coneccion y el string
						$stid = oci_parse($conn, 'SELECT * FROM doctor_data ORDER BY drid');
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
						//Toma los datos, revisa y mientras alla una fila crea una opcion para el select
						while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
							if(isset($_GET['dr'])){
								if($_GET['dr']==$row['DRID']){
									echo "<option value='".$row['DRID']."' selected>".$row['DRID'].'-'.$row['DFNAME'].' '.$row['DLNAME'].'-'.$row['SPECIALTY'].'</option> /n';
								}
								else{
									echo "<option value='".$row['DRID']."'>".$row['DRID'].'-'.$row['DFNAME'].' '.$row['DLNAME'].'-'.$row['SPECIALTY'].'</option> /n';
								}
							}
							else{
								echo "<option value='".$row['DRID']."'>".$row['DRID'].'-'.$row['DFNAME'].' '.$row['DLNAME'].'-'.$row['SPECIALTY'].'</option> /n';
							}
						}
						//cerrar conexion
						oci_free_statement($stid);
						oci_close($conn);

					?>
					</select>
					</div>
					<div class="large-1 column left" >
						<noscript><input type="submit"  value="Buscar" class="button" style="height:2.3rem;font-size: 1.2rem; padding:0.36rem 0.39rem 0.5rem 0.39rem;"></noscript>
					</div>
					</h3>					
				</form>
		</div>

		<div class="row">
			<form action="queriesInsert.php" method="post">
			<input type="hidden" name='drid' value=<?php if(isset($_GET['dr'])){ echo "'".$_GET['dr']."'";} else{ echo "'D01'";} ?> />
			<div class="row">
					<div class="large-1 column left" style="width:8rem;padding-left:1.3rem">
						<h5 style="text-align:center">Domingo</h5><br>
						De: <select name="1start" >
						<?php 
						//TODO
						$day='domingo';
						$op='s';
						include "hourOptions.php";?>
						</select><br>
						A: <select name="1end" >
						
						<?php 
						$day='domingo';
						$op='e';
						include "hourOptions.php";?>
						</select><br>
					</div>
					<div class="large-1 column left" style="width:8rem;padding-left:1.3rem">
						<h5 style="text-align:center">Lunes</h5><br>
						De: <select name="2start" >
						<?php 
						$day='lunes';
						$op='s';
						include "hourOptions.php";?>
						</select><br>
						A: <select name="2end" >
						<?php 
						$day='lunes';
						$op='e';
						include "hourOptions.php";?>
						</select><br>
					</div>
					<div class="large-1 column left"style="width:8rem;padding-left:1.3rem">
						<h5 style="text-align:center">Martes</h5><br>
						De: <select name="3start" >
						<?php 
						$day='martes';
						$op='s';
						include "hourOptions.php";?>
						</select><br>
						A: <select name="3end" >
						<?php 
						$day='martes';
						$op='e';
						include "hourOptions.php";?>
						</select><br>
					</div>
					<div class="large-1 column left" style="width:8rem;padding-left:1.3rem">
						<h5 style="text-align:center">Miercoles</h5><br>
						De: <select name="4start" >
						<?php 
						$day='miercoles';
						$op='s';
						include "hourOptions.php";?>
						</select><br>
						A: <select name="4end" >
						<?php 
						$day='miercoles';
						$op='e';
						include "hourOptions.php";?>
						</select><br>
					</div>
					<div class="large-1 column left" style="width:8rem;padding-left:1.3rem">
						<h5 style="text-align:center">Jueves</h5><br>
						De: <select name="5start" >
						<?php 
						$day='jueves';
						$op='s';
						include "hourOptions.php";?>
						</select><br>
						A: <select name="5end" >
						<?php 
						$day='jueves';
						$op='e';
						include "hourOptions.php";?>
						</select><br>
					</div>
					<div class="large-1 column left" style="width:8rem;padding-left:1.3rem">
						<h5 style="text-align:center">Viernes</h5><br>
						De: <select name="6start" >
						<?php 
						$day='viernes';
						$op='s';
						include "hourOptions.php";?>
						</select><br>
						A: <select name="6end" >
						<?php 
						$day='viernes';
						$op='e';
						include "hourOptions.php";?>
						</select><br>
					</div>
					<div class="large-1 column left" style="width:8rem;padding-left:1.3rem">
						<h5 style="text-align:center">Sabado</h5><br>
						De: <select name="7start" >
						<?php 
						$day='sabado';
						$op='s';
						include "hourOptions.php";?>
						</select><br>
						A: <select name="7end" >
						<?php 
						$day='sabado';
						$op='e';
						include "hourOptions.php";?>
						</select><br>
					</div>
			</div>
			<div class='row'>
				<div class="large-2 columns large-centered">
					<input type="submit" name='scheduleInsert' value="Actualizar" class="button">
				</div>
			</div>
			</form>
		</div>
		
		
		<div class="large-12 column vscrollbar" align="center" style="height:60%;"  >
			<?php
				include "connect.php";

				// Prepare the statement
				//El querie tal como lo usarias en el DBM, parse lo prepara, recive la coneccion y el string
				$stid = oci_parse($conn, 'SELECT * FROM doctor_data ORDER BY drid');
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
				//Toma los datos, revisa y mientras alla una fila crea una para la tabla. 
				//El foreach recorre las columnas que regresa el resultado
			
				//cerrar conexion
				
				oci_free_statement($stid);
				oci_close($conn);
			?>
		</div>

	</body>



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