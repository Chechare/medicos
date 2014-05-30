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
				//El querie tal como lo usarias en el DBM.
				if(!$resultado= $mysqli -> query("SELECT drid,pid,dfname,dlname,pfname,plname,description,app_start,date(app_start) as app_date, time(app_start) as app_hour FROM app_data WHERE status='P' ORDER BY app_date")){
					print $mysqli->error;
				}
				
				if(($resultado->num_rows) > 0){
					//Toma los datos, revisa y mientras alla una fila crea una para la tabla.
					print "<table class='responsive' >\n";
					echo "<tr>\n <th>Doctor</th>\n <th>Paciente</th>\n <th>Fecha</th>\n <th>Hora</th>\n <th>Descripción</th>\n <th></th>\n </tr>\n";

					while ($row=$resultado->fetch_assoc()) {
					    print "<tr>\n";
						print "	   <td>".$row['dfname']." ".$row['dlname']."</td>\n";
						print "	   <td>".$row['pfname']." ".$row['plname']."</td>\n";
						print "	   <td>".$row['app_date']."</td>\n";
						print "	   <td>".$row['app_hour']."</td>\n";
						print "	   <td>".$row['description']."</td>\n";
						
						print "	   <td><form action='queriesInsert.php' method='post'>
						<input type='hidden' name='pid' value='".$row['pid']."'/>
						<input type='hidden' name='drid' value='".$row['drid']."'/>
						<input type='hidden' name='app_date' value='".$row['app_start']."'/>
						<input type='submit' name='aprobarCita' value='Aprobar' class='button' style='height:2.3rem;font-size: 1.2rem; padding:0.2rem 0.1rem 0.1rem 0.2rem;' >
						</form></td>\n";
					    print "</tr>\n";
					    print "</tr>\n";
					}
					print "</table>\n";
				}else{
					echo 
				"	<div class='panel callout radius'>
				  		<h5>¡No hay más citas!</h5>
				  		<p>Se han aprobado o rechazado todas las citas pendientes, regrese más tarde para comprobar nuevas citas.</p>
					</div>";
				}
				//cerrar conexion
				$mysqli->close();
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