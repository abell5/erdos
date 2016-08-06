<?php
require_once('include/db_connect.php');
require_once('encryptionFunctions.php');

/**Retrieve posted variables **/
$user = $_POST['user'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$confirmPass = $_POST['confirmPass'];

$errors = [];
/* Check e-mail */
if(filter_var($email, FILTER_VALIDATE_EMAIL)!=$email) {
	array_push($errors, "Please enter a valid e-mail address.");
}

/* Check username length */
if(strlen($user) > 16 ) {
	array_push($errors, "Username must be shorter than 16 characters.");
}

/*Check if passwords match */
if($pass != $confirmPass) {
	array_push($errors, "One of those passwords is not like the other.");
}

/*Check if username already exists */
$query = "SELECT * FROM `users` WHERE LOWER(`username`) = :username";
$stmt = $DBH->prepare($query);
$stmt->bindValue(':username',strtolower($user));
$stmt->execute();

if($stmt->rowCount() > 0) {
	array_push($errors, "Someone beat you to that username.");
}

/*** End checks ***/


/**Begin main register function **/
if(!empty($errors)) {
	foreach ($errors as $e) {
		echo $e . "<br>";
	}
} else {
	$confirmcode = md5($email . rand());
	
	$query = "INSERT INTO `users` (`username`, `password`,`email`,`confirmcode`)
				VALUES (:username, :password, :email, :confirmcode)";
	$encryptedPassword = password_encrypt($pass);
	$stmt = $DBH->prepare($query);
	if($stmt->execute(array(":username" => $user, ":password"=>$encryptedPassword, ":email"=>$email, ":confirmcode"=>$confirmcode))) {
		sendConfirmationEmail($user,$email,$confirmcode);
		echo "success";
		return true;
	} else {
		echo "Crticial error that may or may not be related to your user activity.";
		return false;
	}
}

/**Send e-mail code, this will have the main message.
I didn't want to crowd the main register function **/
function sendConfirmationEmail($user,$email,$key) {
	$message  = 
	"Clicking the link below will confirm your email address, and begin your Erdos learning adventure:
	http://localhost/erdos/confirmemail.php?user=$user&confirmcode=$key
	";
	
	echo $message;
	
	mail($email,"Erdos Confirm Email", $message, "From: welcome@geterdos.com");
}



?>