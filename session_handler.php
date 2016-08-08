<?php
ini_set('session.cookie_httponly',true);
require_once('include/db_connect.php');

function sessionDestroy() {
	session_unset();
	session_destroy();
}

function sessionLogin($email, $premium) {
	sessionPersist();
	
	$_SESSION['canary']['loggedin'] = true;
	$_SESSION['canary']['email'] = $email;
	$_SESSION['canary']['premium'] = $premium;
	
	var_dump($_SESSION['canary']);
}

function openSession() {
	session_start(); //Begin the session
	$_SESSION['canary'] = [
		'birth' => time(),
		'IP' => $_SERVER['REMOTE_ADDR'],
		'loggedin' => false,
		'id' => md5(session_id() . rand() . time() ),
		'premium' => 0
	];
}

function sessionPersist() {
	if(!isset($_SESSION['canary'])) {
		openSession();
	} else {
		session_start();
	
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


/*
if(version_compare(phpversion(), '5.4.0')>0) {
	if(session_status() == PHP_SESSION_NONE) {
		session_start();
	}
} else {
	if(session_id() == '') {
		session_start();
	}
}

$user = session_id();

function checkPremium($email) {
	$query = 'SELECT `premium` FROM `users` WHERE `email` = :email';
	$stmt = $DBH->prepare($query);
	if($stmt->execute(array(":email" => $email))) {
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($row)) {
			return $row['premium'];
		} else {
			//Something weird happened.  An invalid email address was passed into checkpremium.
		}
	} else {
		//Database error.  Initatiate all of error handling.
	}
}
*/
?>