<?php
require_once("driver.php");
require_once("layout.php");

$driver = new dbDriver();
$driver->verify("U00");

$success = true;

$editing = isset($_GET["edit"]);
$creating = isset($_GET["create"]);
$deleting = isset($_GET["delete"]);
$reading = !($editing || $creating || $deleting);

$msg = isset($_GET["msg"]) ? $_GET["msg"] : 0;

$complex_id = '';
$name = '';
$city = '';

if ($creating) {
	if (isset($_GET["submit"])) {
		$complex_id = $_POST["complex_id"];
		$name = $_POST["name"];
		$city = $_POST["city"];
		
		$success = $driver->addComplex($complex_id, $name, $city);
		header("Location: complex.php?msg=".($success ? 1 : 4));
		exit();
	}
}
else if ($editing) {
	if (isset($_GET["submit"])) {
		$complex_id = $_GET["edit"];
		$name = $_POST["name"];
		$city = $_POST["city"];
		
		$success = $driver->updateComplex($complex_id, $name, $city);
		if ($success) {
			header("Location: complex.php?msg=2");
		}
		else {
			$msg = 5;
		}
	}

	$complex = $driver->getComplexArray($_GET["edit"]);
	$complex_id = $complex["complex_id"];
	$name = $complex["name"];
	$city = $complex["city"];
}
else if ($deleting) {
	$success = $driver->deleteComplex($_GET["delete"]);
	header("Location: complex.php?msg=".($success ? 3 : 6));
	exit();
}
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Ipsum Cinemas :: Complex</title>
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/foundation.css" />
	<script src="js/vendor/custom.modernizr.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	<script src="js/jquery.validate.js" ></script>
	<script type="text/javascript">
	$(document).ready(function() {
		<?php
		if ($editing || $creating) {
			echo '$("#complex_form").validate();';
		}
		?>
	});
	
	</script>
</head>
<body>
	<?php print_header($driver); ?>
	<div class="row">
		<div class="large-12 columns">
			<h2>Complex</h2>

			
			<div class="row">
				<?php
				switch ($msg) {
				case 1:
					?>
					<div data-alert class="alert-box success">
					  Complex added successfully
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 2:
					?>
					<div data-alert class="alert-box success">
					  Complex updated successfully
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 3:
					?>
					<div data-alert class="alert-box success">
					  Complex deleted successfully
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 4: case 5:
					?>
					<div data-alert class="alert-box alert">
					  Invalid information
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 6:
					?>
					<div data-alert class="alert-box alert">
					  Could not delete complex
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				}
				?>
				<?php
				if ($reading) {
					$driver->getComplexes();
					echo "<a href='complex.php?create' class='small button'>Add new complex</a>";
				}
				else {
				?>
                <form action="complex.php?submit<?php echo $editing ? "&edit=$complex_id" : "&create"; ?>" id="complex_form" method="POST">
					<fieldset>
						<legend><?php echo $editing ? "Edit" : "Add" ?> complex</legend>
						<div class="row">
							<div class="large-4 columns">
								<label for="complex_id">ID *</label>
								<input type="text" id="complex_id" name="complex_id" value="<?php echo $complex_id ?>" class="required" <?php echo $editing ? "readonly" : "" ?>/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="name">Name *</label>
								<input type="text" name="name" value="<?php echo $name ?>" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="city">City *</label>
								<input type="text" name="city" value="<?php echo $city ?>" class="required"/>
							</div>
						</div>
						<input type="submit" class="small button" value="<?php echo $editing ? "Edit" : "Create"; ?>" />
						<a href='complex.php' class='small button alert'>Cancel</a>
					</fieldset>
				</form>
				<?php
				}
				?>
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