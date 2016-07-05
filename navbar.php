<?php
?>
<style type="text/css">
.navbar-brand>img {
	max-height: 100%;
	height: 100%;
	width: auto;
	margin: 0 auto;
	display: inline-block;
	margin-right: 15px;

	/* probably not needed anymore, but doesn't hurt */
	-o-object-fit: contain;
	object-fit: contain; 

}
.navbar {
	margin-bottom: 0px !important;
}
</style>

<!-- Navigation -->
<nav class="navbar navbar-default topnav" role="navigation">
	<div class="container topnav">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand brand-name" href="home.php">Erdos <sup><font size="1">BETA</font></sup></a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right navbar-font-size">
				<li>
					<a href="modules.php">Learn</a>
				</li>
				<li>
					<a href="about.php">About</a>
				</li>
				<!--
				<li>
					<a href="https://www.youtube.com/watch?v=9r8Sf6ravXQ">About</a>
				</li>
				-->
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>