						<?php
							include "connect.php";

						// Prepare the statement
						//El querie tal como lo usarias en el DBM, parse lo prepara, recive la coneccion y el string
						$stid = oci_parse($conn, "SELECT * FROM hour_data WHERE day=:myday AND drid=:mydrid");
						if(isset($_GET['dr'])){
							$id=$_GET['dr'];
						}
						else{
							$id='D01';
						}
						oci_bind_by_name($stid, ":mydrid", $id);
						oci_bind_by_name($stid, ":myday", $day);
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
						$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
						if($op=='s'){
							$hour=$row['STARTHOUR'];
							}
						else{
							$hour=$row['ENDHOUR'];
						}
						oci_free_statement($stid);
						oci_close($conn);
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