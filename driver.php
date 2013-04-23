<?php

class dbDriver{
	private $conexion;
	
	function __construct(){
		$db_test = '(DESCRIPTION = 
		(ADDRESS_LIST = 
        (ADDRESS = 
        (COMMUNITY = tcp.world)
        (PROTOCOL = TCP)
        (Host = info.gda.itesm.mx)
        (Port = 1521)))
        (CONNECT_DATA = (SID = alum)))';
		$this->conexion = oci_connect("A01225648", "tec648",$db_test);
		$err=OciError();
        if ($err){
			echo 'Error de comunicacion con la BD. '.$err['code'].' '.$err['message'].' '.$err['sqltext'];
        }
		
		session_start();
	}
	
	function getCities(){
		$query = oci_parse($this->conexion, "SELECT DISTINCT city from complex");
		oci_execute($query);
		while($row=oci_fetch_array($query)){
			echo '<option>'.$row['city'].'</option>';
		}
	}
	
	function getComplex($City){
		$City = addslashes($City);
		$query = oci_parse($this->conexion, "SELECT COMPLEX_ID, NAME from complex where CITY='$City'");
		oci_execute($query);
		while($row=oci_fetch_array($query)){
			echo '<option value="'.$row['COMPLEX_ID'].'">'.$row['NAME'].'</option>';
		}
	}
	
	function getMoviesByComplex($complex_id){
		$complex_id = addslashes($complex_id);
		$query = oci_parse($this->conexion, "SELECT NAME, MOVIE_ID from movie NATURAL JOIN show where complex_id=$complex_id");
		oci_execute($query);
		while($row=oci_fetch_array($query)){
			echo '<option value="'.$row['MOVIE_ID'].'">'.$row['NAME'].'</option>';
		}
	}
	
	function getShows($complex_id, $movie_id){
		$complex_id = addslashes($complex_id);
		$movie_id = addslashes($movie_id);
		$query = oci_parse($this->conexion, "SELECT show_room_id, date_of_show, language from movie NATURAL JOIN show where complex_id=$complex_id AND movie_id=$movie_id");
		echo "<table>";
		while($row=oci_fetch_array($query)){
			echo "<tr><td>".$row['show_room_id']."</td><td>".$row['date_of_show']."</td><td>".$row['language']."</td></tr>";
		}
		echo "</table>";
	}
	
	function getMovies() {
		$query = oci_parse($this->conexion, "SELECT * from movie");
		oci_execute($query);
		while($row=oci_fetch_array($query)){
			echo $row['DIRECTOR'];
		}
	}
	
	function getMovie($movie_id) {
		$movie_id = addslashes($movie_id);
		$query = oci_parse($this->conexion, "SELECT * from movie where movie_id='$movie_id'");			
		oci_execute($query);
		$row=oci_fetch_array($query);
		$array = [
			"name" => $row['NAME'],
			"rating" => $row['RATING'],
			"director" => $row['DIRECTOR'],
			"actors" => $row['ACTORS'],
			"description" => $row['DESCRIPTION'],
			"language" => $row['LANGUAGE'],
		];
		return $array;
	}
	
	function login($user, $password){
		$user = addslashes($user);
		$password = md5($password);
		$query = oci_parse($this->conexion, "SELECT * from cinema_employee where username='$user'");			
		oci_execute($query);
		$row = oci_fetch_array($query);
		if($row['PASSWORD'] == $password){
			$_SESSION["username"] = $row["USERNAME"];
			$_SESSION["userrole"] = $row["ROLE_ID"];
			$_SESSION["employee_id"] = $row["EMPLOYEE_ID"];
			echo "Bienvenido";
		} else {
			header('Location: login.php?err=1');
		}
	}
	
	function addEmployee($employee_id, $username, $password, $first_name, $last_name, $role_id, $complex_id){
		$employee_id = addslashes($employee_id);
		$username = addslashes($username);
		$password = md5($password);
		$first_name = addslashes($first_name);
		$last_name = addslashes($last_name);
		$role_id = addslashes($role_id);
		$complex_id = addslashes($complex_id);
		$query = oci_parse($this->conexion, "insert into cinema_employee values ('$employee_id','$username','$password','$first_name','$last_name','$role_id','$complex_id')");			
		oci_execute($query);
	}
	
	function verify($user){
		if($user != $_SESSION["userrole"]){
			header('Location: login.php');
		}
	}
	
	function getUser(){
		if (isset($_SESSION["username"])) {
			echo "Welcome ".$_SESSION["username"]."   "."<a href=logout.php>Log out</a>";
		}
	}
	
	function __destruct(){
		oci_close($this->conexion);
	}
}

?>