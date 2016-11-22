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
<link rel="stylesheet" href="css/lostpassword.css">

<!--Google Font-->
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,900' rel='stylesheet' type='text/css'>

<!--Main page stylesheets-->
<link rel="stylesheet" href="css/changelostpassword.css">

	<script language="Javascript">
	
	</script>
</head>
<body>
<div id="main-container">
<?php
require_once('include/db_connect.php');
require_once('encryptionFunctions.php');
require_once('session_handler.php');
sessionPersist();

if(!isset($_GET['email'])) {
	echo "No e-mail provided.";
} else {
	$email = filter_var($_GET['email'], FILTER_VALIDATE_EMAIL);
}

$confirmkey = filter_var($_GET['confirmkey'], FILTER_SANITIZE_STRING);



if(!empty($confirmkey)) {
	//Change the password of the user to a random siz digit integer and send it to them
	$query = "SELECT `id` FROM `password_change_requests` WHERE (`email`) = :email AND (`confirmkey`) = :confirmkey AND (`expired`) = 0 LIMIT 1";
	$stmt = $DBH->prepare($query);
	$stmt->execute(array(":email"=>$email, ":confirmkey"=>$confirmkey));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if(!empty($row['id'])) { 
?>
<div class="form-container">
				<form method="POST" action="changePassword.php">
					<div class="form-header-box">
						<h6>Change lost password</h6>
					</div>
					
					<div class="inner-addon left-addon">
						<i class="glyphicon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></i>      
						<input type="password" class="input-margin" name="pass" placeholder="Password"  />
					</div>
					
					<div class="inner-addon left-addon">
						<i class="glyphicon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></i>      
						<input type="password" class="input-margin" name="confirmPass" placeholder="Confirm password"  />
					</div>
					
					<input type="hidden" name="confirmkey" value="<?php echo $confirmkey ?>"/>
					<input type="hidden" name="email" value="<?php echo $email ?>"/>
							
					<div class="form-subbox">
						<div class="sub-left">
							<input type="submit" class="login-btn-style" value="Change password">
						</div>
						<div class="sub-right">

						</div>
					</div>
				</form>
</div>
<?php
} else {
		echo "Incorrect email or confirmation key.";
	}	
} else {
	//Generate and send the confirmation code.
	$tempConfirmkey = md5($email . rand());
	$query = "INSERT INTO `password_change_requests` (`email`, `datetime`,`confirmkey`,`expired`)
				VALUES (:email, Now(), :confirmkey, 0)";
	$stmt = $DBH->prepare($query);
	if($stmt->execute(array(":email" => $email, ":confirmkey"=>$tempConfirmkey))) {
		$message  = 
		"Clicking the link below to reset your Uclid password:
		http://www.uclid.io/forgotpassword.php?email=$email&confirmkey=$tempConfirmkey
		";
		//echo $message;
		mail($email,"Fruitfulness over Forgetfullness from Uclid", $message, "From: welcome@getUclid.com");
		echo "<div class='note'>
					A link to reset your password has been sent to your e-mail!<br>
					If at first you don't see the e-mail, please check your spam bin.
				</div>";
	} else {
		//Error handling.
		echo "A critical error occured.";
	}
}
ob_end_flush(); 
?>
</div>
</body>
</html>
