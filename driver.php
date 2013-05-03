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
		$query = oci_parse($this->conexion, "SELECT show_id,show_room_id, date_of_show, language from movie NATURAL JOIN show where complex_id='$complex_id' AND movie_id='$movie_id'");
		oci_execute($query);
		if (isset($_SESSION["username"])) {
			echo "<table>";
			echo "<tr><td>Showroom</td><td>Date</td><td>Hour</td><td>Language</td></tr>";
			while($row=oci_fetch_array($query)){
				echo "<tr><td>".$row['SHOW_ROOM_ID']."</td><td>".$row['DATE_OF_SHOW']."</td><td></td><td>".$row['LANGUAGE']."</td><td>		".'<a href="ticket.php?'.$row['SHOW_ID'].'" class="small-button">Sell<br>Tickets</a>'."</td></tr>";
			}
			echo "</table>";
		}
		else{
			echo "<table>";
			echo "<tr><td>Showroom</td><td>Date</td><td>Hour</td><td>Language</td></tr>";
			while($row=oci_fetch_array($query)){
				echo "<tr><td>".$row['SHOW_ROOM_ID']."</td><td>".$row['DATE_OF_SHOW']."</td><td></td><td>".$row['LANGUAGE']."</td></tr>";
			}
			echo "</table>";
		}
	}
			
	function getEmployees(){
		$query = oci_parse($this->conexion, "select employee_id, username, first_name, last_name, role_id, complex_id  from cinema_employee where complex_id='".$_SESSION['complex_id']."'");
		oci_execute($query);
		echo "<table>";
		echo "<tr><td>Employee Id</td><td>Username</td><td>First Name</td><td>Last Name</td><td>Role Id</td><td>Edit</td><td>Delete</td></tr>";
		while($row=oci_fetch_array($query)){
			echo "<tr><td>".$row['EMPLOYEE_ID']."</td><td>".$row['USERNAME']."</td><td></td><td>".$row['FIRST_NAME']."</td><td>".$row['LAST_NAME']."</td><td>".$row['ROLE_ID']."</td><td>".$row['COMPLEX_ID']."</td><td>".$row['COMPLEX_ID']."</td><td><a href='employee.php?edit='".$row['EMPLOYEE_ID']." class='small button'>Edit</a></td><td><a href='employee.php?delete='".$row['EMPLOYEE_ID']." class='small button alert'>Delete</a></td></tr>";
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
	
	function getPayforms(){
		$query = oci_parse($this->conexion, "SELECT * from payform");
		oci_execute($query);
		while($row=oci_fetch_array($query)){
			echo '<option value="'.$row['PAYFORM_ID'].'">'.$row['NAME'].'</option>';
		}
	}
	
	function getMovie($movie_id) {
		$movie_id = escape_quotes($movie_id);
		$query = oci_parse($this->conexion, "SELECT * from movie where movie_id='$movie_id'");			
		oci_execute($query);
		$row=oci_fetch_array($query);
		$array = [
			"movie_id" => $row['MOVIE_ID'];
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
	
	function getEmployee($employee_id) {
		$employee_id = escape_quotes($employee_id);
		$query = oci_parse($this->conexion, "SELECT * from cinema_employee where employee_id='$employee_id'");			
		oci_execute($query);
		$row=oci_fetch_array($query);
		$array = [
			"employee_id" => $row['EMPLOYEE_ID'],
			"username" => $row['USERNAME'],
			"first_name" => $row['FIRST_NAME'],
			"last_name" => $row['LAST_NAME'],
			"role_id" => $row['ROLE_ID'],
			"complex_id" => $row['COMPLEX_ID'],
		];
		return $array;
	}
	
	function updateEmployee($employee_id, $username, $password, $first_name, $last_name, $role_id, $complex_id) {
		
		$employee_id = escape_quotes($employee_id);
		$username = escape_quotes($username);
		$first_name = escape_quotes($first_name);
		$last_name = escape_quotes($last_name);
		$role_id = escape_quotes($role_id);
		$complex_id = escape_quotes($complex_id);
		
		if($password == ""){
			$query = oci_parse($this->conexion, "update cinema_employee set username='$username', first_name='$first_name', last_name='$last_name', role_id='$role_id', complex_id='$complex_id' where employee_id='$employee_id'");
		}
		else{
			$password = md5($password);
			$query = oci_parse($this->conexion, "update cinema_employee set username='$username', password='$password', first_name='$first_name', last_name='$last_name', role_id='$role_id', complex_id='$complex_id' where employee_id='$employee_id'");
		}
		
		return @oci_execute($query);			
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
			$_SESSION["complex_id"] = $row["COMPLEX_ID"];
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
	
	function addMovie($movie_id, $name, $rating, $director, $actors, $description, $language, $path, $path_banner){
		$movie_id = escape_quotes($movie_id);
		$name = escape_quotes($name);
		$rating = escape_quotes($rating);
		$director = escape_quotes($director);
		$actors = escape_quotes($actors);
		$description = escape_quotes($description);
		$language = escape_quotes($language);
		$path = escape_quotes($path);
		$path_banner = escape_quotes($path_banner);
		$query = oci_parse($this->conexion, "insert into movie values ('$movie_id', '$name', '$rating', '$director', '$actors', '$description', '$language', '$path', '$path_banner')");	
		return @oci_execute($query);
	}
	
	function updateMovie($movie_id, $name, $rating, $director, $actors, $description, $language, $path, $path_banner){
		$movie_id = escape_quotes($movie_id);
		$name = escape_quotes($name);
		$rating = escape_quotes($rating);
		$director = escape_quotes($director);
		$actors = escape_quotes($actors);
		$description = escape_quotes($description);
		$language = escape_quotes($language);
		$path = escape_quotes($path);
		$path_banner = escape_quotes($path_banner);
		$query = oci_parse($this->conexion, "update movie set name='$name', rating='$rating', director='$director', actors='$actors', description='$description', language='$language', path='$path', path_banner='$path_banner' where movie_id='$movie_id'");	
		return @oci_execute($query);
	}
	
	function addShow($show_id, $date_of_show, $show_room_id, $complex_id, $movie_id){
		$show_id = escape_quotes($show_id);
		$date_of_show = escape_quotes($date_of_show);
		$show_room_id = escape_quotes($show_room_id);
		$complex_id = escape_quotes($complex_id);
		$movie_id = escape_quotes($movie_id);
		$query = oci_parse($this->conexion, "insert into show values ('$show_id', '$date_of_show', '$show_room_id', '$complex_id', '$movie_id')");	
		return @oci_execute($query);
	}
	
	function updateShow($show_id, $date_of_show, $show_room_id, $complex_id, $movie_id){
		$show_id = escape_quotes($show_id);
		$date_of_show = escape_quotes($date_of_show);
		$show_room_id = escape_quotes($show_room_id);
		$complex_id = escape_quotes($complex_id);
		$movie_id = escape_quotes($movie_id);
		$query = oci_parse($this->conexion, "update show set date_of_show='$date_of_show', show_room_id='$show_room_id', complex_id='$complex_id', movie_id='$movie_id' where show_id='$show_id'");	
		return @oci_execute($query);
	}
	
	function verify($role){
		if($role != $_SESSION["userrole"]){
			header('Location: login.php?err=2');
		}
	}
	
	function verifyComplex($complex){		
		if($complex != $_SESSION["complex_id"]){
			header('Location: login.php?err=3');
		}
	}
	
	function getEmployeeID(){
		return $_SESSION["EMPLOYEE_ID"];
	}
	
	function getUser(){
		if (isset($_SESSION["username"])) {
			echo "Welcome ".$_SESSION["username"];
		}
	}
	
	function getRoles(){
		$query = oci_parse($this->conexion, "SELECT ROLE_ID, NAME from userrole");
		oci_execute($query);
		while($row=oci_fetch_array($query)){
			echo '<option value="'.$row['ROLE_ID'].'">'.$row['NAME'].'</option>';
		}
	}
	
	function available_sits($SHOW_ID){
		$query = oci_parse($this->conexion, "select a.num-b.num AVAILABLE_SITS from(
(select no_spots as num from show_room where show_room_id=
(select show_room_id from ticket natural join show where show_id='$SHOW_ID' group by show_room_id)) a
CROSS JOIN
(select count(show_id) as num from ticket natural join show where show_id='$SHOW_ID' group by show_room_id) b
);");
		oci_execute($query);
		return $row['AVAILABLE_SITS'];
	}
	
	function __destruct(){
		oci_close($this->conexion);
	}
}
?>