<?php
if (!(isset($_GET["complex"]) && isset($_GET["city"]))) {
	header("Location: index.php");
	die();
}

require_once("driver.php");
require_once("layout.php");

$driver = new dbDriver();

$movie_id = $_GET["complex"];
$complex_id = $_GET["city"];

$movie = $driver->getMovie($movie_id);
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Ipsum Cinemas :: Catalog</title>
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/foundation.css" />
  <script src="js/vendor/custom.modernizr.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
  <script type="text/javascript">
  
  </script>
</head>
<body>
	<?php print_header($driver); ?>
	<div class="row">
		<div class="large-12 columns">
			<h2>Catalog</h2>

			<!-- Grid Example -->
			<div class="row">
                <div class="large-3 columns">
                    <img src="http://placehold.it/230x266" />
                </div>
                <div class="large-9 columns">
                    <h3><?php echo $movie["name"] ?></h3>
					<h5>Director: <?php echo $movie["director"] ?></h5>
					<h5>Rating: <?php echo $movie["rating"] ?></h5>
                    <p><?php echo $movie["description"] ?></p>
                </div>
			</div>
        </div>
	</div>
    
    <div class="row">
		<div class="large-12 columns">
        <br/>
            <?php $driver->getShows($complex_id, $movie_id); ?>
            <ul class="pagination">
              <li class="arrow unavailable"><a href="">&laquo;</a></li>
              <li class="current"><a href="">1</a></li>
              <li><a href="">2</a></li>
              <li><a href="">3</a></li>
              <li><a href="">4</a></li>
              <li class="unavailable"><a href="">&hellip;</a></li>
              <li><a href="">12</a></li>
              <li><a href="">13</a></li>
              <li class="arrow"><a href="">&raquo;</a></li>
            </ul>
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