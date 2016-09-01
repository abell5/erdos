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
<link rel="stylesheet" href="css/changelostpassword.css">

	<script language="Javascript">
	
	</script>
</head>
<body>
<?php require('navbar.php'); ?>

<div id="main-container">

<div class="form-container">

<form method="POST" action="changePassword.php">
	<div class="form-header-box">
		<h6>Change lost password</h6>
	</div>
	
	<div class="inner-addon left-addon">
		<i class="glyphicon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></i>      
		<input type="password" class="input-margin" name="pass" placeholder="Password"  />
	</div>
	
	<div class="inner-addon left-addon">
		<i class="glyphicon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></i>      
		<input type="password" class="input-margin" name="confirmPass" placeholder="Confirm password"  />
	</div>
	
	<input type="hidden" name="confirmkey" value="' . $confirmkey . '"/>
	<input type="hidden" name="email" value="' . $email . '"/>
			
	<div class="form-subbox">
		<div class="sub-left">
			<input type="submit" class="login-btn-style" value="Change password">
		</div>
		<div class="sub-right">

		</div>
	</div>
</form>

</div>
</div>
</html>