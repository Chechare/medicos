<?php
	function getMedicos(){
		include 'connect.php';

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

		$row->close();
		$mysqli->close();
	}


?>