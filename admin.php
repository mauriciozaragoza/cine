<?php
require_once("driver.php");
require_once("layout.php");

$driver = new dbDriver();
$driver->verify("U00");
?>

<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Ipsum Cinemas</title>
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/foundation.css" />
	<script src="js/vendor/custom.modernizr.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script type="text/javascript">
	</script>

  <style>
		body {background-image:url('img/background/fondo.jpg');}
		background-repeat: no-repeat;
		background-attachment: fixed;
	</style>
</head>
<body>
    <?php print_header($driver); ?>
	<div class="row">
		<div class="large-12 columns">
			<h3>Admin panel</h3>			
			
			<div class="row">
			<table>
			<tr><td width=600>Option</td><td>Edit</td></tr>
				<tr><td>Employees</td><td><a href="employee.php" class="small button">Edit<br>Employees</a></td></tr>
				<tr><td>Movies </td><td><a href="movie.php" class="small button">Edit<br>Movies</a></td></tr>
				<tr><td>Shows</td><td><a href="show.php" class="small button">Edit<br>Shows</a></td></tr>
				<tr><td>Complexes</td><td><a href="complex.php" class="small button">Edit<br>Complexes</a></td></tr>
			</table>
			</div>
        </div>
	</div>    
	<?php print_footer(); ?>
  <script>
  document.write('<script src=' +
  ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
  '.js><\/script>')
  </script>
  
  <script src="js/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>
</body>
</html>
