<?php


?>

<html>
<head>


<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<!--Bootstrap Core JavaScript and CSS-->
<script src="js/bootstrap.min.js"></script>
<link href="css/bootstrap.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" media="screen and (min-device-width: 755px)" href="css/landing.css" />
<link rel="stylesheet" media="screen and (max-device-width: 754px)" href="css/landing-mobile.css" />

<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">

<script>
$(document).ready(function() {
	var bg = $("#full-container");
	var maxHeight = Math.max(document.body.scrollHeight, document.body.offsetHeight, $(window).height()) + 100;
	
	$(window).resize(function() {
		resizeBackground();	
	});
	
	function displaySignup() {
		var fixedHeight = $(".billboard").height();
		$("#beta-sign-up").hide();
		$(".billboard").height(fixedHeight);
		$("#sign-up-form").slideDown();	
	}
	
	$("#beta-sign-up").bind("click", function() {
		displaySignup();
	});
	
	$(".sign-up-button").bind("click", function() {
		displaySignup();
	});
	
	function resizeBackground() {
		bg.height(maxHeight);
		console.log(bg.height());
		//$(".row").width( $(".landing-info").width() );
	}
	resizeBackground();	
	
	
});

</script>

</head>

<body>
<div id="full-container">


<div id="main-container">

<div id="topbar">
	<div class="topbar-inset">
		<div class="topbar-left-logo">
			<a href="landing.php">Uclid</a>
		</div>
		<div class="topbar-right-links">
			<a href="mailto:andrew@uclid.io"><h4>andrew@uclid.io</h4></a>
			<a href ="#" class="sign-up-button"><h4>Sign up</h4></a>
		</div>
		<div class="mobile-contact" style="display: none">
			<a href="mailto:andrew@uclid.io"><h4>andrew@uclid.io</h4></a>			
		</div>
	</div>
</div>

	<div class="billboard">
		<div class="billboard-header">
			The smartest way to prepare for the SAT
		</div>
		<div class="billboard-subtext">
			Uclid is an online SAT prep platform.  Our practice question suite is paired with intelligent tutoring, progress tracking, and video recommendations.
			<br>Always know what you got wrong, why you got it wrong, and how to improve.
		</div>
		
		<div class="billboard-footer">
				<div class="billboard-btn orange-btn" id="beta-sign-up">
						SIGN UP FOR THE BETA
				</div>
		</div>
		<!--Begin mc_embed_signup -->
		<div class="sign-up-form" style="display: none" id="sign-up-form">
			<div id="mc_embed_signup">
			<form action="//uclid.us14.list-manage.com/subscribe/post?u=242383d9631350ff879e74ee0&amp;id=ebafdd8fc8" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			<div id="mc_embed_signup_scroll">
			<table style="width: 100%">
			<tr>
				<th style="width: 80%">
					<div class="mc-field-group">
						<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="email">
					</div>
				</th>
				<th style="width: 20%">
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>   
					<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_242383d9631350ff879e74ee0_ebafdd8fc8" tabindex="-1" value=""></div>
					<div class="clear"><input type="submit" value="Sign up" name="subscribe" id="mc-embedded-subscribe" class="subscribe-btn-style"></div>
				</th>
			</tr>
			</table>
			
			</div>
			</form>
			</div>
					
		</div>
		<!--End mc_embed_signup-->		
	</div>
	
		<div class="landing-info">
		<div class="container-fluid">
            <div class="row">			
				<div class="col-sm-2 col-sm-offset-1">
					<div class="row text-center">
						<img src="img/glyphs/questions.png">
					</div>
					<div class="row text-center">
						<div class="blurb-text">
							Uclid provides hundreds of SAT math review questions.
						</div>
					</div>
				</div>
				
				<div class="col-sm-2 col-sm-offset-2">
					<div class="cut-out">
						<div class="row text-center">
							<img src="img/glyphs/network.png">
						</div>
						<div class="row text-center">
							<div class="blurb-text">
								An intelligent tutoring system will help you through questions that you miss.
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-sm-2 col-sm-offset-2">
					<div class="cut-out text-center">
						<div class="row text-center">
							<img src="img/glyphs/data.png">
						</div>
						<div class="row text-center">
							<div class="blurb-text">
							You will always know where you stand on each SAT math topic.
							</div>
						</div>
					</div>	
				</div>	
            </div>
		</div>
		</div>
		
</div>

</div>
</body>