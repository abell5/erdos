<?php
require_once('include/db_connect.php');
require_once('encryptionFunctions.php');
require_once('session_handler.php');

$errors = [];

if($_POST['email'] != filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
	$errors = "Invalid e-mail entered.";
}

$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

if(empty($email) || empty($pass)) {
	$errors = "Missing information.";
}

if(empty($errors)) {
	$query = "SELECT * FROM `users` WHERE `email` = :email LIMIT 1";
	$stmt = $DBH->prepare($query);
	if($stmt->execute(array(":email"=>$email))) {
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row)) {
			
			$set_password = $row['password'];
			$input_password = crypt($pass,$set_password);
			
			if($input_password == $set_password) {
				sessionLogin($email, $row['premium']);
				echo "Logged in";
			} else {
				echo "Incorrect info was entered.";
			}
		} else {
			echo "Incorrect info was entered.";
		}
	} else {
		echo "Connection failed.";
	}
}



?>