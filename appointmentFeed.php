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
$stid = oci_parse($conn, 'SELECT * FROM app_data');
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
//JSON formatting
$jsonrow=array();
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
   $jsonrow[]=array(
            'title' => $row['PFNAME'].' '.$row['PLNAME'],
            'start' => $row['APP_START'],
            'end'   => $row['APP_END'],
            'description'=> $row['DESCRIPTION'],
            'lenght'=> $row['APP_LENGHT'],
            'dfname'=> $row['DFNAME'],
            'dlname'=> $row['DLNAME'],
            'pfname'=> $row['PFNAME'],
            'plname'=> $row['PLNAME']
   );
}
print json_encode($jsonrow);

//cerrar conexion
oci_free_statement($stid);
oci_close($conn);

?>