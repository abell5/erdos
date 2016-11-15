<?php ?>
<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
<style type="text/css">
 #topbar {
	 height: 55px !important;
	 width: 100%;
	 
	 padding: 6px !important;
	 padding-bottom: 15px !important;
	 background-color: #fff;

	 display:block;
	 float:left;
	 
	 border-bottom: 1px solid #ecf0f1;
	
 }
 
  .topbar-inset {
	 position: relative;
	 width: 75%;
	 height: 100%;
	 margin: auto;
 }
 .topbar-left-logo {
	 float:left;
	 padding-top: 8px;
	 padding-left: 10px;
	 color: #2980b9;
 }
	.topbar-left-logo a {
		text-decoration: none;
		color: #2980b9;
	}
 
 .topbar-right-links {
	 float:right;
	 padding-top: 10px;
	 color: #34495e;
 }
 
	.topbar-right-links a {
		padding: 5px;
		padding-top: 4px;
		padding-left: 7px;
		padding-right: 7px;
		margin-left: 10px;
		margin-right: 10px;
		
		text-decoration: none;
		
		display: inline-block;
	}
	
	.topbar-right-links a:hover {
		cursor: pointer;
		
		/*
		border-radius: 3px;
		background-color: #e67e22;
		*/
	}
	
	.sign-up-button {
		border-radius: 3px;
		background-color: #f39c12;
		color: #fff;
	}
		.sign-up-button:hover {
			border-radius: 3px;
			background-color: #e67e22;
			color: #fff;
		}
 
h3 {
	margin: 0;
	padding: 0;
	
	font-family: 'Slabo 27px', serif;
	font-size: 30px;
	font-weight: 700;
	
	color: inherit;
}

 h4 {
	 font-family: Optima, Segoe, "Segoe UI", Candara, Calibri, Arial, sans-serif;
	 padding: 0;
	 margin: 0;
	 color: inherit;
	 font-size: 16px;
	 font-weight: 300;
	 text-transform: uppercase;
 }
</style>

<!-- Navigation -->
<div id="topbar">
	<div class="topbar-inset">
		<div class="topbar-left-logo">
			<a href="app.php"><h3>Uclid</h3></a>
		</div>
		<div class="topbar-right-links">
			<!--
			<a href="about.php"><h4>About</h3></a>
			-->
			<a href="app.php"><h4>Learn</h4></a>
			<a href="login.php"><h4>Sign in</h4></a>
			<a href ="register.php" class="sign-up-button"><h4>Sign up</h4></a>
		</div>
	</div>
</div>