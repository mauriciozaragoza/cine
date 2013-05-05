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

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Ipsum Cinemas</title>
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/foundation.css" />
  <script src="js/vendor/custom.modernizr.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
  <script type="text/javascript">
  </script>
</head>
<body>
    <?php print_header($driver); ?>
	<div class="row">
		<div class="large-12 columns">
			<h3>Admin panel</h3>			
			
			<div class="row">
				<div class="large-12 columns">
				<a href="employee.php">Employees</a><br />
				<a href="movie.php">Movies</a><br />
				<a href="show.php">Shows</a><br />
				<a href="complex.php">Complex</a><br />
				</div>
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
