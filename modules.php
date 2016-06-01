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
	<link href="css/modules.css" rel="stylesheet">
	
	<script language="Javascript">
	$(document).ready(function(){  
		$(".one").click(function() {
			window.location = "index.php";
			return false;
		});
	});
	</script>

</head>

<body>

<?php include('navbar.php'); ?>
<?php include_once("analyticstracking.php") ?>

<div class="container">
<div class="container-bin">

	<div class="module-header">
		<h4>Modules</h4>
	</div>
	<div class="module-main">
		
		<div class="row">
			<div class="module-link one">
					<span style="font-size:22px;" class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>
					<div class="module-desc"><h5>Review problem set 1</h5></div>
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

</body>

</html>