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

$employee_id = '';
$username = '';
$password = '';
$first_name = '';
$last_name = '';
$role = '';
$complex = '';

if ($creating) {
	if (isset($_GET["submit"])) {
		$employee_id = $_POST["employee_id"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$first_name = $_POST["first_name"];
		$last_name = $_POST["last_name"];
		$role = $_POST["role"];
		$complex = $_POST["complex"];
		
		$success = $driver->addEmployee($employee_id, $username, $password, $first_name, $last_name, $role, $complex);
		header("Location: employee.php?msg=".($success ? 1 : 4));
		exit();
	}
}
else if ($editing) {
	if (isset($_GET["submit"])) {
		$employee_id = $_GET["edit"];
		$username = $_POST["username"];
		$password = $_POST["password"] == "*****" ? $password : $_POST["password"];
		$first_name = $_POST["first_name"];
		$last_name = $_POST["last_name"];
		$role = $_POST["role"];
		$complex = $_POST["complex"];
		
		$success = $driver->updateEmployee($employee_id, $username, $password, $first_name, $last_name, $role, $complex);
		if ($success) {
			header("Location: employee.php?msg=2");
		}
		else {
			$msg = 5;
		}
	}
	
	$employee = $driver->getEmployee($_GET["edit"]);
	$employee_id = $employee["employee_id"];
	$username =  $employee["username"];
	$first_name = $employee["first_name"];
	$last_name = $employee["last_name"];
	$role = $employee["role_id"];
	$complex = $employee["complex_id"];
}
else if ($deleting) {
	$success = $driver->deleteEmployee($_GET["delete"]);
	header("Location: employee.php?msg=".($success ? 3 : 6));
	exit();
}
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Ipsum Cinemas :: Employees</title>
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/foundation.css" />
	<script src="js/vendor/custom.modernizr.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="js/jquery.validate.js" ></script>
	<script type="text/javascript">
	$(document).ready(function() {
		<?php
		if ($editing || $creating) {
			echo '$("#date_show").datepicker({dateFormat: \'d-M-y\'});';
			
			?>
			$("#employee_form").validate();
			$.validator.addMethod(
				"regex",
				function(value, element, regexp) {
					var re = new RegExp(regexp);
					return this.optional(element) || re.test(value);
				},
				"Please check your input"
			);
			$("#employee_id").rules("add", { regex: "E[0-9]{4}" });
			<?php
		}
		
		if ($editing) {
			echo '$("#complex").val("'.$complex.'");';
			echo '$("#role").val("'.$role.'");';
		}
		?>
	});
	
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
			<h2>Employees</h2>

			
			<div class="row">
				<?php
				switch ($msg) {
				case 1:
					?>
					<div data-alert class="alert-box success">
					  Employee added successfully
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 2:
					?>
					<div data-alert class="alert-box success">
					  Employee updated successfully
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 3:
					?>
					<div data-alert class="alert-box success">
					  Employee deleted successfully
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
					  Could not delete employee
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				}
				?>
				<?php
				if ($reading) {
					$driver->getEmployees();
					echo "<a href='employee.php?create' class='small button'>Add new employee</a>";
				}
				else {
				?>
                <form action="employee.php?submit<?php echo $editing ? "&edit=$employee_id" : "&create"; ?>" id="employee_form" method="POST">
					<fieldset>
						<legend><?php echo $editing ? "Edit" : "Add" ?> employee</legend>
						<div class="row">
							<div class="large-4 columns">
								<label for="employee_id">ID *</label>
								<input type="text" id="employee_id" name="employee_id" value="<?php echo $employee_id ?>" class="required" <?php echo $editing ? "readonly" : "" ?>/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="username">Username *</label>
								<input type="text" name="username" value="<?php echo $username ?>" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="password">Password <?php echo $editing ? "*" : ""; ?> </label>
								<input type="password" name="password" value="<?php echo $editing ? '*****' : ""; ?>" <?php echo $editing ? 'class="required"' : ""; ?> />
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="first_name">First name *</label>
								<input type="text" name="first_name" value="<?php echo $first_name ?>" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="last_name">Last name *</label>
								<input type="text" name="last_name" value="<?php echo $last_name ?>" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="role">Role *</label>
								<select id="role" name="role">
								<?php $driver->getRoles(); ?>
								</select>
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
						<br />
						<input type="submit" class="small button" value="<?php echo $editing ? "Edit" : "Create"; ?>" />
						<a href='employee.php' class='small button alert'>Cancel</a>
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