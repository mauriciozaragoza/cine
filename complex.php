<?php
	require_once("driver.php");
	$driver = new dbDriver();
	$driver->getComplex($_GET['city']);
?>