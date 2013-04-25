<?php
require_once("driver.php");
require_once("layout.php");

$driver = new dbDriver();
$driver->verify("U00");

$success = true;
$sent = false;

if (isset($_POST["employee_id"])) {
	$sent = true;
	$employee_id = $_POST["employee_id"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$role = $_POST["role"];
	$complex = $_POST["complex"];
	
	$success = $driver->addEmployee($employee_id, $username, $password, $first_name, $last_name, $role, $complex);
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
	});
	</script>
</head>
<body>
	<?php print_header($driver); ?>
	<div class="row">
		<div class="large-12 columns">
			<h2>Employees</h2>

			<!-- Grid Example -->
			<div class="row">
				<?php
				if ($sent) {
					if ($success) {
					?>
						<div data-alert class="alert-box success">
						  Employee added successfully
						  <a href="#" class="close">&times;</a>
						</div>
					<?php 
					} else {
					?>
						<div data-alert class="alert-box alert">
						  Invalid employee information
						  <a href="#" class="close">&times;</a>
						</div>
					<?php 
					}
				}
				?>
                <form action="employee.php" id="employee_form" method="POST">
					<fieldset>
						<legend>Add employee</legend>
						<div class="row">
							<div class="large-4 columns">
								<label for="employee_id">ID *</label>
								<input type="text" id="employee_id" name="employee_id" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="username">Username *</label>
								<input type="text" name="username" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="password">Password *</label>
								<input type="password" name="password" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="first_name">First name *</label>
								<input type="text" name="first_name" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="last_name">Last name *</label>
								<input type="text" name="last_name" class="required"/>
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
						<input type="submit" value="Create" />
					</fieldset>
				</form>
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