<?php
require_once("driver.php");
require_once("layout.php");

$driver = new dbDriver();
$driver->verify("U00");

$success = true;
$sent = false;
$editing = isset($_GET["edit"]);
$creating = isset($_GET["create"]);
$deleting = isset($_GET["delete"]);
$reading = !($editing || $creating || $deleting);

$msg = isset($_GET["msg"]) ? $_GET["msg"] : 0;

$employee_id = '';
$username = '';
$password = '';
$first_name = '';
$last_name = '';
$role = '';
$complex = '';

// if ($creating) {
	// if (isset($_GET["submit"])) {
		// $sent = true;
		// $employee_id = $editing ? $_GET["edit"] : $_POST["employee_id"];
		// $username = $_POST["username"];
		// $password = $_POST["password"];
		// $first_name = $_POST["first_name"];
		// $last_name = $_POST["last_name"];
		// $role = $_POST["role"];
		// $complex = $_POST["complex"];
		
		// //$success = $driver->addEmployee($employee_id, $username, $password, $first_name, $last_name, $role, $complex);
		// header("Location: employee.php?msg=".($success ? 1 : 4));
		// exit();
	// }
// }
// else if ($editing) {
	// if (isset($_GET["submit"])) {
		// $sent = true;
		// $employee_id = $editing ? $_GET["edit"] : $_POST["employee_id"];
		// $username = $_POST["username"];
		// $password = $_POST["password"] == "*****" ? $password : $_POST["password"];
		// $first_name = $_POST["first_name"];
		// $last_name = $_POST["last_name"];
		// $role = $_POST["role"];
		// $complex = $_POST["complex"];
		
		// //$success = $driver->updateEmployee($employee_id, $username, $password, $first_name, $last_name, $role, $complex);
		// $msg = $success ? 2 : 5;
	// }
	
	// $employee = $driver->getEmployee($_GET["edit"]);
	// $employee_id = $employee["employee_id"];
	// $username =  $employee["username"];
	// $first_name = $employee["first_name"];
	// $last_name = $employee["last_name"];
	// $role = $employee["role_id"];
	// $complex = $employee["complex_id"];
// }
// else if ($deleting) {
	// $employee = $driver->getEmployee($_GET["delete"]);
	// $complex = $employee["complex_id"];
	
	// $driver->verifyComplex($complex);
	// $driver->deleteEmployee($_GET["delete"]);
	// header("Location: employee.php?msg=".($success ? 3 : 6));
	// exit();
// }
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Ipsum Cinemas :: Ticket</title>
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/foundation.css" />
	<script src="js/vendor/custom.modernizr.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	<script src="js/jquery.validate.js" ></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$("#show_form").validate();
		$("#date_show").datepicker();
		
		$("#complex").change(function() {
			$("#movie").load("movies_by_complex.php", {"complex":$(this).val()}, function() {
				$(this).prepend('<option disabled selected="selected">Choose your movie</option>');
			});
		});
		
		<?php
		if ($editing) {
			echo '$("#complex").val("'.$complex.'");';
			echo '$("#movie").val("'.$movie.'");';
		}
		?>
	});
	
	</script>
</head>
<body>
	<?php print_header($driver); ?>
	<div class="row">
		<div class="large-12 columns">
			<h2>Shows</h2>

			<!-- Grid Example -->
			<div class="row">
				<?php
				switch ($msg) {
				case 1:
					?>
					<div data-alert class="alert-box success">
					  Show added successfully
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 2:
					?>
					<div data-alert class="alert-box success">
					  Show updated successfully
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 3:
					?>
					<div data-alert class="alert-box success">
					  Show deleted successfully
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
					  Could not delete show
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				}
				?>
				<?php
				if ($reading) {
					$driver->getShowsAdmin();
				}
				else {
				?>
                <form action="show.php?submit<?php echo $editing ? "&edit=$show_id" : ""; ?>" id="show_form" method="POST">
					<fieldset>
						<legend><?php echo $editing ? "Edit" : "Add" ?> show</legend>
						<div class="row">
							<div class="large-4 columns">
								<label for="date_show">Date of show *</label>
								<input type="text" id="date_show" name="date_show" value="<?php echo $editing ? $date_show : ""; ?>" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="complex">Complex *</label>
								<select id="complex" name="complex">
								<?php $driver->getComplex(); ?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="show_room">Show room *</label>
								<select id="show_room" name="show_room">
								</select>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="movie">Movie *</label>
								<select id="movie" name="movie">
								</select>
							</div>
						</div>
						<input type="submit" value="<?php echo $editing ? "Edit" : "Create"; ?>" />
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