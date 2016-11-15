
		<script type="text/javascript" async
		  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
		</script>
		
		<link rel="stylesheet" href="css/magic-check.css">
		<link rel="stylesheet" href="css/practice.css">

		
		<script src="js/module_handler.js"></script>
		<script language="Javascript">
		
		/*
				var mid = <?php
								if(isset($_GET['mid'])) {
									echo json_encode($_GET['mid']);
								} else {
									echo json_encode(3);
								}
								?>;
				$("#num").append(mid);		
		*/
		
			$(document).ready(function() {
				var dataBinary = <?php
										if(!isset($_GET['noData'])) {
											echo json_encode(false);
										} else {
											if($_GET['noData']==1) {
												echo json_encode(true);
											} else {
												echo json_encode(false);
											}	
										}
										?>;

				console.log(dataBinary);	
				
				
				openModule = function(mid) {
					$.ajax({
						url: "get_module.php",
						type: "get",
						data: {mid: mid},
						success: function(response) {
							var problem_array= $.parseJSON(response);
							liveModule = new Module(mid, problem_array,dataBinary);
							liveModule.displayKeys();
							$("#not-helpful-button-display").show();
							$( ".slide_button:first" ).trigger( "click" );	
							if((displayCookies).indexOf("helpful")>0) {
								showHelpfulTooltip();
							}							
						},
						error: function(xhr) {
							console.log("error");
						}
					});				
				}
				
				getLiveModule = function() {
					return liveModule;
				}
				
				var liveModule;
				var Module = getModuleObject();
				//openModule(3);

				collapseMenu = function(mid,modName) {
					$(".menu").hide();
					$("#mod-name").html("Module "+mid+": "+modName);
					$(".menu-minimized").show();
					refreshDom();
					/*
					$(".full-menu").slideUp( "fast", function() {
						$(".menu-minimized").show();
					 });
					 */
				}
				
				clearModule = function() {
					$("#keys").html("");
					$("#main-TV").html("");
					$("#helper-TV").html("");
				}

				$(".menu-minimized").on("click", function(e) {
					//$(".menu-minimized").hide();
					$(".full-menu").toggle();
				});
				
				$("#next_prob").on("click", function(e) {
					console.log("clicked");
					$(".slide_button.pressed").next().trigger("click");
				});
				$("#prev_prob").on("click", function(e) {
					console.log("clicked");
					$(".slide_button.pressed").prev().trigger("click");
				});
				


				$("#mod-list").on("click", function(e) {
					if($("#mod-list-container").is(":hidden")) {
						$("#mod-list-container").show();
					} else {
						$("#mod-list-container").hide();
					}
				});		
				
				$(".menu-box").click(function() {
					var mid = escape($(this).attr("name"));
					var modName = $(this).attr("mod-name");
					$(".tool-tip[name=menu]").hide()
					clearModule();
					openModule(mid);
					collapseMenu(mid, modName);
					$(".main-module").show();
					refreshDom();
				});
				
				$("body").on("change", ".magic-radio", function() { 
					var prob = $(this).attr("name");
					$(".go-btn[name="+prob+"]").click();
				});

				$("#send_feedback").on("click", function(e) {
					e.preventDefault();
					console.log( $("input[name='displayedTree']").val() );
					
					liveModule = getLiveModule();
					console.log(liveModule);
					console.log(liveModule.displayedTree);
					$("input[name='displayedTree']").val( liveModule.displayedTree );
					console.log( $("input[name='displayedTree']").val() );
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
				
				var m = $(".full-menu[name=menu]").offset();
				$(".tool-tip[name=menu]").css("left",m.left-197);
				$(".tool-tip[name=menu]").css("top",m.top+60);
			
				function showHelpfulTooltip() {
					$(".tool-tip[name=helpful]").show();
					console.log("here");
					var h = $(".flag-box[name=helpful]").offset();
					console.log(h);
					$(".tool-tip[name=helpful]").css("left",h.left-213);
					$(".tool-tip[name=helpful]").css("top",h.top-20);
				}
			//$(".tool-tip[name=progress]").show();		
			
				var displayCookies = 
				<?php
					$toolTipList = ["menu", "helpful"];
					$show = [];
					foreach($toolTipList as $tooltip) {
						if(!isset($_COOKIE["{$tooltip}"])) {
							array_push($show,$tooltip);				
						} elseif ($_COOKIE["{$tooltip}"] == 1) {
							array_push($show,$tooltip);	
						}
					}
					echo json_encode($show);
				?>;
				for(i=0; i<displayCookies.length;i++) {
					var temp = displayCookies[i];
					$(".tool-tip[name="+displayCookies[i]+"]").show();
				}
				$(".tool-tip[name=helpful]").hide();				
				
			});
		
		</script>

<!--
<div class="left-bar">
	<div class="left-bar-logo"><img src="img/module-logo.png"/></div>
	<div class="left-bar-button"><h2><span style="font-size:18px;" class="glyphicon glyphicon-home" aria-hidden="true"></span></h2></div>
	<div class="left-bar-button" id="mod-list"  title="Module List"><h2><span style="font-size:18px;" class="glyphicon glyphicon-th-list" aria-hidden="true"></span></h2></div>
	<div id="mod-list-container" style="display: none">
		<div class="left-bar-sub-button" name="3">Module 3</div>
		<div class="left-bar-sub-button" name="4">Module 4</div>
		<div class="left-bar-sub-button" name="5">Module 5</div>
		<div class="left-bar-sub-button" name="6">Module 6</div>
		<div class="left-bar-sub-button" name="7">Module 7</div>
		<div class="left-bar-sub-button" name="8">Module 8</div>
	</div>
</div>
-->

<!--
<div class="header-bar">
	<div class="module-box">
		<h2>Module <div id="num" style="display:inline-block"></div></h2>
	</div>
	<div class="module-nav-button" id="nav-mod-list" title="Module List">
		<span style="font-size:16px;" class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
	</div>
<div id="nav-mod-list-container" style="display: none">
	<div class="nav-mod-navigate" name="3">Module 3</div>
	<div class="nav-mod-navigate" name="4">Module 4</div>
	<div class="nav-mod-navigate" name="5">Module 5</div>
	<div class="nav-mod-navigate" name="6">Module 6</div>
	<div class="nav-mod-navigate" name="7">Module 7</div>
	<div class="nav-mod-navigate no-border" name="8">Module 8</div>
</div>
	
</div>
-->
<div class="menu-minimized">
	<div id="mod-name">k</div>
	<!--
	<span class="glyphicon glyphicon-th" aria-hidden="true"></span>Module menu
	-->
</div>
	
<div class="menu">

	<div class="tool-tip" name="menu">	
		<div class="tool-tip-left">
			Click to open<br>
			the first module to<br>
			begin learning.
		</div>
		<div class="tool-tip-right">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		</div>
	</div>
	
	<div class="full-menu" name="menu">
		<div class="menu-header">Problem Solving and Data Analysis</div>
		<div class="menu-content">	
			<table>
				<tr>
					<th>
						<div class="menu-box" name="9" mod-name="Inspiration, move me brightly">
						Module 1:
						<br>Inspiration, move me brightly
						</div>
					</th>
								<th>
						<div class="menu-box" name="Big Bertha">
						Module 2:
						<br>Big Bertha
						</div>
					</th>
				</tr>
			</table>
		</div>
	</div>
	
</div>

<div class="Notice">

<!--
	<div class="app-notice">
		<div class="app-notice-header-box">
			<div class="app-notice-header">
				<h6>Notice</h6>
			</div>
			<div class="app-notice-close-btn">
				<span style="" class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			</div>
		</div>
		<div class="app-notice-body">
		</div>	
	</div>
-->
</div>
<div class="main-module" style="display: none">
		<div class="key-box">
			<div class="key-box-text">
			Problem:
			</div>
			<div id="keys"></div>
			
			<div class="next">
				<div class="key-button key-font" id="prev_prob" title="Previous Problem"><span style="font-size:16px;" class="glyphicon glyphicon-triangle-left" aria-hidden="true"></div>
				<div class="key-button key-font no-border" id="next_prob" title="Next Problem"><span style="font-size:16px;" class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span></div>
			</div>
			
				<div class="tool-tip" name="helpful">	
					<div class="tool-tip-left">
						If the practice isn't<br>
						helping, let us know!<br>
						It'll help the beta.
					</div>
					<div class="tool-tip-right">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</div>
				</div>
			
				<div class="full-modal-wrapper">
					<a href="#myModal" role="button" id="not-helpful-button-display" data-toggle="modal" style='display:none'>
						<div class="flag-box" name="helpful">
							<div class="flag-icon"><h2><span style="font-size:18px;" class="glyphicon glyphicon-flag" aria-hidden="true"></span></h2></div>
							<div class="flag-text">Not helpful?</div>
						</div>
					</a>
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
						<input type="text" id="displayedTree" name="displayedTree" style='display: none' value="none"/>
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

		<div id="mainTV">	
			<h1>Press 1 to begin.</h1>
		</div>
		<div id="helperTV">	</div>
	
</div>
<!--
<div class="right-bar">

</div>
-->
