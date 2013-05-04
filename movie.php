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

$movie_id = '';
$name = '';
$rating = '';
$director = '';
$actors = '';
$description = '';
$language = '';
$path = '';
$path_banner = '';

if ($creating) {
	if (isset($_GET["submit"])) {
		$sent = true;
		$movie_id = $editing ? $_GET["edit"] : $_POST["movie_id"];
		$name = $_POST["name"];
		$rating = $_POST["rating"];
		$director = $_POST["director"];
		$actors = $_POST["actors"];
		$description = $_POST["description"];
		$language = $_POST["language"];
		$path = $_POST["path"];
		$path_banner = $_POST["path_banner"];
		
		$success = $driver->addMovie($movie_id, $name, $rating, $director, $actors, $description, $language, $path, $path_banner);
		header("Location: movie.php?msg=".($success ? 1 : 4));
		exit();
	}
}
else if ($editing) {
	if (isset($_GET["submit"])) {
		$sent = true;
		$movie_id = $editing ? $_GET["edit"] : $_POST["movie_id"];
		$name = $_POST["name"];
		$rating = $_POST["rating"];
		$director = $_POST["director"];
		$actors = $_POST["actors"];
		$description = $_POST["description"];
		$language = $_POST["language"];
		$path = $_POST["path"];
		$path_banner = $_POST["path_banner"];
		
		$success = $driver->updateMovie($movie_id, $name, $rating, $director, $actors, $description, $language, $path, $path_banner);
		if ($success) {
			header("Location: movie.php?msg=2");
		}
		else {
			$msg = 5;
		}
	}
	
	$movie = $driver->getMovie($_GET["edit"]);
	$movie_id = $movie["movie_id"];
	$name = $movie["name"];
	$rating = $movie["rating"];
	$director = $movie["director"];
	$actors = $movie["actors"];
	$description = $movie["description"];
	$language = $movie["language"];
	$path = $movie["path"];
	$path_banner = $movie["path_banner"];
}
else if ($deleting) {
	$success = $driver->deleteMovie($_GET["delete"]);
	header("Location: movie.php?msg=".($success ? 3 : 6));
	exit();
}
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Ipsum Cinemas :: Movies</title>
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
		}
		
		if ($editing) {
			echo '$("#complex").val("'.$complex.'");';
			echo '$("#role").val("'.$role.'");';
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
		?>
	});
	
	</script>
</head>
<body>
	<?php print_header($driver); ?>
	<div class="row">
		<div class="large-12 columns">
			<h2>Movies</h2>
			<div class="row">
				<?php
				switch ($msg) {
				case 1:
					?>
					<div data-alert class="alert-box success">
					  Movie added successfully
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 2:
					?>
					<div data-alert class="alert-box success">
					  Movie updated successfully
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				case 3:
					?>
					<div data-alert class="alert-box success">
					  Movie deleted successfully
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
					  Could not delete Movie
					  <a href="#" class="close">&times;</a>
					</div>
					<?php
					break;
				}
				?>
				<?php
				if ($reading) {
					$driver->getMovies();
					echo "<a href='movie.php?create' class='small button'>Add new movie</a>";
				}
				else {
				?>
                <form action="movie.php?submit<?php echo $editing ? "&edit=$movie_id" : "&create"; ?>" id="employee_form" method="POST">
					<fieldset>
						<legend><?php echo $editing ? "Edit" : "Add" ?> movie</legend>
						<div class="row">
							<div class="large-4 columns">
								<label for="movie_id">ID *</label>
								<input type="text" id="movie_id" name="movie_id" value="<?php echo $movie_id ?>" class="required" <?php echo $editing ? "readonly" : "" ?>/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="name">Movie title *</label>
								<input type="text" name="name" value="<?php echo $name ?>" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="rating">Rating</label>
								<input type="text" name="rating" value="<?php echo $rating ?>"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="director">Director *</label>
								<input type="text" name="director" value="<?php echo $director ?>" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="actors">Actors *</label>
								<textarea name="actors"><?php echo $actors ?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="description">Description</label>
								<textarea name="description"><?php echo $description ?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="language">Language *</label>
								<input type="text" name="language" value="<?php echo $language ?>" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="path">Picture *</label>
								<input type="text" name="path" value="<?php echo $path ?>" class="required"/>
							</div>
						</div>
						<div class="row">
							<div class="large-4 columns">
								<label for="path_banner">Banner picture *</label>
								<input type="text" name="path_banner" value="<?php echo $path_banner ?>" class="required"/>
							</div>
						</div>
						<br />
						<input type="submit" class="small button" value="<?php echo $editing ? "Edit" : "Create"; ?>" />
						<a href='movie.php' class='small button alert'>Cancel</a>
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