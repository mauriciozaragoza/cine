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

$show_id = '';
$date_show = '';
$complex = '';
$show_room = '';
$movie = '';

if ($creating) {
	if (isset($_GET["submit"])) {
		$date_show = $_POST["date_show"];
		$complex = $_POST["complex"];
		$show_room = $_POST["show_room"];
		$movie = $_POST["movie"];
		
		$success = $driver->addShow($date_show, $show_room, $complex, $movie);
		header("Location: show.php?msg=".($success ? 1 : 4));
		exit();
	}
}
else if ($editing) {
	if (isset($_GET["submit"])) {
		$show_id = $_GET["edit"];
		$date_show = $_POST["date_show"];
		$complex = $_POST["complex"];
		$show_room = $_POST["show_room"];
		$movie = $_POST["movie"];
		
		$success = $driver->updateShow($show_id, $date_show, $show_room, $complex, $movie);
		if ($success) {
			header("Location: show.php?msg=2");
		}
		else {
			$msg = 5;
		}
	}

	$show = $driver->getShow($_GET["edit"]);
	$show_id = $show["show_id"];
	$date_show = $show["date_of_show"];
	$complex = $show["complex_id"];
	$show_room = $show["show_room_id"];
	$movie = $show["movie_id"];
}
else if ($deleting) {
	$success = $driver->deleteShow($_GET["delete"]);
	header("Location: show.php?msg=".($success ? 3 : 6));
	exit();
}
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Ipsum Cinemas :: Shows</title>
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/foundation.css" />
	<script src="js/vendor/custom.modernizr.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
	<script src="js/jquery.validate.js" ></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$("#complex").change(function() {
			$("#movie").load("movie_loader.php", {}, function() {
				$(this).prepend('<option disabled selected="selected">Pick a movie</option>');
			});
			$("#show_room").load("showroom_loader.php", {"complex":$(this).val()}, function() {
				$(this).prepend('<option disabled selected="selected">Pick a showroom</option>');
			});
		});
		
		<?php
		if ($editing || $creating) {
			echo '$("#date_show").datepicker({dateFormat: \'d-M-y\'});';
			echo '$("#show_form").validate();';
		}
		
		if ($editing) {
			echo '$("#complex").val("'.$complex.'");';
			echo '$("#movie").val("'.$movie.'");';
			echo '$("#show_room").val("'.$show_room.'");';
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
					  Could not delete show, tickets were already bought
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				}
				?>
				<?php
				if ($reading) {
					$driver->getShowsByComplex();
					echo "<a href='show.php?create' class='small button'>Add new show</a>";
				}
				else {
				?>
                <form action="show.php?submit<?php echo $editing ? "&edit=$show_id" : "&create"; ?>" id="show_form" method="POST">
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
								<select id="complex" name="complex" class="required">
								<option selected disabled>Pick a complex</option>
								<?php $driver->getComplex(); ?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="show_room">Show room *</label>
								<select id="show_room" name="show_room" class="required">
								<?php 
								if ($editing) {
									$driver->getShowroomsByComplex($complex);
								}
								?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="movie">Movie *</label>
								<select id="movie" name="movie" class="required">
								<?php 
								if ($editing) {
									$driver->getAllMovies();
								}
								?>
								</select>
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