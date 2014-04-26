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
	/*if(isset($_POST['agregarCita'])){
		
	}*/

	
?>