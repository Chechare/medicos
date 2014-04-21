 	

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
$stid = oci_parse($conn, 'SELECT * FROM doctor_data');
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
//Toma los datos, revisa y mientras alla una fila crea una para la tabla. El foreach recorre las columnas que regresa el resultado
print "<table border='1'>\n";
echo "<tr>\n <td>ID</td>\n <td>Nombre(s)</td>\n <td>Apellido(s)</td>\n <td>Especialidad</td>\n <td>Duracion de Cita</td>\n </tr>\n";

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    print "<tr>\n";
    foreach ($row as $item) {
        print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    print "</tr>\n";
}
print "</table>\n";

//cerrar conexion
oci_free_statement($stid);
oci_close($conn);

?>
