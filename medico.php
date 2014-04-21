<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<script src="js/vendor/jquery.js"></script>
	<script src="js/foundation.min.js"></script>
	<script src="js/vendor/modernizr.js"></script>    
	<link rel="stylesheet" href="css/foundation.css" />
	<!-- Tablas resposivas -->
	<link type="text/css" media="screen" rel="stylesheet" href="responsive-tables/responsive-tables.css" />  
	<script type="text/javascript" src="responsive-tables/responsive-tables.js"></script>
</head>

<body style="background-color:white">
	<div class="large-12 column" style="height:20%;" align="center">
		<h1 >Médicos Registrados</h1>
	</div>
	<div class="large-12 column vscrollbar" align="center" style="height:60%;"  >
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
$stid = oci_parse($conn, "INSERT INTO DOCTOR (drid, dfname,dlname,specialty,app_lenght) VALUES(:myid, :myfname, :mylname, :myspec, to_date(:mylenght,'HH24:MI'))");

//Asignando variables
if($_POST!=NULL){
	oci_bind_by_name($stid, ':myid', $_POST["id"]);
	oci_bind_by_name($stid, ':myfname', $_POST["fname"]);
	oci_bind_by_name($stid, ':mylname', $_POST["lname"]);
	oci_bind_by_name($stid, ':myspec', $_POST["spec"]);
	oci_bind_by_name($stid, ':mylenght', $_POST["lenght"]);

	$r = oci_execute($stid);  // executes and commits

	if ($r) {
		print "One row inserted";
	}

	oci_free_statement($stid);
}
oci_close($conn);

?>
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

			// Prepare the statement
			//El querie tal como lo usarias en el DBM, parse lo prepara, recive la coneccion y el string
			$stid = oci_parse($conn, 'SELECT * FROM doctor_data ORDER BY drid');
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
			print "<table class='responsive' >\n";
			echo "<tr>\n <th>ID</th>\n <th>Nombre(s)</th>\n <th>Apellido(s)</th>\n <th>Especialidad</th>\n <th>Duracion de Cita</th>\n </tr>\n";

			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			    print "<tr>\n";
			    foreach ($row as $item) {
			        print "    <td  style='text-align: center'>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
			    }
			    print "</tr>\n";
			}
			print "</table>\n";

			//cerrar conexion
			oci_free_statement($stid);
			oci_close($conn);
		?>
	</div>

	<div class="large-12 column" style="height:20%;" align="center">
		      <input type="button" value="Agregar nuevo" class="button" Style="background-color:GRAY" data-reveal-id="agregar" >
   		      <input type="button" value="Modificar" class="button" Style="background-color:GRAY">

	</div>


 	<div id="agregar" class="reveal-modal close" data-reveal="" style="visibility: invisible; display: block; opacity: 1 " align="left">
        <fieldset>
        <legend><h4>Nuevo Médico</h4></legend>     	
     	<form action="medico.php" method="post">

     	<div class="row">
     	<div class="large-1 column">
        <label>ID</label>
        <input type="text" name="id"> </input>
        </div>
        <div class="large-5 column">
        <label>Nombre(s)</label>
        <input type="text" name="fname"> </input>
    	</div>
    	<div class="large-6 column">
        <label>Apellido(s)</label>
        <input type="text" name="lname"> </input>
    	</div>
    	<div class="large-10 column">
        <label>Especialidad</label>
        <input type="text" name="spec"> </input>
    	</div>
    	<div class="large-2 column">
        <label>Duración de la cita</label>
        <input type="text" list="applenght" name="lenght"> </input> </p>
		<datalist id="applenght">
		  <option value="00:15">
		  <option value="00:30">
		  <option value="00:45">
		  <option value="01:00">
		</datalist>
    	</div>
   		</div>

       </fieldset>
       
		<input type="submit" name="agregar" class="button" >
		<input type="button" value="Cancelar" class="button" Style="background-color:GRAY" onclick="closeModal()">
		
		</form>
		
    </div>


</body>


	<script>
	 function closeModal(){ 
        $('#agregar').foundation('reveal', 'close'); //Cierra ventana emergente
      }	
	</script>


<script>
$(document).foundation();
</script>
</body>
</html>

