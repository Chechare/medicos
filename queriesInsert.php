<?php
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
		
	

	if(isset($_POST['agregar'])){

			$ID = addslashes($_POST['ID']);
			$fname = addslashes($_POST['fname']);
			$lname = addslashes($_POST['lname']);
			$specialty = addslashes($_POST['specialty']);
			$app_length = addslashes($_POST['app_length']);

			$strSql= "INSERT INTO doctor VALUES('".$ID."','".$fname."','".$lname."','".$specialty."',to_date('".$app_length."','HH24:MI'))";

			$objParse=oci_parse($conn, $strSql);
			$objExecute= oci_execute($objParse,OCI_DEFAULT);

			if($objExecute){
				oci_commit($conn);
				echo "<script> alert('¡Médico Agregado!')</script>";				
				include "medico.php";
			}
			else{
				$e = oci_error($objParse);  
				echo "Error Add [".$e['message']."]";
			}

			
	}
	
	oci_close($conn);
?>