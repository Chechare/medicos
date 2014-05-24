<?php
include "driver.php";
include "connect.php";
sec_session_start();
if(login_check($mysqli)==true){
?>
	<!DOCTYPE html>
	<html>
	<head>
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
			<h1 >Citas Pendientes</h1>
		</div>
		<div class="large-12 column vscrollbar" align="center" style="height:60%;"  >
			<?php
				include "connect.php";

				// Prepare the statement
				//El querie tal como lo usarias en el DBM, parse lo prepara, recive la coneccion y el string
				$stid = oci_parse($conn, "SELECT pid,drid,dfname,dlname,pfname,plname,description,app_start app_st, to_char(to_date(app_start,'YYYY-MM-DD HH24:MI:SS'),'DD/MON/YYYY') as app_date, to_char(to_date(app_start,'YYYY-MM-DD HH24:MI:SS'),'HH24:MI') as app_hour, to_date(app_start,'YYYY-MM-DD HH24:MI:SS') as app_fecha FROM app_data WHERE status='P' ORDER BY app_fecha");
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
				echo "<tr>\n <th>Doctor</th>\n <th>Paciente</th>\n <th>Fecha</th>\n <th>Hora</th>\n <th>Descripción</th>\n <th></th>\n </tr>\n";

				while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				    print "<tr>\n";
					print "	   <td>".$row['DFNAME']." ".$row['DLNAME']."</td>\n";
					print "	   <td>".$row['PFNAME']." ".$row['PLNAME']."</td>\n";
					print "	   <td>".$row['APP_DATE']."</td>\n";
					print "	   <td>".$row['APP_HOUR']."</td>\n";
					print "	   <td>".$row['DESCRIPTION']."</td>\n";
					
					print "	   <td><form action='queriesInsert.php' method='post'>
					<input type='hidden' name='pid' value='".$row['PID']."'/>
					<input type='hidden' name='drid' value='".$row['DRID']."'/>
					<input type='hidden' name='app_date' value='".$row['APP_ST']."'/>
					<input type='submit' name='aprobarCita' value='Aprobar' class='button' style='height:2.3rem;font-size: 1.2rem; padding:0.2rem 0.1rem 0.1rem 0.2rem;' >
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

		
	</body>
	</html>
<?php
	}
	else{
		$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	    $_SESSION['url'] =$url;
	    header('Location: ./login.php?err=2');
	}
?>