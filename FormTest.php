<!DOCTYPE html>
<html>
<head>
</head>
<body>
<form name="input" action="FormTest.php" method="post">
Nombre(s): <input type="text" name="fname" value="<?php if (isset($_POST["fname"]))echo $_POST["fname"]; else echo "";?>">

Apellido(s): <input type="text" name="lname" value="<?php if (isset($_POST["lname"]))echo $_POST["lname"]; else echo "";?>">

ID: <input type="text" name="id" value="<?php if (isset($_POST["id"]))echo $_POST["id"]; else echo "";?>">

Especialidad: <input type="text" name="spec" value="<?php if (isset($_POST["spec"]))echo $_POST["spec"]; else echo "";?>">

Duración de Cita<input list="lenght">

<datalist id="lenght">
  <option value="30 min">
  <option value="1 hr">
  <option value="1:30 min">
</datalist>

<!--Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
--->
<input type="submit" value="Submit">
</form>
<form>

<?php
//Doctor form insert
//info de coneccion con DB
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
//Preparando statement, los valores que empiezan con ':' seran remplazados con variables
$stid = oci_parse($conn, 'INSERT INTO DOCTOR (drid, dfname,dlname,specialty) VALUES(:myid, :myfname, :mylname, :myspec)');

//Asignando variables
if($_POST!=NULL){
	oci_bind_by_name($stid, ':myid', $_POST["id"]);
	oci_bind_by_name($stid, ':myfname', $_POST["fname"]);
	oci_bind_by_name($stid, ':mylname', $_POST["lname"]);
	oci_bind_by_name($stid, ':myspec', $_POST["spec"]);
	//oci_bind_by_name($stid, ':mylenght', $_POST["lenght"]);

	$r = oci_execute($stid);  // executes and commits

	if ($r) {
		print "One row inserted";
	}

	oci_free_statement($stid);
}
oci_close($conn);

?>


</form>
</body>
</html>




