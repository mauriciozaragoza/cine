<?php
require_once("driver.php");
require_once("layout.php");

$driver = new dbDriver();
$driver->verify("U00");

$success = true;

// complex must be specified
if (!isset($_GET["complex"])) {
	header("Location: .php?");
}

$editing = isset($_GET["edit"]);
$creating = isset($_GET["create"]);
$deleting = isset($_GET["delete"]);
$reading = !($editing || $creating || $deleting);

$msg = isset($_GET["msg"]) ? $_GET["msg"] : 0;

$show_room_id = '';
$complex_id = $_GET["complex"];
$no_spots = '';

if ($creating) {
	if (isset($_GET["submit"])) {
		$show_room_id = $_POST["show_room_id"];
		$no_spots = $_POST["no_spots"];
		
		$success = $driver->addRoom($show_room_id, $complex_id, $no_spots);
		header("Location: showroom.php?msg=".($success ? 1 : 4));
		exit();
	}
}
else if ($editing) {
	if (isset($_GET["submit"])) {
		$show_room_id = $_GET["edit"];
		$no_spots = $_POST["no_spots"];
		
		$success = $driver->updateRoom($show_id, $date_show, $show_room, $complex, $movie);
		if ($success) {
			header("Location: showroom.php?msg=2");
		}
		else {
			$msg = 5;
		}
	}

	$show_room = $driver->getRoom($_GET["edit"]);
	$show_room_id = $show_room["show_room_id"];
	$complex_id = $show_room["complex_id"];
	$no_spots = $show_room["no_spots"];
}
else if ($deleting) {
	$success = $driver->deleteRoom($_GET["delete"]);
	header("Location: showroom.php?msg=".($success ? 3 : 6));
	exit();
}
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Ipsum Cinemas :: Showrooms</title>
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
			echo '$("#showroom_form").validate();';
		}
		?>
	});
	
	</script>
</head>
<body>
	<?php print_header($driver); ?>
	<div class="row">
		<div class="large-12 columns">
			<h2>Showrooms for <?php echo $driver->getComplexArray($complex_id)["name"]; ?></h2>

			<div class="row">
				<?php
				switch ($msg) {
				case 1:
					?>
					<div data-alert class="alert-box success">
					  Showroom added successfully
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 2:
					?>
					<div data-alert class="alert-box success">
					  Showroom updated successfully
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 3:
					?>
					<div data-alert class="alert-box success">
					  Showroom deleted successfully
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
					  Could not delete showroom
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				}
				?>
				<?php
				if ($reading) {
					$driver->getRooms($complex_id);
					echo "<a href='showroom.php?create' class='small button'>Add new showroom</a>";
				}
				else {
				?>
                <form action="showroom.php?submit<?php echo $editing ? "&edit=$show_id" : "&create"; ?>" id="showroom_form" method="POST">
					<fieldset>
						<legend><?php echo $editing ? "Edit" : "Add" ?> showroom</legend>
						<div class="row">
							<div class="large-4 columns">
								<label for="showroom_id">ID *</label>
								<input type="text" id="showroom_id" name="showroom_id" value="<?php echo $showroom_id ?>" class="required" <?php echo $editing ? "readonly" : "" ?>/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="name">Number of spots *</label>
								<input type="text" name="name" value="<?php echo $name ?>" class="required number"/>
							</div>
						</div>
						<input type="submit" class="small button" value="<?php echo $editing ? "Edit" : "Create"; ?>" />
						<a href='show.php' class='small button alert'>Cancel</a>
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