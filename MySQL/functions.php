<?php

	function getMedicos(){
		//iniciar la conexión	
		$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
		// Prepare the statement
		//El querie tal como lo usarias en el DBM, parse lo prepara, recive la coneccion y el string
		$row=$mysqli->prepare('SELECT drid, dfname, dlname FROM doctor_data ORDER BY drid');

		$row->execute();

		$row->bind_result($drID, $dFName, $dLName);

		while($row->fetch()){
			if(isset($_GET['dr'])){
				if($_GET['dr']==$drID){
					echo "<option value=".$drID." selected>".$dFName." ".$dLName."</option> \n";	
				}else{
					echo "<option value=".$drID.">".$dFName." ".$dLName."</option> \n";
				}
			}
			else{
				echo "<option value=".$drID.">".$dFName." ".$dLName."</option> \n";				
			}
		}




/*
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
		*/
	}


?>