<?php
	require_once("driver.php");
	$driver = new dbDriver();
	$driver->getComplexByCity($_POST["city"]);
?>