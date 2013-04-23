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
	alert("omg");
  });
  </script>
</head>
<body>
    <?php print_header($driver); ?>
	<div class="row">
		<div class="large-8 columns">
			<ul data-orbit>
			  <li>
				<img src="http://placehold.it/1000x500" />
				<div class="orbit-caption">Ironman 3</div>
			  </li>
			  <li>
				<img src="http://placehold.it/1000x500" />
				<div class="orbit-caption">El se�or de los anillos</div>
			  </li>
			  <li>
				<img src="http://placehold.it/1000x500" />
				<div class="orbit-caption">Matrix</div>
			  </li>
			</ul>
		</div>
	</div>

	<div class="row">
		<div class="large-12 columns">
			<h3>Cartelera</h3>			
			<!-- Grid Example -->
			<div class="row">
				<div class="large-12 columns">
                <form class="select">
                  <label for="ciudad">Ciudad</label>
                  <select id="ciudad">
                    <option>Guadalajara</option>
                    <option>Tepic</option>
                    <option>DF</option>
                  </select>
                  
                  <label for="sede">Sede</label>
                  <select id="sede">
                    <option>Andares</option>
                    <option>Forum</option>
                    <option>Antara</option>
                  </select>
                  
                  <label for="pelicula">Pelicula</label>
                  <select id="pelicula">
                    <option>Se&ntilde;or de los anillos</option>
                    <option>Matrix</option>
                  </select>
                </form>
                <a href="cartelera.php" class="button">Ver catalogo</a>
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
