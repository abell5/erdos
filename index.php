
<html>
	<head>

		
		<script type="text/javascript" async
		  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
		</script>
		<script src="js/config.js"></script>
		
		
		<script data-main="js/main.js" src="js/lib/require.js"></script>
		<script>
		
			require(['js/main'], function() {
				require(['jquery', 'modules'], function($,mod) {
						$(document).ready(function(){    
		
						$("#send_feedback").on("click", function(e) {
							e.preventDefault();
							
							$.ajax({
								type: 'POST',
								url: 'feedback.php',
								data: $('#feedbackForm').serialize(),
								success: function () {
									$("#changeMe").html('Thanks!');
								}
							});
							
							$("#myModal").modal('hide');
						});
							
						console.log("begin");
						
						var Module = mod.getModuleObject();
						
						var Fractions = new Module("Fractions", [4,6,8,9,11,13,16]);
						Fractions.displayKeys();
					});
					
				});
			});
		
		</script>
		
		<link rel="stylesheet" href="css/magic-check.css">
		<link rel="stylesheet" href="css/master.css">
		
		
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico' />

		<!--JQuery-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		
		<script lanuage="Javascript">

		</script>
		
		
	</head>



<body>

<?php require('navbar.php'); ?>
<?php include_once("analyticstracking.php") ?>
<?php include_once("session_handler.php") ?>

<div class="contain-bin">
<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div id="keys"></div>
			</div>
			<div class="col-md-2">
				<div id="feedback">
					<div class="full-modal-wrapper">
							<a href="#myModal" role="button" class="btn btn-success nh-btn" data-toggle="modal"><div class="learn-more-font" id="changeMe">Not helpful?</div></a>
							<!-- Modal -->
							<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header modal-header-text">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										Feedback
									</div>
								<div class="modal-body">
									<div class="modalMargins">
										<div class="modal-inside-font">
											We're sorry we couldn't help you with this problem!  We really value your feedback.  Can you be more specific about the issue?
										</div>
									</div>
									
										<div class="submit-container">
											<form class="input-group" name="feedbackForm" id="feedbackForm" action="feedback.php" method="post">
											
												<div class="modalMargins">
													<input class="magic-radio" type="radio" name="feedback" id="1" value="bad_follow_up_questions"><label for="1"><div class="mf">Follow up questions aren't helping</div></label>
													<input class="magic-radio" type="radio" name="feedback" id="2" value="buggy"><label for="2"><div class="mf">The program is buggy</div></label>
													<input class="magic-radio" type="radio" name="feedback" id="3" value="too_easy"><label for="3"><div class="mf">Question was too easy</div></label>
												</div>
												
									
													<label for="comments">Any additional comments?</label>
													<input type="text" id="comments" class="form-control glow-no-mo inputlg" maxlength="200" placeholder="Comments" name="comments"/>
												
												
												
												<div class="submit-button">
													<button type="submit" class="btn btn-primary northMargins" id="send_feedback">Send Feedback</button>
												</div>
											</form>
											
										</div>
									

								</div><!-- End of Modal body -->
								</div><!-- End of Modal content -->
								</div><!-- End of Modal dialog -->
							</div><!-- End of Modal -->
						</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div id="mainTV">	
					<h1>Let's begin!</h1>
				</div>
				<div id="helperTV">	
				</div>
			</div>
			

		</div>
</div>
</div>	
	
</body>

</html>
