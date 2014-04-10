<?php
	$con = mysqli_connect("localhost","creators","E0xJ60qu5l","creators_geodisplay");
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}
	if($result = mysqli_query($con,"SELECT * FROM users;")) {
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$array[] = array("id" => $row["id"]);
		}
		printf(json_encode(array("dataArray" => $array)));
	}
	else {
		printf("Error");
	}
	mysqli_close($con);
?>