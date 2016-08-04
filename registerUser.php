<?php
require_once('include/db_connect.php');
require_once('encryptionFunctions.php');

if($_POST['pass'] == $_POST['confirmPass']) {
	

	$query = "SELECT * FROM `users` WHERE LOWER(`username`) = :username";
	$stmt = $DBH->prepare($query);
	$stmt->bindValue(':username',strtolower($_POST['user']));
	$stmt->execute();

	if($stmt->rowCount() > 0) {
		echo "Username already exists.";
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
	
} else {
	
	echo "Passwords do not match.";
	
}

?>