<?php
include("driver.php");

$driver = new dbDriver();

//$driver->login('erosespinola', 'trololo');
$_SESSION["complex_id"] = "C0001";
$driver->getRooms('C0001');
?>

