<?php
	include "connect.php";

	if(isset($_POST['agregarMedico'])){
			$stmt= $mysqli->prepare("INSERT INTO doctor VALUES(?,?,?,?,time(?))");

			if(!$stmt->bind_param('sssss', $_POST['ID'], $_POST['fname'], $_POST['lname'], $_POST['specialty'], $_POST['app_length'])){
				$err=$stmt->error;
			}

			if(!$stmt->execute()){
				$err=$stmt->error;
			}
			
			if(($stmt->affected_rows) > 0){
				$stmt->close();
				$mysqli->close();
				echo "<script>
					alert('¡Médico agregado!');
					window.location = 'medico.php';
					</script>
					'";
			}else{
				$stmt->close();
				$mysqli->close();
				if(isset($err)){
					echo $err;
				}
				echo "<script>
					alert('Error al agregar. Por favor inténtelo de nuevo.');
					window.location = 'medico.php';
					</script>
					'";
			}
	}

	if(isset($_POST['scheduleInsert'])){
		$startArray=array(1 => $_POST['1start'],
						2 => $_POST['2start'],
						3 =>$_POST['3start'],
						4 =>$_POST['4start'],
						5 =>$_POST['5start'],
						6 =>$_POST['6start'],
						7 =>$_POST['7start']
		);
	
		$endArray=array(1 =>$_POST['1end'],
						2 =>$_POST['2end'],
						3 =>$_POST['3end'],
						4 =>$_POST['4end'],
						5 =>$_POST['5end'],
						6 =>$_POST['6end'],
						7 =>$_POST['7end']
		);
	$days=array(1 =>'domingo',
							2 =>'lunes',
							3 =>'martes',
							4 =>'miercoles',
							5 =>'jueves',
							6 =>'viernes',
							7 =>'sabado'
							);
			$i=1;
			$myday=$days[$i];
			$start=$startArray[$i];
			$end=$endArray[$i];
			$insert = $mysqli->prepare("INSERT INTO schedule VALUES(?,?,time(?),time(?))");
			$insert -> bind_param('ssss', $myday, $_POST['drid'], $startArray[$i], $endArray[$i]);
			$update = $mysqli->prepare("UPDATE schedule SET starthour=time(?), endhour=time(?) WHERE day=? AND drid=? ");
			$update -> bind_param('ssss',$start,$end, $myday, $_POST['drid']);

		for($i;$i<8;$i++){
					// Perform the logic of the query
					// Ejecuta el querie				
					$myday=$days[$i];
					$start=$startArray[$i];
					$end=$endArray[$i];

					if (!$insert->execute()) {	
						if(!$update->execute()){
							echo $insert->error;
							echo $update->error;
						}	
					}		
		}
			//cerrar conexion
		$insert->close();
		$update->close();
		$mysqli->close();
		header('Location:horario.php?dr='.$_POST['drid']);  
	}	

	if(isset($_POST['crearCitaRegistrado'])){
			$phone=$_POST['phone'];
			$email=$_POST['email'];
			$drID=$_POST['drID'];
			$app_date=$_POST['app_date'];
			$description=$_POST['description'];
			$approved=$_POST['approved'];

			if($approved=='A'){
				$url='crear-cita.php';
			}
			if($approved=='P'){
				$url='crea-cliente.php';
			}

			if(!$stmt = $mysqli -> prepare("SELECT pid FROM patient WHERE phone=? OR email=?")){
				echo $mysqli->error;
			}
			
			if(!$stmt -> bind_param('ss', $phone, $email)){
				echo $stmt->error;
			}

			if(!$stmt -> execute()){
				echo $stmt->error;
			}
			echo $email;
			$result=$stmt->get_result();
			if(($result->num_rows) > 0){
				$row=$result->fetch_assoc();
				$pid=$row['pid']; 
				echo $pid;
				$stmt->close();
				if(!$stmt = $mysqli -> prepare("INSERT INTO appointment VALUES(?,?,STR_TO_DATE(?, '%d-%m-%Y %H:%i'),?,?)")){
					echo $mysqli->error;
				}

				if(!$stmt -> bind_param('sssss', $pid, $drID, $app_date, $description, $approved)){
					echo $stmt->error;
				}

				if(!$stmt -> execute()){
					echo $stmt->error;
				}

				if($stmt -> affected_rows > 0){
					echo "<script>
					alert('¡Cita registrada!');
					window.location = '".$url."';
					</script>";
				}else{
					echo "<script>
					alert('No se pudo registrar la cita, por favor intente de nuevo.');
					window.location = '".$url."';
					</script>";
				}
				$stmt->close();

			}else{
				echo "<script>
					alert('Paciente no registrado, por favor registre al nuevo paciente.');
					window.location = '".$url."';
					</script>";
			}
			$mysqli->close();		
	}
	
	if(isset($_POST['agregarCitaRegistro'])){
		
		$pFName=$_POST['fname'];
		$pLName=$_POST['lname'];
		$phone=$_POST['phone'];
		$drID=$_POST['drID'];
		$app_date=$_POST['app_date'];
		$description=$_POST['description'];
		$approved=$_POST['approved'];
		if($_POST['email'] == ''){
			$email=null;
		}else{
			$email=$_POST['email'];
		}
		if($approved=='A'){
			$url='crear-cita.php';
		}
		if($approved=='P'){
			$url='crea-cliente.php';
		}
		$prequery=$mysqli->query("SELECT SUBSTR(MAX(pid) FROM 2)+1 AS pid FROM patient");
		$result= $prequery->fetch_assoc();
		$pid=$result['pid'];
		$pid="P".str_pad($pid, 3, "0", STR_PAD_LEFT);
		$prequery->close(); 

		$queryP=$mysqli -> prepare("INSERT INTO patient VALUES(?,?,?,?,?)");
		$queryA=$mysqli -> prepare("INSERT INTO appointment VALUES(?,?,STR_TO_DATE(?, '%d-%m-%Y %H:%i'),?,?)");

		if(!$queryP->bind_param('sssss', $pid, $pFName, $pLName, $phone, $email)){
			echo $queryP->error;
		}
		echo $app_date;
		if(!$queryA->bind_param('sssss', $pid, $drID, $app_date, $description, $approved)){
			echo $queryA->error;
		}

		if($queryP->execute()){
			if($queryA->execute()){
				echo "<script>
				alert('¡Cita y paciente registrados!');
				window.location= '".$url."';
				</script>";
			}else{
				echo $queryA->error;
				echo "<script>
				alert('Error al registrar cita. Por favor revise los datos de la cita.');
				window.location= '".$url."';
				</script>";
			}
		}else{
			echo $queryP->error;
			echo "<script>
				alert('Error al registrar Paciente. Por favor revise datos del Paciente.');
				window.location= '".$url."';
				</script>";
		}

		$queryP->close();
		$queryA->close();
		$mysqli->close();

	}

		if(isset($_POST['modMedico'])){
			$stmt = $mysqli->prepare("UPDATE doctor SET dfname=?, dlname=?, specialty=?, app_lenght=time(?) WHERE drid=?");
			
			if(!$stmt->bind_param('sssss', $_POST['fname'], $_POST['lname'], $_POST['specialty'], $_POST['app_length'], $_POST['ID'])){
				$err=$stmt->$error;
			}

			if(!$stmt->execute()){
				$err=$stmt->$error;
			}
			if(($stmt->affected_rows) > 0){
				$stmt->close();
				$mysqli->close();	
				echo "<script>
				alert('¡Médico modificado!');
				window.location= 'medico.php';
				</script>";
			}else{
				$stmt->close();
				$mysqli->close();	
				if(isset($err)){
					echo $err;
				}
				echo"<script>
				alert('Error al modificar datos. Inténtelo de nuevo.');
				window.location= 'medico.php';
				</script>";
			}					
		}

		if(isset($_POST['modPaciente'])){
			$stmt = $mysqli->prepare("UPDATE patient SET pfname=?, plname=?, phone=?, email=? WHERE pid=?");
			if(!$stmt->bind_param('sssss', $_POST['fname'], $_POST['lname'], $_POST['phone'], $_POST['mail'], $_POST['ID'])){
				echo $stmt->error;
			}
			if(!$stmt->execute()){
				echo $stmt->error;
			}
			if (($stmt->affected_rows) > 0){
				echo "<script> 
					alert('¡Paciente modificado!');
					window.location = 'paciente.php';
					 </script>";	
			}else{
				echo "<script> 
					alert('Error al modificar datos del paciente. Inténtelo de nuevo.');						
					window.location = 'paciente.php';
					</script>";
			}							
			$stmt->close();
			$mysqli->close();	
		}

		if(isset($_POST['agregarPaciente'])){
			$prequery=$mysqli->query("SELECT SUBSTR(MAX(pid) FROM 2)+1 AS pid FROM patient");
			$result= $prequery->fetch_assoc();
			$pid=$result['pid'];
			$pid="P".str_pad($pid, 3, "0", STR_PAD_LEFT);
			$prequery->close(); 

			if($_POST['email'] == ''){
				$email=null;
			}else{
				$email=$_POST['email'];
			}

			$stmt = $mysqli->prepare("INSERT INTO patient VALUES(?,?,?,?,?)");
			if(!$stmt->bind_param('sssis',$pid, $_POST['fname'], $_POST['lname'], $_POST['phone'], $email)){
				$err=$stmt->error;
			}
			if(!$stmt->execute()){
				$err=$stmt->error;
			}	

			if (($stmt->affected_rows) > 0){
				$stmt->close();
				$mysqli->close();
				echo "<script> 
					alert('¡Paciente agregado!');
					window.location = 'paciente.php';
					 </script>";	
			}else{
				$stmt->close();
				$mysqli->close();					
				echo "<script> 
					alert('Error al agregar el nuevo paciente. Inténtelo de nuevo.');						
					window.location = 'paciente.php';
					</script>";
			}							
		}

		if(isset($_POST['aprobarCita'])){
			$stmt= $mysqli->prepare("UPDATE appointment SET approved='A' WHERE pid=? AND drid=? AND app_datetime=? ");
			$stmt->bind_param('sss', $_POST['pid'], $_POST['drid'], $_POST['app_date']);
			$stmt->execute();

			if (($stmt->affected_rows) > 0){
				$stmt->close();
				$mysqli->close();
				echo "<script> 
					alert('Cita aprobada!');
					window.location = 'calendario-solicitudes.php';
					 </script>";	
			}else{
				$stmt->close();
				$mysqli->close();					
				echo "<script> 
					alert('Error al aprobar la cita. Inténtelo de nuevo.');						
					window.location = 'calendario-solicitudes.php';
					</script>";
			}							
	}
?>