<?php
/*Page handling*/
$defaultPage = "practice";

$directory = ["practice",
					"dashboard",
					"profile",
					"premium",
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

if(isset($_SESSION['canary']['email'])) {
	$user = $_SESSION['canary']['email'];
} elseif(isset($_SESSION['canary']['id'])) {
	$user = $_SESSION['canary']['id'];
}

/********THIS IS A TEST STATEMENT, REMOVE THIS LATER************/
$user = 'ef82ad19df592dd26dc9e1e2b4563a63';

//echo $user;
//echo "<br><br>";

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
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
		
		refreshDom()
		
	});
	</script>
	
</head>
<body>
<div id="topbar">

</div>

<div id="left-sidebar" class="shadow">
	<div class="left-sidebar-header">

		<h3>abell5@g.clemson.edu</h3>
	</div>
	<div class="left-sidebar-menu">
		<div class="left-sidebar-item" name="practice">
			<h4><span class="glyphicon glyphicon-apple" aria-hidden="true"></span>Practice</h4>
		</div>		
		<div class="left-sidebar-item" name="dashboard">
			<h4><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>Dashboard</h4>
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
<?php include_once("analyticstracking.php") ?>

<?php include_once($page . ".php"); ?>
	
</div>

</body>
</html>


