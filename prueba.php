<?php
include("driver.php");

$driver = new dbDriver();
$driver->login('erosespinola', 'trololo');

echo $driver->getMovie('M0001');

?>