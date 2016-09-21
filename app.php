<?php
/*Page handling*/
$defaultPage = "practice";

$directory = ["practice",
					"dashboard",
					"profile",
					"premium",
					"lessons"
					];

$page = $defaultPage; /*Set the page to the default */					
if(isset($_GET['p'])) { 
	if(array_search($_GET['p'], $directory)) { /*Search the directory for p*/
		$page = $_GET['p']; /*If the page is found, load p into page*/
	}
}

require_once('session_handler.php');
sessionPersist();

global $user;
$user = getUserID();

/*I will move these dashboard functions to their own file later*/
require_once('include/db_connect.php');






?>

<html>
<head>

<!--Favicon-->
<link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico' />

<!--MathJax-->
<script type="text/javascript" async src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML"></script>

<!--JQuery-->
<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
-->

<script src="js/jquery.js"></script>
<!-- Bootstrap Core JavaScript and CSS -->
<script src="js/bootstrap.min.js"></script>
<link href="css/bootstrap.css" rel="stylesheet">

<!--Google Font-->
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,900' rel='stylesheet' type='text/css'>

<!--Main page stylesheets-->
<link rel="stylesheet" href="css/app.css">

	<script language="Javascript">
	$(document).ready(function(){ 
		var page = "<?php echo $page ?>";
		$(".left-sidebar-item[name='"+page+"']").addClass("selected");
	
		$(".left-sidebar-item").on("click", function(e) {
			var newPage = escape($(this).attr("name")); /*Note:  all security is done server-side in php*/
			window.location="app.php?p="+newPage;
			$(".left-sidebar-item").removeClass("selected"); //Technically the class will be wiped away upon page refresh anyway, but this step will execute before the new page loads for a more fluid transition.
			return;
		});
	
		refreshDom = function() {
			$("#left-sidebar").height($(document).height());
		}
		
		$(".notice").on("click", ".app-notice-close-btn",function(e) {
			$(this).parents(".app-notice").hide();
		});
		
		refreshDom()
		
	});
	</script>
<?php include_once("analyticstracking.php") ?>	
</head>
<body>
<div id="topbar">
	<div class="topbar-inset">
		<div class="topbar-menu-right">
			
			<?php if(isset($_SESSION['canary']['email'])) {
								echo '<a href="logout.php"><div class="topbar-button topbar-button-rightborder">Sign out</div></a>';
								echo '<a href="app.php?p=profile"><div class="topbar-button">' . $_SESSION['canary']['email'] . '</div></a>';
						} else {
							echo '<a href="register.php"><div class="topbar-button  topbar-button-rightborder ">Register</div></a>';
							echo '<a href="login.php"><div class="topbar-button">Sign in</div></a>';
						} ?>

		</div>
	</div>
</div>

<div id="left-sidebar" class="shadow">
	<div class="left-sidebar-menu">
		<div class="left-sidebar-item" name="practice">
			<h4><span class="glyphicon glyphicon-apple" aria-hidden="true"></span>Practice</h4>
		</div>		
		<div class="left-sidebar-item" name="dashboard">
			<h4><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>Dashboard</h4>
		</div>
		<div class="left-sidebar-item" name="lessons">
			<h4><span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span>Lessons</h4>
		</div>
		<div class="left-sidebar-item" name="profile">
			<h4><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Profile</h4>
		</div>
		<div class="left-sidebar-item" name="premium">
			<h4><span style="" class="glyphicon glyphicon-leaf" aria-hidden="true"></span>Premium</h4>
		</div>	
	</div>
</div>

<div id="content">

<?php include_once($page . ".php"); ?>
	
</div>

</body>
</html>


