<?php
require_once('include/db_connect.php');
require_once('encryptionFunctions.php');


if(!isset($_GET['email'])) {
	echo "No e-mail provided.";
	die();
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
		echo "Found a matching, unexpired row.";
	
			echo 'Please enter your new password. <br>
			<form method="POST" action="changePassword.php">
			New Password:  <input type="password" name="pass"/><br/>
			Confirm Password:  <input type="password" name="confirmPass"/><br/>
			<input type="hidden" name="confirmkey" value="' . $confirmkey . '"/>
			<input type="hidden" name="email" value="' . $email . '"/>
			<input type="submit">
			</form>';
			
			
			/*
			$newPass = sprintf("%06d", mt_rand(1, 999999));
			
			$query = "UPDATE `users`SET `password`= :newPass WHERE (`email`) = :email LIMIT 1";
			$stmt = $DBH->prepare($query);
			if($stmt->execute(array(":newPass"=>$newPass, ":email"=>$email))) {
				echo "You have been e-mailed a new password.";
				$message  = 
				"Your new Erdos password: $newPass
				";
				echo $message;
				mail($email,"Your latest Erdos password", $message, "From: welcome@geterdos.com");	
			} else {
				echo "Database query failed.";
			}
			*/
		
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
		"Clicking the link below to reset your Erdos password:
		http://localhost/erdos/forgotpassword.php?email=$email&confirmkey=$tempConfirmkey
		";
		echo $message;
		mail($email,"Fruitfulness over Forgetfullness from Erdos", $message, "From: welcome@geterdos.com");
	} else {
		//Error handling.
		echo "A critical error occured.";
	}
} 

