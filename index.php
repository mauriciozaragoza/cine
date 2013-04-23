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
	<nav class="top-bar">
	  <ul class="title-area">
		<!-- Title Area -->
		<li class="name">
		  <h1><a href="#">Ipsum Cinemas</a></h1>
		</li>
		<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
		<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	  </ul>

		<!-- Right Nav Section -->
	  <section class="top-bar-section">
		<ul class="right">
		  <li class="divider"></li>
		  <li class="has-form">
			<form>
			  <div class="row collapse">
				<div class="small-8 columns">
				  <input type="text">
				</div>
				<div class="small-4 columns">
				  <a href="#" class="alert button">Search</a>
				</div>
			  </div>
			</form>
		  </li>
		  <li class="divider show-for-small"></li>
		  <li class="has-form">
			<a class="button" href="#">Button!</a>
		  </li>
		</ul>
	  </section>
	</nav>

	<div class="row">
		<div class="large-8 columns">
			<ul data-orbit>
			  <li>
				<img src="http://placehold.it/1000x500" />
				<div class="orbit-caption">Ironman 3</div>
			  </li>
			  <li>
				<img src="http://placehold.it/1000x500" />
				<div class="orbit-caption">El señor de los anillos</div>
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
                <a href="cartelera.html" class="button">Ver catalogo</a>
				</div>
			</div>
        </div>
	</div>
        
	<hr />
    
    <div class="row">
		<div class="small-4 columns">
			acerca de<br/>
			legal<br/>
		</div>
        <div class="small-4 columns">
			contacto<br/>
			links<br/>
		</div>
        <div class="small-4 columns">
			<a href="login.html">empleados</a>
		</div>
	</div>

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
