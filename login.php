<?php
require_once('session_handler.php');
sessionPersist();



?>
<html>
<head>

<!--Favicon-->
<link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico' />

<!--MathJax-->
<script type="text/javascript" async src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML"></script>

<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript and CSS -->
<script src="js/bootstrap.min.js"></script>
<link href="css/bootstrap.css" rel="stylesheet">

<!--Google Font-->
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,900' rel='stylesheet' type='text/css'>

<!--Main page stylesheets-->
<link rel="stylesheet" href="css/login.css">

	<script language="Javascript">
	$(document).ready(function(){ 
		

		
	});
	
	</script>
</head>
<body>

<div class="form-container">

<form method="POST" action="authorize.php">
	<div class="form-header-box">
		<div class="logo">
			<h6>Erdos</h6>
		</div>
		<h6>User login</h6>
	</div>
	<div class="inner-addon left-addon">
		<i class="glyphicon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></i>      
		<input type="text" class="input-margin" name="email" placeholder="E-mail" maxlength="254"/>
	</div>
	
	<div class="inner-addon left-addon">
		<i class="glyphicon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></i>      
		<input type="password" class="input-margin" name="pass" placeholder="Password"  />
	</div>
	<div class="form-subbox">
		<div class="sub-left">
		<input type="submit" class="login-btn-style" value="Login">
		</div>
		<div class="sub-right">
			<table>
			<tr><th>
				<div class="forgot-password-btn">lost password?</div>
			</th></tr>
			<tr><th>
				<div class="register-btn">need to register?</div>
			</th></tr>
			</table>
		</div>
	</div>
</form>

</div>

</html>