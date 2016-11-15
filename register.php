<?php
require_once('session_handler.php');
sessionPersist();

$registerError = 0;
if(isset($_GET['error'])) {
	if($_GET['error']==1) {
		$registerError=1;
	}
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
<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">

<!--Main page stylesheets-->
<link rel="stylesheet" href="css/register.css">

	<script language="Javascript">
	$(document).ready(function(){ 
		var errors = [];
		
		var registerError = <?php echo json_encode($registerError); ?>;
		console.log(registerError);
		if (registerError == 1) {
			$('.note').html("Sorry!  An unexpected error occured.<br>Please try registering again.")
			$('.note').show();
		}
		
		function validateEmail(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}
		
		function validatePassword(pass) {
			var re = /[a-zA-Z0-9._^%$#!~@-]{5,17}$/;
			return re.test(pass);
		}
		
		$("input[name=pass]").focusout(function() {
			var elem = $("input[name=pass]");
			if(!validatePassword(elem.val())) {
					elem.css("border-color", "rgb(231, 76, 60)")
					elem.css("color", "rgb(231, 76, 60)")
					elem.val("");
					$("input[type=submit]").attr('disabled',true);
					$('.sub-right').html("<ul><li>Password must be between 5 and 17 characters</li><li>Only special characters allowed are . _ ^ % $ # ! ~ @ -</li></ul>")
					$('.sub-right').show();
			} else {
				console.log("passed");
				$('.sub-right').hide();
			}
		});
		
		$("input[name=confirmPass]").focusout(function() {
			var elem = $("input[name=confirmPass]");
			if( $("input[name=pass]").val() == elem.val() && elem.val() != "") {
				$("input[type=submit]").removeAttr('disabled');
				$("input[type=submit]").removeClass('register-disabled');
				$('.sub-right').hide();
				console.log("entered");
			} else {
				$("input[type=submit]").attr('disabled',true);
				$('.sub-right').html("Passwords do not match")
				$('.sub-right').show();
				console.log("entered2");
			}
		});
		
		$("input[name=pass]").focusout(function() {
			var elem = $("input[name=pass]");
			if(!validatePassword(elem.val())) {
					elem.css("border-color", "rgb(231, 76, 60)")
					elem.css("color", "rgb(231, 76, 60)")
					elem.val("");
					$("input[type=submit]").attr('disabled',true);
					$('.sub-right').html("<ul><li>Password must be between 5 and 17 characters</li><li>Only special characters allowed are . _ ^ % $ # ! ~ @ -</li></ul>")
					$('.sub-right').show();
			} else {
				console.log("passed");
				$('.sub-right').hide();
			}
		});
	
		$("input[name=pass]").focusin(function() {
			var elem = $("input[name=pass]");
			if(elem.css("border-color") == "rgb(231, 76, 60)") {
				elem.val("");
				elem.css("border-color", "rgb(204,204,204)")
				elem.css("color", "rgb(0,0,0)")
			}	
		});
	
		$("input[name=email]").focusin(function() {
			var elem = $("input[name=email]");
			console.log(elem.css("border-color"));
			if(elem.css("border-color") == "rgb(231, 76, 60)") {
				console.log("true");
				elem.val("");
				elem.css("border-color", "rgb(204,204,204)")
				elem.css("color", "rgb(0,0,0)")
			}	
		});
		
		$("input[name=email]").focusout(function() {
			var emailPackage = new Object()
			emailPackage["desiredEmail"] = escape($(this).val());
			
			if(!validateEmail($("input[name=email]").val())) {
					$("input[name=email]").css("border-color", "rgb(231, 76, 60)")
					$("input[name=email]").css("color", "rgb(231, 76, 60)")
					$("input[name=email]").val("Invalid e-mail");
					$("input[type=submit]").attr('disabled',true);
			}
	
			$.ajax({
				url: "checkDesiredEmail.php",
				type: "get",
				data: {desiredEmail: emailPackage["desiredEmail"]},
				success: function(response) {
					var res = $.parseJSON(response);
					if (res.available==0 && $("input[name=email]").val() != "") {
						$("input[name=email]").css("border-color", "rgb(231, 76, 60)")
						$("input[name=email]").css("color", "rgb(231, 76, 60)")
						$("input[name=email]").val("E-mail taken");
						$("input[type=submit]").attr('disabled',true);
					}
				},
				error: function(xhr) {
					console.log("error");
				}
			});
				
		});

		
	});
	
	</script>
</head>
<body>

<?php require('navbar.php'); ?>

<div id="main-container">

	<div class="note"style="display: none">
	</div>
	
	<div class="form-container">

	<form method="POST" action="registerUser.php">
		<div class="form-header-box">
			<div class="logo">
				<h7>Uclid</h7>
			</div>
			<h6>Sign up</h6>
		</div>
		<div class="inner-addon left-addon">
			<i class="glyphicon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></i>      
			<input type="text" class="input-margin" name="email" placeholder="E-mail" maxlength="254"/>
		</div>
		
		<div class="inner-addon left-addon">
			<i class="glyphicon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></i>      
			<input type="password" class="input-margin" name="pass" placeholder="Password"  />
		</div>
		
		<div class="inner-addon left-addon">
			<i class="glyphicon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></i>      
			<input type="password" class="input-margin" name="confirmPass" placeholder="Confirm password"  />
		</div>
		<div class="form-subbox">
			<div class="sub-left">
			<input type="submit" class="register-btn-style register-disabled" value="Register" disabled>
			</div>
			<div class="sub-right" style="display:none">
			
			</div>
		</div>
	</form>

	</div>
	
</div>
</html>