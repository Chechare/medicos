<!DOCTYPE html>
<html>
<head>


<link href='./calendar/fullcalendar.css' rel='stylesheet' />
<link href='./calendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='./calendar/lib/jquery.min.js'></script>
<script src='./calendar/lib/jquery-ui.custom.min.js'></script>
<script src='./calendar/fullcalendar.min.js'></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="./js/jquery.qtip-1.0.0-rc3.min.js"></script> 

<script>

	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
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
					},
					error: function() {
						alert('there was an error while fetching events!');
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
						  name: 'dark' // Style it according to the preset 'cream' style
					   }
				});
			}
		});

	$('#calendar1').fullCalendar({
			editable: true,
			defaultView:'basicDay',
			header: {
            left: '',
            center: 'prev,next today',
            right: ''
          },
			eventSources: [

				// your event source
				{
					url: 'appointmentFeed.php', // use the `url` property
					color: 'blue',    // an option!
					textColor: 'white',  // an option!
					allDayDefault: false,
					startEditable: false,
					editable: false
				}

				// any other sources...

			]
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
		<form action="calendario_Confirmados.php" method="get">
			<h3>Doctor:
				<select name='dr'>
				<?php
					// Create connection to Oracle
					//la coneccion obviamente

					$MYDB ="
						 (DESCRIPTION =
						   (ADDRESS = (PROTOCOL = TCP)(HOST = info.gda.itesm.mx)(PORT = 1521))
						   (CONNECT_DATA =
							 (SID = ALUM)
							 (SERVER = DEDICATED)
						   )
						 )";
						
					$conn = oci_connect("a01226103", "14db103", $MYDB);
					if (!$conn) {
						$e = oci_error();
						trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
					}

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
				<input type="submit"  value="Buscar" class="button" >
				</h3>
				
			</form>
		</div>
		<div class="large-7 column">
			<div id='calendar' style="width:90%" ></div>
		</div>
		<div  class="large-5 column" >
			<h1>Citas Confirmadas<h2>
			<div id='calendar1' style="width:100%" ></div>
		</div>
		
</body>

</html>
