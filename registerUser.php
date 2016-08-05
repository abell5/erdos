<?php
require_once('include/db_connect.php');
require_once('encryptionFunctions.php');

/**Retrieve posted variables **/
$user = $_POST['user'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$confirmPass = $_POST['confirmPass'];

$errors = [];
/* check e-mail */
if(filter_var($email, FILTER_VALIDATE_EMAIL)!=$email) {
	array_push($errors, "Please enter a valid e-mail address.");
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

if(!empty($errors)) {
	foreach ($errors as $e) {
		echo $e . "<br>";
	}
} else {
	$query = "INSERT INTO `users` (`username`, `password`)
				VALUES (:username, :password)";
	$encryptedPassword = password_encrypt($_POST['pass']);
	$stmt = $DBH->prepare($query);
	$stmt->execute(array(":username" => $_POST['user'], ":password"=>$encryptedPassword));
	
	echo "User created.";
	$_SESSION['user'] = $_POST['user'];
	return true;
}

?>