<?php

include 'connect.php';

// Prepare the statement
$sentencia= $mysqli->prepare('SELECT * FROM app_data WHERE drid=? AND status=?');

if($_POST!=NULL){
	 $sentencia->bind_param('ss',$_POST["dr"], $_POST["status"]);
}else{
      $dr='D01';
      $s='A';
     $sentencia->bind_param('ss',$dr,$s);

}

// Ejecuta el querie

if (!$sentencia->execute()) {
    echo "Falló la ejecución: (" . $sentencia->errno . ") " . $sentencia->error;
}

$resultado=$sentencia->get_result();

// Fetch the results of the query
//JSON formatting
$jsonrow=array();


while (($row=$resultado->fetch_assoc())!=Null) {
   $jsonrow[]=array(
            'title' => 'Ocupado',
            'start' =>$row['app_start'].':00',
            'end'   => $row['app_end'].':00',
            'description'=> utf8_encode($row['description']),
            'lenght'=> $row['app_lenght'],
            'dlname'=> utf8_encode($row['dlname']),
            'dfname'=> utf8_encode($row['dfname']),
            'pfname'=> utf8_encode($row['pfname']),
            'plname'=> utf8_encode($row['plname']),
   );
}

print json_encode($jsonrow);

//cerrar conexion
$sentencia->close();
$mysqli->close();

?>