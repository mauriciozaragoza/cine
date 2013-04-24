<?php
	require_once("driver.php");
	$driver = new dbDriver();
	$driver->getMoviesByComplex($_POST['complex']);
?>