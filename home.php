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
	<link href="css/home.css" rel="stylesheet">
	
	<script language="Javascript">

	</script>

</head>

<body>
<div class="header-section">
<?php require('navbar.php'); ?>
<?php include_once("analyticstracking.php") ?>
	
    <!-- Header -->
        <div class="container">
		
            <div class="row">
                <div class="col-sm-4 col-sm-offset-3">
                    <div class="intro-message">
						<div class="spacer"></div>
                        <h1>Beat the SAT.</h1>
						<h2>SAT review powered by next-generation artificial intelligence.  Our mission is to help you gain mastery of mathematics.</h2>
                    </div>
                </div>
            </div>
			<div class="row">
				<div class="col-sm-3 col-sm-offset-3">
					<div class="intro-message text-center">
						<div class="spacer"></div>
						<a href="modules.php" class="btn btn-success  btn-lg" role="button"><div class='expander'>Start</div></a>
					</div>
				</div>
			</div>
		</div>
        <!-- /.container -->

		<div class="content-section">
            <div class="row">
				
				
				<div class="col-sm-4">
					<div class="cut-out">
						<div class="row text-center">
							<h3>SAT Math Review</h3><br>
							<h2>Easy, medium and hard questions.</h2>
						</div>
						<div class="row text-center">
							<img src="img/glyphs/questions.png">
						</div>
					</div>
				</div>
				
				<div class="col-sm-4">
					<div class="cut-out">
						<div class="row text-center">
							<h3>Intelligent Tutoring</h3><br>
							<h2>Be guided by next-gen AI.</h2>
						</div>
						<div class="row text-center">
							<img src="img/glyphs/network.png">
						</div>
					</div>
				</div>
				
				<div class="col-sm-4">
					<div class="cut-out">
						<div class="row text-center">
							<h3>Tracking & Reporting</h3><br>
							<h2>Watch your progress.</h2>
						</div>
						<div class="row text-center">
							<img src="img/glyphs/data.png">
						</div>
					</div>	
				</div>	
            </div>
		</div>


    <!-- Footer -->
<?php require('footer.php'); ?>

    <!--
    <script src="js/jquery.js"></script>
	<script src="js/jquery.animate-colors.js"></script>

    
    <script src="js/bootstrap.min.js"></script>
	-->
</div>
</body>

</html>
