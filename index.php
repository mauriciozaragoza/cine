<?php
include("driver.php");

$driver = new dbDriver();
$driver->login('erosespinola', 'trololo');

if (isset($_SESSION["username"])) {
	$driver->addEmployee('E0002','jbananas','bananitas','Juan','Bananas','U01','C0001');
}

?>