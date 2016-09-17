<html>
<head>


<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<!--Bootstrap Core JavaScript and CSS-->
<script src="js/bootstrap.min.js"></script>
<link href="css/bootstrap.css" rel="stylesheet">


<link href="css/new-home.css" rel="stylesheet">

<script>
$(document).ready(function() {
	function scroll_to(div){
		setTimeout(function() {
			$('html, body').animate({
				scrollTop: $(div).offset().top
			},1000);
		}, 10);
	}
	
	$(".billboard-btn[name=seehow]").click(function() {
		scroll_to($("#home-content"));
	});
	
});

</script>



</head>

<?php require('navbar.php'); ?>

<div id="main-container">
	<div class="billboard">
		<div class="billboard-header">
			<h3>The smartest way to prepare for the SAT</h3>
		</div>

		<div class="billboard-footer">
			<div class="billboard-btn-box">
				<a href="app.php">
					<div class="billboard-btn orange-btn">
						<h4>Start learning</h4>
					</div>
				</a>
				<div class="billboard-btn grey-btn" name="seehow">
					<h4>See how</h4>
				</div>
			</div>
		</div>
		
	</div>
</div>

<div id="home-content">

	<div class="home-content-negative">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="home-text-header">
						<h6>Erdos offers it's entire tool suite <div class="for-free">for free.</div> Intelligent tutoring, performance tracking, and goal setting all at your finger tips.</h6>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="home-text-container">

	
		<div class="container-fluid"> <!--Boostrap container-->
		
			<div class="row">
				<div class="col-sm-6">
					<div class="home-content-box">
							<div class="home-content-box-header">
								<h6>Intelligent tutoring system</h6>
							</div>
							<div class="home-content-box-content">
								Erdos is powered by an intelligent tutoring system that corrects mistakes in real-time.
								<br><br>
								If you make a mistake on a problem, the Erdos intelligent tutoring system will attempt to correct your
								mistake by asking a simpler follow-up question.  Our goal is to make sure every student
								gets to the answer.
							</div>
					</div>

				</div>
				<div class="col-sm-6">
					<div class="home-content-img-ai">
					</div>
				</div>		
			</div>		

			<div class="home-content-negative">
				<div class="row">
					<div class="col-sm-6">
						<div class="home-content-img-tracking">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="home-content-box">
								<div class="home-content-box-header">
									<h6>Progress Tracking</h6>
								</div>
								<div class="home-content-box-content">
									Erdos provides you with a dashboard of different graphs, diagrams, and summaries for
									tracking your SAT learning.  The dashboard will tell you where your strengths and weaknesses lie,
									so that you can spend your studying time more efficiently.
									<br><br>
									The Erdos platform gives you access to 100% of your data, so you'll never be left in the dark.
								</div>
						</div>
					</div>		
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-6">
					<div class="home-content-box">
							<div class="home-content-box-header">
								<h6>Goal Setting</h6>
							</div>
							<div class="home-content-box-content">
								Use Erdos to set and track your SAT practice goals.
								If you tell Erdos your desired test date, and what score you want to get,
								Erdos will tell you how many days you need to practice.
								<br><br>
								Erdos also keeps track of how many days in a row you've practiced,
								and let you know your longest practice streak.  This way, you can always be trying
								to do out-do your best.
							</div>
					</div>

				</div>
				<div class="col-sm-6">
					<div class="home-content-img-goals">
					</div>
				</div>		
			</div>
		
		</div>
	</div>
</div>

</body>

<?php require('footer.php'); ?>


</html>