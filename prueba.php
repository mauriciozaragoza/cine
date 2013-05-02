<?php
include("driver.php");

$driver = new dbDriver();

//$driver->login('erosespinola', 'trololo');

$driver->getEmployees("C0001");
?>