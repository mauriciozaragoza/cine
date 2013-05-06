<?php
require_once("driver.php");
require_once("layout.php");

$driver = new dbDriver();

if (isset($_POST["user"])) {
	$driver->login($_POST["user"], $_POST["password"]);
}
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Ipsum Cinemas :: Login</title>
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/foundation.css" />
  <script src="js/vendor/custom.modernizr.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
  <script type="text/javascript">
  </script>
</head>
<body>
	<?php 
	print_header($driver); 
	?>
	<div class="row">
		<div class="large-12 columns">
			<h2>Login</h2>
			<?php
			if (isset($_GET["err"])) {
				switch ($_GET["err"]) {
					case 1:
					?>
					<div data-alert class="alert-box alert">
					  Invalid login
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
					case 2:
					?>
					<div data-alert class="alert-box alert">
					  Insufficient privileges
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
					case 3:
					?>
					<div data-alert class="alert-box alert">
					  You do not belong to this complex.
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				}
			}
			?>
            <form action="login.php" method="POST">
				<label for="user">Username</label>
				<input name="user" type="text" />
				<label for="password">Password</label>
				<input name="password" type="password" />
				<input type="submit" value="Log-in" />
            </form>
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