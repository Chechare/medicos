<?php
class dbDriver{
	private $conexion;
	
	function __construct(){
	    $this->conexion = mysqli_connect("localhost","root","","pap");
	    if (mysqli_connect_errno())
	  	{
	  		echo "Error while connecting the database" . mysqli_connect_error();
	  	}
		session_start();
	}
	
	function __destruct(){
		mysqli_close($this->conexion);
	}

	function addTag($id, $titulo, $descripcion, $latitud, $longitud, $tipo, $video, $meta, $fecha){
		$query = mysqli_query($this->conexion, "INSERT INTO points (id, titulo, descripcion, latitud, longitud, tipo, video, meta, fecha) VALUES ('$id', '$titulo', '$descripcion', '$latitud', '$longitud', '$tipo', '$video', '$meta', '$fecha')");
	}
	
	function login($user, $password){
		$password = md5($password);
		$query = mysqli_query($this->conexion,"SELECT * from users where email='$user'");			
		$row = $query->fetch_array(MYSQLI_ASSOC);
		if($row['password'] == $password){
			$_SESSION["name"] = $row["name"];
			$_SESSION["id"] = $row["id"];
			header('Location: index.php');
		} else {
			header('Location: login.php?err=1');
		}
	}
	
	function verify($username){
		if($username != $_SESSION["id"]){
			header('Location: login.php?err=2');
		}
	}
	
	function getTag($id){
		$query = mysqli_query($this->conexion, "SELECT * FROM points WHERE id='$id'");
		$row=$query->fetch_array(MYSQLI_ASSOC);
		$array = array(
			"titulo" => $row['titulo'],
			"descripcion" => $row['descripcion'],
			"latitud" => $row['latitud'],
			"longitud" => $row['longitud'],
			"tipo" => $row['tipo'],
			"id" => $row['id'],
			"meta" => $row['meta'],
			"fecha" => $row['fecha'],
		);
		return $array;
	}

	function getUser($id){
		$query = mysqli_query($this->conexion, "SELECT * FROM users WHERE id='$id'");
		$row=$query->fetch_array(MYSQLI_ASSOC);
		$array = array(
			"name" => $row['name'],
			"email" => $row['email'],
			"points" => $row['points'],
			"country" => $row['country'],
			"city" => $row['city'],
			"logo_path" => $row['logo_path'],
		);
		return $array;
	}

	function getTags($username){
		$query = mysqli_query($this->conexion, "SELECT * FROM points WHERE id='$username' order by id");
		echo '<table class="table zebra-striped">';
		echo "<thead><tr><th>#</th><th>Tag name</th><th>tipo</th><th>latitud</th><th>longitud</th><th>Edit</th><th>Delete</th></tr></thead>";
		$i = 1;
		echo "<tbody>";
		while($row=$query->fetch_array(MYSQLI_ASSOC)){
			echo "<tr><th>".$i."</th><th>".$row['titulo']."</th><th>".$row['tipo']."</th><th>".$row['latitud']."</th><th>".$row['longitud']."</th><th><a href='tags.php?edit=".$row['id']."' class='btn btn-info btn-small'>Edit</a></th><th><a href='tags.php?delete=".$row['id']."' class='btn btn-danger btn-small'>Delete</a></th></tr>";
			$i++;
		}
		echo "</tbody>";
		echo "</table>";
	}
	
	function editTag($titulo, $descripcion, $latitud, $longitud, $video, $tipo, $meta, $fecha, $id){
		return $query = mysqli_query($this->conexion,"UPfecha points SET titulo='$titulo', descripcion='$descripcion', latitud='$latitud', longitud='$longitud', video='$video', tipo='$tipo', meta='$meta', fecha='$fecha' WHERE id='$id'"); 	 
	}

	function editUser($id, $name, $email, $country, $city, $logo_path){
		if($logo_path=="logo/"){
			return $query = mysqli_query($this->conexion,"UPfecha users SET name='$name', email='$email', country='$country', city='$city' WHERE id='$id'");
		} else {
			return $query = mysqli_query($this->conexion,"UPfecha users SET name='$name', email='$email', country='$country', city='$city', logo_path='$logo_path' WHERE id='$id'"); 	 
		}
	}
	
	function deleteTag($id){
		return $query = mysqli_query($this->conexion,"DELETE FROM points WHERE id='$id'");
	}
	
	function getTagsByUser($id){
		$sql_tag  = mysqli_query($this->conexion,"SELECT * FROM points where id='$id'");
		$sql_user = mysqli_query($this->conexion,"SELECT * FROM users where id='$id'");
		$row_user = mysqli_fetch_array($sql_user);
		$response = array();
		$posts = array();
		while($row_tag = mysqli_fetch_array($sql_tag)) {
			$titulo = $row_tag['titulo'];
			$descripcion = $row_tag['descripcion'];
			$latitud = $row_tag['latitud'];
			$longitud = $row_tag['longitud'];
			$tipo = $row_tag['tipo'];
			$video = $row_tag['video'];
			$meta = $row_tag['meta'];
			$fecha = $row_tag['fecha'];
			$logo = $row_user['logo_path'];

			$posts[] = array('titulo'=>$titulo, 'descripcion'=>$descripcion, 'latitud'=>$latitud, 'longitud'=>$longitud, 'tipo'=>$tipo, 'video'=>$video, 'logo_path'=>$logo, 'meta'=>$meta , 'fecha'=>$fecha);
		}
		$response['posts'] = $posts;
		echo json_encode($response);
		/*
		$fp = fopen("$id.json", 'w');
		fwrite($fp, json_encode($response));
		fclose($fp);
		*/
	}

	function checkPoints($id){
		$query = mysqli_query($this->conexion, "SELECT points FROM users where id='$id'");
		$row=$query->fetch_array(MYSQLI_ASSOC);
		if($row['points'] > 0){
			return true;
		} else {
			return false;
		}
	}
}
?>