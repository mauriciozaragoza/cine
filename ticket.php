<?php
require_once("driver.php");
require_once("layout.php");

$driver = new dbDriver();
if (!$driver->isLogged() || !isset($_GET["show"]) {
	header("Location: catalog.php");
	exit();
}

$success = true;
$show_id = $_GET["show"];

?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Ipsum Cinemas :: Sell tickets</title>
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
		
		<?php
		if ($editing) {
			echo '$("#complex").val("'.$complex.'");';
			echo '$("#role").val("'.$role.'");';
		}
		?>
	});
	
	</script>
</head>
<body>
	<?php print_header($driver); ?>
	<div class="row">
		<div class="large-12 columns">
			<form action="ticket.php?submit" id="ticket_form" method="POST">
				<fieldset>
					<legend>Sell tickets</legend>
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
							<label for="payform">Payment method *</label>
							<select id="payform" name="payform">
							<?php $driver->getPayforms(); ?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="large-4 columns">
							<label for="amount">Amount</label>
							<input type="text" id="amount" value="$<?php echo dbDriver::TICKETCOST; ?>" readonly/>
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
					<input type="submit" value="<?php echo $editing ? "Edit" : "Create"; ?>" />
				</fieldset>
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