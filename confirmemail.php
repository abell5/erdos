<html>
<head>

</head>

<div id="main-container">

<div class="message">
<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once('include/db_connect.php');

$email = filter_var(($_GET['email']), FILTER_SANITIZE_STRING);
$confirmcode = filter_var($_GET['confirmcode'], FILTER_SANITIZE_STRING);

if(empty($email) || empty($confirmcode)) {
	echo "There was an error confirming your email. If you are receiving this message in error,
				please e-mail Andrew at andrew@uclid.io.  He should get back to you quickly!";
} else {
	$query = "SELECT `confirmcode` FROM `users` WHERE (`email`) = :email LIMIT 1";
	$stmt = $DBH->prepare($query);
	$stmt->bindValue(':email',$email);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if($row['confirmcode'] == $confirmcode) {
		$query = "UPDATE `users`SET `confirmcode`=1 WHERE (`email`) = :email LIMIT 1";
		$stmt = $DBH->prepare($query);
		$stmt->bindValue(':email',$email);
		$stmt->execute();
		echo "Thank you for confirming your e-mail.";
	} else {
		echo "It seems you provided the incorrect confirmation code.  If you are receiving this message in error,
				please e-mail Andrew at <a href='mailto:andrew@uclid.io?Subject=Error'>andrew@uclid</a>.  He should get back to you quickly!";
	}
}

?>
<br><br>
Redirecting...
</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,900' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/message-page.css">

<script language="Javascript">
$(document).ready(function(){ 
	setTimeout(function() {
		window.location.href = "http://uclid.io/app.php?p=practice";
	}, 5000);
});
</script>
</html>