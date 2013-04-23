<?php
function print_header($driver) {
?>
<nav class="top-bar">
	<!-- Right Nav Section -->
	<ul class="title-area">
		<!-- Title Area -->
		<li class="name">
		  <h1><a href="#">Ipsum Cinemas</a></h1>
		</li>
		<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
		<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	</ul>
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
			<?php $driver->getUser(); ?>
			<a class="button" href="#">Button!</a>
		  </li>
		</ul>
	</section>
</nav>
<?php
}

function print_footer() {
?>
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
		<a href="login.php">empleados</a>
	</div>
</div>
<?php
}
?>