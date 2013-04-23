<?php
include("driver.php");

$driver = new dbDriver();
$driver->login('erosespinola', 'trololo');

$a = $driver->getMovie('M0001');
echo $a['name'];

?>