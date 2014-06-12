<?php
//Check the range
/*Format example
*dr=D01 
*start=1403413200
*end=1404018000
Unix timestamp, un dia son 86400 segundos
*/
$range=($_POST["end"]-$_POST["start"])/86400;
//$range=$fin-$inicio;
$hours= array(
	"domS"=> "",
	"domE"=> "",
	"lunS"=> "",
	"lunE"=> "",
	"marS"=> "",
	"marE"=> "",
	"mieS"=> "",
	"mieE"=> "",
	"jueS"=> "",
	"jueE"=> "",
	"vieS"=> "",
	"vieE"=> "",
	"sabS"=> "",
	"sabE"=> "",
);
if($range < 10){
	//eventos
	include "connect.php";
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	// Prepare the statement
	//El querie tal como lo usarias en el DBM, parse lo prepara, recive la coneccion y el string
	$stid = oci_parse($conn, 'SELECT * FROM hour_data WHERE drid=:myid');
	oci_bind_by_name($stid, ':myid', $_POST["dr"]);
	
	// Ejecuta el querie
	$r = oci_execute($stid);
	if (!$r) {
		$e = oci_error($stid);
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	// Fetch the results of the query
	//Guardar horarios en el arreglo
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		//echo $row['DAY']."<br>";
		switch ($row['DAY']){
			case "domingo":
				$hours["domS"]=$row['STARTHOUR'];
				$hours["domE"]=$row['ENDHOUR'];
				break;
			case "lunes":
				$hours["lunS"]=$row['STARTHOUR'];
				$hours["lunE"]=$row['ENDHOUR'];
				break;
			case "martes":
				$hours["marS"]=$row['STARTHOUR'];
				$hours["marE"]=$row['ENDHOUR'];
				break;
			case "miercoles":
				$hours["mieS"]=$row['STARTHOUR'];
				$hours["mieE"]=$row['ENDHOUR'];
				break;
			case "jueves":
				$hours["jueS"]=$row['STARTHOUR'];
				$hours["jueE"]=$row['ENDHOUR'];
				break;
			case "viernes":
				$hours["vieS"]=$row['STARTHOUR'];
				$hours["vieE"]=$row['ENDHOUR'];
				break;
			case "sabado":
				$hours["sabS"]=$row['STARTHOUR'];
				$hours["sabE"]=$row['ENDHOUR'];
				break;
		}
	}
//cerrar conexion
oci_free_statement($stid);
oci_close($conn);
//JSON encode
$jsonrow=array();
$count=$_POST["start"];
$end=$_POST["end"];

while ($end>$count) {
//formato de horario 'yyyy-mm-dd HH24:MI:SS'
//Formato en PHP:'Y-m-d H:i'
//Llaves del arreglo de horas
	switch(date('D',$count)){
		case "Sun":
			$startKey="domS";
			$endKey="domE";
			break;
		case "Mon":
			$startKey="lunS";
			$endKey="lunE";
			break;
		case "Tue":
			$startKey="marS";
			$endKey="marE";
			break;
		case "Wed":
			$startKey="mieS";
			$endKey="mieE";
			break;
		case "Thu":
			$startKey="jueS";
			$endKey="jueE";
			break;
		case "Fri":
			$startKey="vieS";
			$endKey="vieE";
			break;
		case "Sat":
			$startKey="sabS";
			$endKey="sabE";
			break;
	}
	$lenght=0;
	//inicio de horario
   $jsonrow[]=array(
            'title' => "NA",
            'start' => date('Y-m-d',$count)." 00:00:00",
            'end'   => date('Y-m-d',$count)." ".$hours[$startKey].":0",
            'description'=> "Fuera de horario",
            'lenght'=> $lenght,
            'dfname'=> "",
            'dlname'=> "",
            'pfname'=> "",
            'plname'=> ""
   );
   //Fin de horario
   $lenght=0;
    $jsonrow[]=array(
            'title' => "NA",
            'start' => date('Y-m-d',$count)." ".$hours[$endKey].":0",
            'end'   => date('Y-m-d',$count)." 23:59:00",
            'description'=> "Fuera de horario",
            'lenght'=> $lenght,
            'dfname'=> "",
            'dlname'=> "",
            'pfname'=> "",
            'plname'=> ""
   );
   //86400 es un dia
   $count+=86400;
}
print json_encode($jsonrow);
}

?>