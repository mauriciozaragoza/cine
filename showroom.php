<?php
	require_once("driver.php");
	$driver = new dbDriver();
	$driver->getShowroomsByComplex($_POST['complex']);
?>