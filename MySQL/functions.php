<?php
	function getMedicos(){
		include 'connect.php';

		$row=$mysqli->prepare('SELECT drid, dfname, dlname FROM doctor_data ORDER BY drid');

		$row->execute();

		$row->store_result();

		$row->bind_result($drID, $dFName, $dLName);
		if($row->num_rows > 0){
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
		}else{
			echo "<option value='D00' selected>No hay medicos registrados</option> \n";	
		}
		$row->close();
		$mysqli->close();
	}

	function noMedicos(){
		include 'connect.php';
		$resultado= $mysqli->query('SELECT COUNT(*) AS count FROM doctor');
		$r= $resultado->fetch_assoc();	
		$mysqli->close();
		if($r['count'] == 0){
			return true;
		}
		else{
			return false;
		}
	}

?>