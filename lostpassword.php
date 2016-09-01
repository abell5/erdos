<?php
require_once('session_handler.php');
sessionPersist();

if(isset($_GET['sent'])) {
	$reload = filter_var($_GET['sent'], FILTER_SANITIZE_STRING);
	if ($reload != 1) {
		$reload = 0;
	}
} else {
	$reload = 0;
}



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
<link rel="stylesheet" href="css/lostpassword.css">

	<script language="Javascript">
	$(document).ready(function(){ 
		
		var reload = <?php echo $reload ?>;
		console.log(reload);
		if (reload==1) {
			console.log("here");
			$(".note").show();
		}
		
	});
	
	</script>
</head>
<body>
<?php require('navbar.php'); ?>

<div id="main-container">

<div class="note" style='display:none'>
	A link to reset your password has been sent to your e-mail!<br>
	If at first you don't see the e-mail, please check your spam bin.
</div>

<div class="form-container">

<form method="GET" action="forgotpassword.php">
	<div class="form-header-box">

		<h6>Lost password</h6>
	</div>
	<div class="inner-addon left-addon">
		<i class="glyphicon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></i>      
		<input type="text" class="input-margin" name="email" placeholder="E-mail" maxlength="254"/>
	</div>
	
	<div class="form-subbox">
		<div class="sub-left">
		<input type="submit" class="login-btn-style" value="E-mail me">
		</div>
		<div class="sub-right">

		</div>
	</div>
</form>

</div>
</div>
</html>