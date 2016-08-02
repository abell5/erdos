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
    <link href="css/bootstrap.css" rel="stylesheet">
	<link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico' />

	<!--JQuery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	
	<!--Google font-->
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,900' rel='stylesheet' type='text/css'>
	<link href="css/modules.css" rel="stylesheet">
	
	<script language="Javascript">
	$(document).ready(function(){ 
		$(".module-link").click(function() {
			var mid = escape($(this).attr("name"));
			if(mid!=="next") {
				window.location="lesson.php?mid="+mid;
				return false;
			}
		});
	});
	
	</script>

</head>

<body>

<?php include('navbar.php'); ?>
<?php include_once("analyticstracking.php") ?>
<?php include_once("session_handler.php") ?>

<div class="container">
<div class="container-bin">

	<div class="module-header">
		<h4>Modules</h4>
	</div>
	<div class="module-main">
		
		<div class="row">
			<!--
			<div class="module-link" name=1>
					<span style="font-size:22px;" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>
					<div class="module-desc"><h5>Review problem set 1</h5></div>
			</div>
			<div class="module-link" name=2>
					<span style="font-size:22px;" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>
					<div class="module-desc"><h5>Review problem set 2</h5></div>
			</div>
			-->
			<div class="module-link" name=3>
					<span style="font-size:22px;" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>
					<div class="module-desc"><h5>Review problem set 6/17/16</h5></div>
			</div>
			<div class="module-link" name=4>
					<span style="font-size:22px;" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>
					<div class="module-desc"><h5>Review problem set 6/26/16</h5></div>
			</div>
			<div class="module-link" name=5>
					<span style="font-size:22px;" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>
					<div class="module-desc"><h5>Review problem set 7/1/16</h5></div>
			</div>
			<div class="module-link" name=6>
					<span style="font-size:22px;" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>
					<div class="module-desc"><h5>Review problem set 7/8/16</h5></div>
			</div>
			<div class="module-link" name=7>
					<span style="font-size:22px;" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>
					<div class="module-desc"><h5>Review problem set 7/14/16</h5></div>
			</div>
			<div class="module-link" name=8>
					<span style="font-size:22px;" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>
					<div class="module-desc"><h5><div class="new">new</div>Review problem set 7/21/16</h5></div>
			</div>
			<div class="module-link" name="next">
					<span style="font-size:22px;" class="glyphicon glyphicon-time" aria-hidden="true"></span>
					<div class="module-desc"><h5>New module will be released next month!</h5></div>
			</div>			 
			<!--
			<div class="module-link one">
					<span style="font-size:22px;" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>
					<div class="module-desc"><h5>Easy review</h5></div>
			</div>
			-->
		</div>
	</div>
</div>
</div>

<?php require('footer.php'); ?>

</body>

</html>