<?php
function print_header($driver) {
?>
<nav class="top-bar">
	<!-- Right Nav Section -->
	<ul class="title-area">
		<!-- Title Area -->
		<li class="name">
		  <h1><a href="index.php">Ipsum Cinemas</a></h1>
		</li>
		<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
		<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	</ul>
	<section class="top-bar-section">
		<ul class="right">
		 <li class="has-form" style="backgroud-color:#000000;"> <form>
          <div class="row collapse">
            <div class="small-8 columns">
              <input type="text">
            </div>
            <div class="small-4 columns">
              <a href="#" class="button">Search</a>
            </div>
          </div>
        </form></li>
		  <li class="divider"></li>
		  <li class="has-form" style="color:#FFFFFF;">
		  
			<form>
				
				<li class="has-form" style="padding:9px;">
				<?php $driver->getUser(); ?>
				</li>
				<?php
					if (isset($_SESSION["username"])) {
						echo '<a href="logout.php" class="button">Log Out</a>';
					}
					else {
						echo '<a href="login.php" class="button">Login</a>';
					}
				?>
			</form>
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
		about<br/>
		legal<br/>
	</div>
	<div class="small-4 columns">
		contact us<br/>
		links<br/>
	</div>
	<div class="small-4 columns">
		<a href="admin.php">admin panel</a>
	</div>
</div>
<?php
}
?>