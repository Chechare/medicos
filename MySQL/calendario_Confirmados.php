<?php
include "driver.php";
include 'connect.php';
include 'functions.php';
sec_session_start();
if(login_check($mysqli)){
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
							dr: <?php if(isset($_GET['dr'])){
								 		echo "'".$_GET['dr']."'";
										} 
										else echo "'D01'"; ?>,
							status: 'A'
						},
						error: function() {
							alert('Error al cargar los eventos!');
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
						getMedicos();
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
						$mysqli = new mysqli(HOST, USER, PASSWORD, DB);

						if(isset($_GET['dr'])){
							$drID=$_GET['dr'];
						}else{
							$drID='D01';
						}

						$row=$mysqli->prepare("SELECT pfname, plname, dfname, dlname, description, app_start, time_format(app_lenght,'%H:%i') 
												FROM app_data WHERE status='A' AND app_start>NOW() AND drid='".$drID."' ORDER BY app_start");
						
						$row->execute();

						$row->store_result();

						$row->bind_result($pfname, $plname, $dfname, $dlname, $desc, $start, $lenght);
						
						if(($row->num_rows)>0){	
							echo "<table class='responsive' >\n";
							echo "<tr>\n <th>Paciente</th>\n <th>Doctor</th>\n <th>Motivo</th>\n <th>Inicia</th>\n <th>Duracion de Cita</th>\n </tr>\n";
							while ($row -> fetch()) {
								echo "<tr>\n";
									echo "<td>".$pfname." ".$plname."</td> <td>".$dfname." ".$dlname."</td> <td >".$desc."</td> <td>".$start."</td> <td>".$lenght."</td>\n";
								echo "</tr>\n";
							}
							echo "</table>\n";
						}
						else{
							echo "<meta charset='utf-8' /> <script> alert('No hay citas próximas para éste médico') </script>";
						}

						$row->close();
						$mysqli->close();
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