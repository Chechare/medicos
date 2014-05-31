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

	if(isset($_POST['agregarCita'])){
			$dr = addslashes($_POST['dr']);
			$fname = addslashes($_POST['fname']);
			$lname = addslashes($_POST['lname']);
			$app_length = addslashes($_POST['app_length']);

			$strSql= "INSERT INTO doctor VALUES('".$ID."','".$fname."','".$lname."','".$specialty."',to_date('".$app_length."','HH24:MI'))";

			$objParse=oci_parse($conn, $strSql);
			$objExecute= oci_execute($objParse,OCI_DEFAULT);

			echo $strSql;

			if($objExecute){
				//oci_commit($conn);
				echo "<meta charset='utf-8'/><script> alert('¡Médico Agregado!')</script>";				
				//include "medico.php";
			}
			else{
				$e = oci_error($objParse);  
			}

			oci_free_statement($objParse);
			oci_close($conn);
		
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
			$phone=addslashes($_POST['phone']);
			$email=addslashes($_POST['email']);

			$drID=addslashes($_POST['drID']);
			$app_date=addslashes($_POST['app_date']);
			$description=addslashes($_POST['description']);
			$approved=addslashes($_POST['approved']);

			$query="SELECT PID FROM patient WHERE phone=".$phone." OR email='".$email."'";
			
			$objParse=oci_parse($conn, $query);

			$objExecute= oci_execute($objParse,OCI_DEFAULT);

				if($objExecute){
					//oci_commit($conn);
					echo "<meta charset='utf-8'/><script> alert('¡Paciente Registrado!');</script>";				
					//include "medico.php";
				}
				else{
					$e = oci_error($objParse);  
				}

			$row = oci_fetch_array($objParse, OCI_ASSOC+OCI_RETURN_NULLS);
			
			oci_free_statement($objParse);


			if(!is_null($row['PID'])){
				$PID=$row['PID'];

				$query2="INSERT INTO appointment VALUES('".$PID."','".$drID."',to_date('".$app_date."','DD-MM-YYYY HH24:MI'),'".$description."','".$approved."')";

				$objParse2=oci_parse($conn, $query2);

				$objExecute= oci_execute($objParse2,OCI_DEFAULT);

				if($objExecute){
					//oci_commit($conn);
					echo "<meta charset='utf-8'/><script> alert('¡Cita Registrada!');</script>";				
					//include "medico.php";
				}
				else{
					$e = oci_error($objParse2);  
				}

				oci_commit($conn);
				oci_free_statement($objParse2); 
				oci_close($conn);
				header('Location:crear-cita.php?alert=true'); 
				}
			else{
				oci_close($conn);
				header('Location:crear-cita.php?alert2=true');  
			}

		
	}
	if(isset($_POST['agregarCitaRegistro'])){
		
		$pFName=addslashes($_POST['fname']);
		$pLName=addslashes($_POST['lname']);
		$phone=addslashes($_POST['phone']);
		$email=addslashes($_POST['email']);

		$drID=addslashes($_POST['drID']);
		$app_date=addslashes($_POST['app_date']);
		$description=addslashes($_POST['description']);
		$approved=addslashes($_POST['approved']);
		$prequery=oci_parse($conn, "Select to_char(patientID_seq.nextval,'009') AS next from dual");
		$preobjExecute= oci_execute($prequery,OCI_DEFAULT);

			if($preobjExecute){
				oci_commit($conn);
				$row = oci_fetch_array($prequery, OCI_ASSOC+OCI_RETURN_NULLS);
				$nextpid=$row['NEXT'];
				$p='P';
				$PID=$p.$nextpid;
				$PID=str_replace(' ', '', $PID);
				$PID=addslashes($PID);
			}
			else{
				$e = oci_error($prequery);  
				header('Location:crear-cita.php?alert2=true');
			}
		$query="INSERT INTO patient VALUES('".$PID."','".$pFName."','".$pLName."',".$phone.",'".$email."')";
		$query2="INSERT INTO appointment VALUES('".$PID."','".$drID."',to_date('".$app_date."','DD-MM-YYYY HH24:MI'),'".$description."','".$approved."')";

		$objParse=oci_parse($conn, $query);

		$objExecute= oci_execute($objParse,OCI_DEFAULT);

			if($objExecute){
				oci_commit($conn);
			}
			else{
				$e = oci_error($objParse);  
				header('Location:crear-cita.php?alert2=true');
			}

		oci_commit($conn);
		oci_free_statement($objParse);


		$objParse2=oci_parse($conn, $query2);

		$objExecute= oci_execute($objParse2,OCI_DEFAULT);

		if($objExecute){
			}
			else{
				$e = oci_error($objParse2);  
				header('Location:crear-cita.php?alert2=true');
			}

		oci_commit($conn);
		oci_free_statement($objParse2);
		
		
		$query="SELECT *  FROM patient WHERE='".$PID."')";
		$query2="SELECT *  FROM appointment WHERE pid='".$PID."' AND drID='".$drID."' AND app_date=to_date('".$app_date."','DD-MM-YYYY HH24:MI')";

		$objParse=oci_parse($conn, $query);

		$objExecute= oci_execute($objParse,OCI_DEFAULT);

			if($row = oci_fetch_array($prequery)){
				$a4=false;
				if (!isset($row[0])){
					$a4=true;;
				}
			}
			else{
				$e = oci_error($objParse);  
				$a4=true;
			}

		oci_commit($conn);
		oci_free_statement($objParse);


		$objParse2=oci_parse($conn, $query2);

		$objExecute= oci_execute($objParse2,OCI_DEFAULT);

		if($row = oci_fetch_array($prequery)){
				if (!isset($row[0])){
					header('Location:crear-cita.php?alert3=true alert4='.$a4);
				}
			}
			else{
				$e = oci_error($objParse2);  
				header('Location:crear-cita.php?alert3=true alert4='.$a4);
			}

		oci_commit($conn);
		oci_free_statement($objParse2);


		oci_close($conn);
		header('Location:crear-cita.php?alert=true');  

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
			$stmt->bind_param('ssiss', $_POST['fname'], $_POST['lname'], $_POST['phone'], $_POST['mail'], $_POST['ID']);
			$stmt->execute();
			if (($stmt->affected_rows) > 0){
				$stmt->close();
				$mysqli->close();
				echo "<script> 
					alert('¡Paciente modificado!');
					window.location = 'paciente.php';
					 </script>";	
			}else{
				$stmt->close();
				$mysqli->close();					
				echo "<script> 
					alert('Error al modificar datos del paciente. Inténtelo de nuevo.');						
					window.location = 'paciente.php';
					</script>";
			}							
		}

		if(isset($_POST['agregarPaciente'])){
			$stmt = $mysqli->prepare("INSERT INTO patient VALUES(?,?,?,?,?)");
			if(!$stmt->bind_param('sssis',$_POST['ID'], $_POST['fname'], $_POST['lname'], $_POST['phone'], $_POST['mail'])){
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