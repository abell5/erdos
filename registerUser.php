<?php
require_once('include/db_connect.php');
require_once('encryptionFunctions.php');
require_once('session_handler.php');
sessionPersist();

/**Retrieve posted variables **/
$email = $_POST['email'];
$pass = $_POST['pass'];
$confirmPass = $_POST['confirmPass'];

$errors = [];

/*Check that private key was generated-- if it wasn't, may be a case of session hijacking*/
if(!isset($_SESSION['canary']['id'])) {
	array_push($errors, "An error occured and user session could not be retrieved");
} else {
	$user = $_SESSION['canary']['id'];
}


/* Check e-mail */
if(filter_var($email, FILTER_VALIDATE_EMAIL)!=$email) {
	array_push($errors, "Please enter a valid e-mail address.");
}

/*Check RegEx for e-mail*/
$pattern = "/[a-zA-Z0-9._^%$#!~@-]{5,17}$/";
if(!preg_match($pattern, $pass)) {
	array_push($errors, "Password is invalid");
}


/* Check username length */
/*
if(strlen($user) > 16 ) {
	array_push($errors, "Username must be shorter than 16 characters.");
}
*/

/*Check if passwords match */
if($pass != $confirmPass) {
	array_push($errors, "One of those passwords is not like the other.");
}

/*Check if e-mail already exists */
$query = "SELECT * FROM `users` WHERE LOWER(`email`) = :email";
$stmt = $DBH->prepare($query);
$stmt->bindValue(':email',strtolower($email));	
$stmt->execute();

if($stmt->rowCount() > 0) {
	array_push($errors, "Someone with that e-mail address is already learning on Erdos!");
}



/*** End checks ***/


/**Begin main register function **/
if(!empty($errors)) {
	header("Location: register.php?error=1");
	/*
	foreach ($errors as $e) {
		echo $e . "<br>";
	}
	*/
} else {
	$confirmcode = md5($email . rand());
	
	$query = "UPDATE `users`
					SET `password`=:password,`email`=:email,`confirmcode`=:confirmcode
					WHERE `userId`=:user";
	$encryptedPassword = password_encrypt($pass);
	$stmt = $DBH->prepare($query);
	if($stmt->execute(array(":password"=>$encryptedPassword, ":email"=>$email, ":confirmcode"=>$confirmcode,":user"=>$user))) {
		sendConfirmationEmail($email,$confirmcode);
		sessionLogin($user,$email,0);
		header("Location: app.php?p=practice");
		die();
		return true;
	} else {
		echo "Crticial error that may or may not be related to your user activity.";
		return false;
	}
}

/**Send e-mail code, this will have the main message.
I didn't want to crowd the main register function **/
function sendConfirmationEmail($email,$key) {
	$message  = 
	"Clicking the link below will confirm your email address, and begin your Erdos learning adventure:
	http://localhost/erdos/confirmemail.php?email=$email&confirmcode=$key
	";
	
	echo $message;
	mail($email,"Erdos Confirm Email", $message, "From: welcome@geterdos.com");

	
}



?>