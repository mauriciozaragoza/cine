<?php	
function escape_quotes($v) {
	return str_replace("'", "''", $v);
}
	
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
		$this->conexion = oci_connect("A01225648", "tec648", $db_test);
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
			echo '<option>'.$row['CITY'].'</option>';
		}
	}
	
	function getComplex(){
		$query = oci_parse($this->conexion, "SELECT COMPLEX_ID, NAME from complex");
		oci_execute($query);
		while($row=oci_fetch_array($query)){
			echo '<option value="'.$row['COMPLEX_ID'].'">'.$row['NAME'].'</option>';
		}
	}
	
	function getComplexByCity($City){
		$City = escape_quotes($City);
		$query = oci_parse($this->conexion, "SELECT COMPLEX_ID, NAME from complex where CITY='$City'");
		oci_execute($query);
		while($row=oci_fetch_array($query)){
			echo '<option value="'.$row['COMPLEX_ID'].'">'.$row['NAME'].'</option>';
		}
	}
	
	function getMoviesByComplex($complex_id){
		$complex_id = escape_quotes($complex_id);
		$query = oci_parse($this->conexion, "SELECT NAME, MOVIE_ID from movie NATURAL JOIN show where complex_id='$complex_id'");
		oci_execute($query);
		while($row=oci_fetch_array($query)){
			echo '<option value="'.$row['MOVIE_ID'].'">'.$row['NAME'].'</option>';
		}
	}
	
	function getShows($complex_id, $movie_id){
		$complex_id = escape_quotes($complex_id);
		$movie_id = escape_quotes($movie_id);
		$query = oci_parse($this->conexion, "SELECT show_room_id, date_of_show, language from movie NATURAL JOIN show where complex_id='$complex_id' AND movie_id='$movie_id'");
		oci_execute($query);
		echo "<table>";
		echo "<tr><td>Showroom</td><td>Date</td><td>Hour</td><td>Language</td></tr>";
		while($row=oci_fetch_array($query)){
			echo "<tr><td>".$row['SHOW_ROOM_ID']."</td><td>".$row['DATE_OF_SHOW']."</td><td></td><td>".$row['LANGUAGE']."</td><td>".'<a href="#" class="button">Vender</a>'."</td></tr>";
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
		$movie_id = escape_quotes($movie_id);
		//die("SELECT * from movie where movie_id='$movie_id'");
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
			"path" => $row['PATH'],
			"path_banner" => $row['PATH_BANNER']
		];
		return $array;
	}
	
	function login($user, $password){
		$user = escape_quotes($user);
		$password = md5($password);
		$query = oci_parse($this->conexion, "SELECT * from cinema_employee where username='$user'");			
		oci_execute($query);
		$row = oci_fetch_array($query);
		if($row['PASSWORD'] == $password){
			$_SESSION["username"] = $row["USERNAME"];
			$_SESSION["userrole"] = $row["ROLE_ID"];
			$_SESSION["employee_id"] = $row["EMPLOYEE_ID"];
			header('Location: index.php');
		} else {
			header('Location: login.php?err=1');
		}
		die();
	}
	
	function addEmployee($employee_id, $username, $password, $first_name, $last_name, $role_id, $complex_id){
		$employee_id = escape_quotes($employee_id);
		$username = escape_quotes($username);
		$password = md5($password);
		$first_name = escape_quotes($first_name);
		$last_name = escape_quotes($last_name);
		$role_id = escape_quotes($role_id);
		$complex_id = escape_quotes($complex_id);
		$query = oci_parse($this->conexion, "insert into cinema_employee values ('$employee_id','$username','$password','$first_name','$last_name','$role_id','$complex_id')");	
		return @oci_execute($query);
	}
	
	function verify($role){
		if($role != $_SESSION["userrole"]){
			header('Location: login.php?err=2');
		}
	}
	
	function getUser(){
		if (isset($_SESSION["username"])) {
			echo "Welcome ".$_SESSION["username"];
		}
	}
	
	function getRoles(){
		$query = oci_parse($this->conexion, "SELECT USERROLE_ID, NAME from userrole");
		oci_execute($query);
		while($row=oci_fetch_array($query)){
			echo '<option value="'.$row['USERROLE_ID'].'">'.$row['NAME'].'</option>';
		}
	}
	
	function __destruct(){
		oci_close($this->conexion);
	}
}
?>