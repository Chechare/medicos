<?php
	include "connect.php";

	if(isset($_POST['agregarMedico'])){

			$ID = addslashes($_POST['ID']);
			$fname = addslashes($_POST['fname']);
			$lname = addslashes($_POST['lname']);
			$specialty = addslashes($_POST['specialty']);
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

			header('Location:medico.php?alert=true');  
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
		oci_close($conn);
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
		for($i=1;$i<8;$i++){
			include "connect.php";
			$stid = oci_parse($conn, "INSERT INTO schedule VALUES(:myday,:mydr,to_date(:mystart,'HH24:MI'),to_date(:myend,'HH24:MI'))");
			$myday=$days[$i];
			oci_bind_by_name($stid, ":myday", $myday);
			oci_bind_by_name($stid, ":mydr", $_POST['drid']);
			oci_bind_by_name($stid, ":mystart", $startArray[$i]);
			oci_bind_by_name($stid, ":myend", $endArray[$i]);
					// Perform the logic of the query
					// Ejecuta el querie
					$r = oci_execute($stid);
					if (!$r) {
						//$e = oci_error($stid);
						$stid = oci_parse($conn, "UPDATE schedule SET starthour=to_date(:mystart,'HH24:MI'), endhour=to_date(:myend,'HH24:MI') WHERE day=:myday AND drid=:mydr");
						$myday=$days[$i];
						oci_bind_by_name($stid, ":myday", $myday);
						oci_bind_by_name($stid, ":mydr", $_POST['drid']);
						oci_bind_by_name($stid, ":mystart", $startArray[$i]);
						oci_bind_by_name($stid, ":myend", $endArray[$i]);
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
					}

			// Fetch the results of the query
			//Toma los datos, revisa y mientras alla una fila crea una para la tabla. 
			//El foreach recorre las columnas que regresa el resultado
		
			//cerrar conexion
			oci_commit ($conn);
			oci_free_statement($stid);
			oci_close($conn);
				
		}
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
			$stid = oci_parse($conn, "UPDATE doctor SET dfname=:myfname, dlname=:mylname, specialty=:myspec, app_lenght=to_date(:mylenght,'HH24:MI') WHERE drid=:mydr");
						oci_bind_by_name($stid, ":myfname", $_POST['fname']);
						oci_bind_by_name($stid, ":mylname", $_POST['lname']);
						oci_bind_by_name($stid, ":myspec", $_POST['specialty']);
						oci_bind_by_name($stid, ":mylenght", $_POST['app_length']);
						oci_bind_by_name($stid, ":mydr", $_POST['ID']);
						if (!$stid) {
							$e = oci_error($conn);
							trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
						}

						$r = oci_execute($stid);
						if (!$r) {
							$e = oci_error($stid);
							trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
						}
						oci_commit($conn);
						oci_free_statement($stid);
						oci_close($conn);
						header('Location:medico.php');  
							
		}
			if(isset($_POST['modPaciente'])){
			$stid = oci_parse($conn, "UPDATE patient SET pfname=:myfname, plname=:mylname, phone=:myphone, email=:mymail WHERE pid=:myid");
						oci_bind_by_name($stid, ":myfname", $_POST['fname']);
						oci_bind_by_name($stid, ":mylname", $_POST['lname']);
						oci_bind_by_name($stid, ":myphone", $_POST['phone']);
						oci_bind_by_name($stid, ":mymail", $_POST['mail']);
						oci_bind_by_name($stid, ":myid", $_POST['ID']);
						if (!$stid) {
							$e = oci_error($conn);
							trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
						}

						$r = oci_execute($stid);
						if (!$r) {
							$e = oci_error($stid);
							trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
						}
						oci_commit($conn);
						oci_free_statement($stid);
						oci_close($conn);
						header('Location:paciente.php');  
							
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