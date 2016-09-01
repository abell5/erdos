<?php
require_once('include/db_connect.php');
require_once('encryptionFunctions.php');

echo "PASS" . $_POST['confirmPass'];

$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
$confirmPass = filter_var($_POST['confirmPass'], FILTER_SANITIZE_STRING);
$confirmkey = filter_var($_POST['confirmkey'],FILTER_SANITIZE_STRING);

$errors = [];

/*		
		$query = "UPDATE `password_change_requests`SET `expired`=1 WHERE (`id`) = :id LIMIT 1";
		$stmt = $DBH->prepare($query);
		$stmt->bindValue(':id',$row['id']);
*/
/*Check if anything is empty */
if(empty($pass) || empty($confirmPass) || empty($email) || empty($confirmkey)){
	echo $pass . $confirmPass . $email . $confirmkey;
	array_push($errors, "You must enter both a new password and a confirmation password.");
}

/*Check that passwords match*/
if($pass != $confirmPass) {
	array_push($errors, "One of those passwords is not like the other.");
}

/*Make sure password meets password requirements... right now just 20 character placeholder */
if(strlen($pass) > 20 ) {
	array_push($errors,"Password must be less than 20 characters.");
}

/*Check that no funny business has occured with the confirmation key and the email */
if(empty($errors)) {
	$query = "SELECT `id` FROM `password_change_requests` WHERE (`email`) = :email AND (`confirmkey`) = :confirmkey AND (`expired`) = 0 LIMIT 1";
	$stmt = $DBH->prepare($query);
	$stmt->execute(array(":email"=>$email, ":confirmkey"=>$confirmkey));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if(empty($row['id'])) {
		array_push($errors,"There was an error.");
	}
}

/*Change the password and update the expired column in the 'password_change_requests'*/
if(empty($errors)) {
	$encryptedPassword = password_encrypt($pass);
	
	$query = "UPDATE `users` SET `password` = :password
				WHERE (`email`) = :email LIMIT 1";
	$stmt = $DBH->prepare($query);
	if($stmt->execute(array(":password"=>$encryptedPassword, ":email"=>$email))) {	
		$query = "UPDATE `password_change_requests`SET `expired`=1 WHERE (`id`) = :id LIMIT 1";
		$stmt = $DBH->prepare($query);
		$stmt->bindValue(':id',$row['id']);
		if($stmt->execute()){
			header('Location: login.php?msg=1');
		} else {
			//Error handling
		}
	} else {
		echo "Crticial error that may or may not be related to your user activity.";
		return false;
	}
} else {
	foreach ($errors as $e) {
		echo $e . "<br>";
	}	
}


?>