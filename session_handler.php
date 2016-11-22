<?php
ini_set('session.cookie_httponly',true);
require_once('encryptionFunctions.php');

function sessionDestroy() {
	session_unset();
	session_destroy();
}

function openSession() {
	$userId = md5(session_id() . rand() . time() );
	$_SESSION['canary'] = [
		'birth' => time(),
		'IP' => $_SERVER['REMOTE_ADDR'],
		'loggedin' => false,
		'id' => $userId,
		'premium' => 0
	];
	addUnregisteredUser($userId);
}

function addUnregisteredUser($id) {
	require_once('include/db_connect.php');
	echo "here4";

	$query = "INSERT INTO `users` (`userId`,`datetimeCreated`) VALUES (:user, Now())";
	$stmt = $DBH->prepare($query);	
	if($stmt->execute(array(":user"=>$id))) {
		return true;
	} else {
		//Error handling
	}
}

function sessionPersist() {
	session_start();
	if(!isset($_SESSION['canary'])) {
		openSession();
	} else {	
		if($_SESSION['canary']['loggedin'] === true && isset($_SESSION['email'])) {
			if ($_SESSION['canary']['IP'] !== $_SERVER['REMOTE_ADDR']) {
				//Unset the logged information
				unset($_SESSION['canary']['email']);
				$_SESSION['loggedin'] == false;
			}
			
		} 
		//Stuff for every session user
		// Regenerate session ID every five minutes:
		if ($_SESSION['canary']['birth'] < time() - 300) {
			session_regenerate_id(true);
			$_SESSION['canary']['birth'] = time();
		}
	}
}

function sessionLogin($userId, $email,$premium) {
	$_SESSION['canary']['id'] = $userId;
	$_SESSION['canary']['loggedin'] = true;
	$_SESSION['canary']['email'] = $email;
	$_SESSION['canary']['premium'] = $premium;
}

function getUserID() {
	if(!isset($_SESSION['canary'])) {
		sessionPersist();
	} else {
		return $_SESSION['canary']['id']; 
	}
}

?>