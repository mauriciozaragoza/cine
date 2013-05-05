<?php
require_once("driver.php");
require_once("layout.php");

$driver = new dbDriver();
if (!$driver->isLogged() || !isset($_GET["show"])) {
	header("Location: index.php");
	exit();
}

$success = true;
$show_id = $_GET["show"];

if (isset($_GET["submit"])) {
	$success = $driver->sell_tickets($_POST["payform"], $show_id, $_POST["no_tickets"], $driver->getEmployeeID());
}

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
		$("#ticket_form").validate();
		
		$("#no_tickets").change(function() {
			$("#amount").val("$" + ($(this).val() * <?php echo dbDriver::TICKETCOST; ?>));
		});
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
			<form action="ticket.php?submit&show=<?php echo $show_id; ?>" id="ticket_form" method="POST">
				<fieldset>
					<legend>Sell tickets</legend>
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
							<label for="no_tickets">Quantity *</label>
							<input type="text" id="no_tickets" name="no_tickets" value="1" class="required number"/>
						</div>
					</div>
					<div class="row">
					<?php 
						$available_seats = $driver->available_seats($show_id);
						$total_seats = $driver->total_seats($show_id);
						
						echo "$available_seats available seats (out of $total_seats)";
					?>
					<div class="progress success small-4"><span class="meter" style="width: <?php echo ($total_seats - $available_seats) / $total_seats * 100.0; ?>%"></span></div>
						<div class="large-4 columns">
							<label for="amount">Amount</label>
							<input type="text" id="amount" value="$<?php echo dbDriver::TICKETCOST; ?>" readonly />
						</div>
					</div>
					<input type="submit" class="small button" value="Purchase" />
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