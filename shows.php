<?php
	$driver = new dbDriver();
	$driver->getShows($_GET['complex'],$_GET['movie']);
?>