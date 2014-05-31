<?php
	include "connect.php";


	// Prepare the statement
	$stmt = $mysqli->prepare("SELECT * FROM hour_data WHERE day=? AND drID=?");
	
	if(isset($_GET['dr'])){
		$id=$_GET['dr'];
	}
	else{
		$id='D01';
	}

	if(!$stmt->bind_param('ss',$day,$id)){
		echo $stmt->error;
	}

	// Ejecuta el querie
	if(!$stmt->execute()){
		echo $stmt->error;
	}

	//fetch result
	$result= $stmt->get_result();
	$row =$result->fetch_assoc();
	
	if($op=='s'){
		$hour=$row['starthour'];
	}
	else{
		$hour=$row['endhour'];
	}
	$stmt->close();
	$mysqli->close();

	if($hour=='00:00'){
		echo "<option value='00:00' selected>12:00 AM</option>\n<option value='00:30' >12:30 AM</option>\n";
	}
	else{
		echo "<option value='00:00' >12:00 AM</option>\n<option value='00:30' >12:30 AM</option>\n";
	}
	for($i=1;$i<12;$i++){
		if($i>9){
			if($hour==$i.':00') {echo"<option value='".$i.":00' selected>".$i.":00 AM</option> \n";}
			else {echo"<option value='".$i.":00' >".$i.":00 AM</option> \n";}

			if($hour==$i.':30') {echo"<option value='".$i.":30' selected>".$i.":30 AM</option> \n";}
			else {echo"<option value='".$i.":30' >".$i.":30 AM</option> \n";}
		}
		else{
			if($hour=='0'.$i.':00') {echo"<option value='0".$i.":00' selected>0".$i.":00 AM</option> \n";}
			else {echo"<option value='0".$i.":00' >0".$i.":00 AM</option> \n";}

			if($hour=='0'.$i.':30') {echo"<option value='0".$i.":30' selected>0".$i.":30 AM</option> \n";}
			else{echo"<option value='0".$i.":30' >0".$i.":30 AM</option> \n";}
		}
	}
	if($hour=='12:00'){echo"<option value='12:00' selected>12:00 PM</option> \n";}
	else {echo"<option value='12:00' >12:00 PM</option> \n";}

	if($hour=='12:30'){echo"<option value='12:30' selected>12:30 PM</option> \n";}
	else {echo"<option value='12:30' >12:30 PM</option> \n";}
	for($i=1;$i<12;$i++){
		if($i>9){
			if($hour==($i+12).':00'){echo"<option value='".($i+12).":00' selected>".$i.":00 PM</option> \n";}
			else{echo"<option value='".($i+12).":00'>".$i.":00 PM</option> \n";}

			if($hour==($i+12).':30'){echo"<option value='".($i+12).":30' selected>".$i.":30 PM</option> \n";}
			else{echo"<option value='".($i+12).":30' >".$i.":30 PM</option> \n";}
		}
		else{
			if($hour==($i+12).':00'){echo"<option value='".($i+12).":00' selected>0".$i.":00 PM</option> \n";}
			else {echo"<option value='".($i+12).":00' >0".$i.":00 PM</option> \n";}

			if($hour==($i+12).':30'){echo"<option value='".($i+12).":30' selected>0".$i.":30 PM</option> \n";}
			else{echo"<option value='".($i+12).":30' >0".$i.":30 PM</option> \n";}
		}
	}
?>