<?php
	require_once("driver.php");
	$driver = new dbDriver();
	if (isset($_POST['complex'])) {
		$driver->getMoviesByComplex($_POST['complex']);
	}
	else {
		$driver->getAllMovies();
	}
?>