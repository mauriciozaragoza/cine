<?php
require_once("driver.php");
require_once("layout.php");

$driver = new dbDriver();
?>

<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Ipsum Cinemas</title>
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/foundation.css" />
	<script src="js/vendor/custom.modernizr.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$("#complex_panel").hide();
		$("#movie_panel").hide();
		$("#catalog_button").hide();

		$("#city").change(function() {
			$("#loader1").show();
			$("#complex").load("complex.php", {"city":$(this).val()}, function() {
				$(this).prepend('<option disabled selected="selected">Choose your complex</option>');
				$("#loader1").hide();
			});
			$("#complex_panel").slideDown();
		});
		
		$("#complex").change(function() {
			$("#loader2").show();
			$("#movie").load("movies_by_complex.php", {"complex":$(this).val()}, function() {
				$("#loader2").hide();
				$(this).prepend('<option disabled selected="selected">Choose your movie</option>');
			});
			$("#movie_panel").slideDown();
		});
		$("#movie").change(function() {
			$("#catalog_button").fadeIn();
		});
	});
	</script>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Ipsum Cinemas</title>
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/foundation.css" />
  <script src="js/vendor/custom.modernizr.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
  <script type="text/javascript">
  </script>
</head>
<body>
    <?php print_header($driver); ?>
	<div class="row" >
		<div class="large-8 large-centered columns"align="center">
			<ul data-orbit>
			  <li>
				<img src="img/banner/IronMan3.jpg" />
				<div class="orbit-caption">Ironman 3</div>
			  </li>
			  <li>
				<img src="img/banner/LOTR.jpg" />
				<div class="orbit-caption">Lord of the Rings</div>
			  </li>
			  <li>
				<img src="img/banner/GangsterPokeSquad.png" />
				<div class="orbit-caption">Gangster PokeSquad</div>
			  </li>
			  <li>
				<img src="img/banner/Avengers.jpg" />
				<div class="orbit-caption">The Avengers</div>
			  </li>
			</ul>
		</div>
	</div>

	<div class="row">
		<div class="large-12 columns">
			<h3>Catalog</h3>			
			<!-- Grid Example -->
			<div class="row">
				<div class="large-12 columns">
                <form id="catalog_form" method="GET" action="catalog.php">
					<div id="city-panel" class="panel">
						<label for="city">City</label>
						<select id="city" name="city">
						<option disabled selected="selected">Choose your city</option>
						<?php $driver->getCities(); ?>
						</select>
					</div>
					<div id="complex_panel" class="panel">
						<img id="loader1" src="img/loader1.gif" />
						<label for="complex">Complex</label>
						<select id="complex" name="complex">
						</select>
					</div>
					<div id="movie_panel" class="panel">
						<img id="loader2" src="img/loader1.gif" />
						<label for="movie">Movie</label>
						<select id="movie" name="movie">
						</select>
					</div>
					<input type="submit" id="catalog_button" class="button" value="Catalog" />
				</form>
				</div>
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
