<?php
	$driver = new dbDriver();
	$driver->getMoviesByComplex($_GET['complex']);
?>