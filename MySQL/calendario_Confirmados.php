<?php
include "driver.php";
include 'connect.php';
sec_session_start();
if(login_check($conn)){
	?>

	<!DOCTYPE html>
	<html>
	<head>
	<link rel="stylesheet" href="css/foundation.css" />
	<link href='./calendar/fullcalendar.css' rel='stylesheet' />
	<link href='./calendar/fullcalendar.print.css' rel='stylesheet' media='print' />
	<script src='./calendar/lib/jquery.min.js'></script>
	<script src='./calendar/lib/jquery-ui.custom.min.js'></script>
	<script src='./calendar/fullcalendar.min.js'></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
	<script src="./js/jquery.qtip-1.0.0-rc3.min.js"></script> 
	<link type="text/css" media="screen" rel="stylesheet" href="responsive-tables/responsive-tables.css" />  
	<script type="text/javascript" src="responsive-tables/responsive-tables.js"></script>
	<script>

		$(document).ready(function() {
			
			$('#calendar').fullCalendar({
				defaultView:'agendaWeek',
				editable: true,
				header: {
	            left: 'prev,next today',
	            center: 'title',
	            right: 'month,agendaWeek,agendaDay'
	          },
				
				eventSources: [

					// your event source
					{
						url: 'appointmentFeed.php', // use the `url` property
						type: 'POST',
						data: {
							dr: <?php if(isset($_GET['dr'])){ echo "'".$_GET['dr']."'";} else echo "'D01'"; ?>,
							status: 'A'
						},
						error: function() {
							alert('error al cargar los eventos!');
						},
						color: 'teal',    // an option!
						textColor: 'white',  // an option!
						allDayDefault: false,
						editable:false
					}

					// any other sources...

				],
				 eventRender: function(event, element) {
					element.qtip({
						content: '<strong>Doctor:</strong> <br/>'+event.dfname+' '+event.dlname+' <br/><strong>Paciente:</strong> <br/>' +event.pfname+' '+event.plname+' <br/><strong>Descripción:</strong> <br/>'+event.description,
						 position: {
							  corner: {
								 tooltip:'leftMiddle', // Use the corner...
								 target: 'rightMiddle' // ...and opposite corner
							  }
						   },
						   style: {
							  border: {
								 width: 3,
								 radius: 5
							  },
							  padding: 10, 
							  textAlign: 'left',
							  tip: true, // Give it a speech bubble tip with automatic corner detection
							  name: 'dark' // Style  preset 
						   }
					});
				}
			});

			
		});


	</script>
	<style>
		#calendar1{
			font-size:10px;
			height: 100%;
		}

	</style>
	</head>
	<body>
		<div class="row">

					<h1>Citas Confirmadas<h2>
			<form action="calendario_Confirmados.php" method="get">
				<h3><div class="large-2 column left" style="padding:0.36rem 0.39rem 0.5rem 2.2rem">Médico:</div>
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
						<noscript>
						<input type="submit"  value="Buscar" class="button" style="height:2.3rem;font-size: 1.2rem; padding:0.36rem 0.39rem 0.5rem 0.39rem;">
						</noscript>
					</div>
					</h3>					
				</form>
		</div>
			
			<div class="large-12 column">
				<div id='calendar' style="width:90%" ></div>
			</div>
			<div  class="large-12 column " >
				<div class="large-12 column vscrollbar" align="center" style="height:30%;" >
					<?php
						include "connect.php";

						// Prepare the statement
						//El querie tal como lo usarias en el DBM, parse lo prepara, recive la coneccion y el string
						$stid = oci_parse($conn, "SELECT pfName||' '||plname AS paciente, dfname||' '||dlname AS doctor, description, app_start,app_lenght FROM app_data WHERE status='A' AND to_date(app_start,'YYYY-MM-DD HH24:MI:SS')>SYSDATE ORDER BY app_start");
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
						echo "<tr>\n <th>Paciente</th>\n <th>Doctor</th>\n <th>Motivo</th>\n <th>Inicia</th>\n <th>Duracion de Cita</th>\n </tr>\n";

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