<?php

$MYDB="(DESCRIPTION =
   		(ADDRESS = (PROTOCOL = TCP)(HOST = info.gda.itesm.mx)(PORT = 1521))
   		(CONNECT_DATA =
     	(SID = ALUM)
    	(SERVER = DEDICATED)
   		)
	 )";

$conn= oci_connect("a01226103", "14db103", $MYDB);
		if (!$conn) {
		    $e = oci_error();
		    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}

?>