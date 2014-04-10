<?php
	$con = mysqli_connect("localhost","creators","E0xJ60qu5l","creators_geodisplay");
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}

  	$req = "SELECT id "
	."FROM users "
	."WHERE id LIKE '".$_REQUEST['term']."%' "; 

	if($result = mysqli_query($con,$req)) {
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$array[] = array($row["id"]);
		}
		printf(json_encode($array));
	}
	else {
		printf("Error");
	}
	mysqli_close($con);
?>