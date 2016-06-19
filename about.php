<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Erdos</title>	
	
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico' />

	<!--JQuery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	
	<!--Google font-->
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,900' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
	<link href="css/about.css" rel="stylesheet">
	
	<script language="Javascript">
		console.log("console on");
	</script>

</head>

<body>

<?php include('navbar.php'); ?>
<?php include_once("analyticstracking.php") ?>
<?php include_once("session_handler.php") ?>

	<div class="container">
	<div class="container-bin">
	<div class="row">
		<div class="intro-quote">
		<h1>Our mantra:<br>Make sure every student gets to the answer.</h1>
		</div>
	</div>
	<div class="row">
		<div class="about-content">
		<h4>Mission Statement</h4>
		Our mission is to help students gain a mastery of mathematics by building intelligent teaching methods and software.
		</div>
		
		<div class="about-content">
		<h4>Vision Statement</h4>
		To inspire every student in the world, so that they may discover their ability to learn is boundless.
		</div>
		
		<div class="about-content">
		<h4>The Team</h4>
		<div class="founder-box">
			<div class="row">
				<div class="col-sm-1">
					<img src="img/bio/andrew.png"/>
				</div>
				<div class="col-sm-7">
					<b>Andrew Bell</b> is a full stack engineer with a B.S. in Abstract Mathematics from Clemson University.  He loves education, art, and coffee.
				</div>
			</div>
		</div>
		<div class="founder-box">
			<div class="row">
				<div class="col-sm-1">
					<img src="img/bio/jp.png"/>
				</div>
				<div class="col-sm-7">
					<b>JonPaul "JP" Turner</b> is a content developer.  He has a B.S. in Mechanical Engineering from Clemson University.  He once built a racecar that broke down 23 hours and 50 minutes into a 24 hour endurance-race.
				</div>
			</div>
		</div>
		</div>
		</div>
		
		<div class="about-content">
		<h4>Contact</h4>
		E-mail us at geterdos@gmail.com.  We will get back to you soon.
		</div>
	</div>
	</div>
	</div>

<?php require('footer.php'); ?>
	
</body>
</html>