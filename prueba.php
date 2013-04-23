<?php
include("driver.php");

$driver = new dbDriver();
$driver->login('erosespinola', 'trololo');

$driver->getUser();

?>