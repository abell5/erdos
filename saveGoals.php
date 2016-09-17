<?php

require_once('session_handler.php');
require_once('include/db_connect.php');
sessionPersist();

global $user;
if(!isset($_SESSION['canary']['id'])) {
	//error handling
} else {
	$user = $_SESSION['canary']['id'];

	$goal = intval($_POST['goal']);
	$goalDays = intval($_POST['goalDays']);
	
	$query = 'UPDATE `users`
				  SET `goal` = :goal, `goalDays` = :goalDays
				  WHERE `userId` = :user';
	$stmt = $DBH->prepare($query);
	if($stmt->execute( array(':user' => $user, ':goal' => $goal, ':goalDays' => $goalDays))) {
	} else {
		//Error handling
	}
}

$loggedin = [];
if(!$_SESSION['canary']['loggedin']) {
	$loggedin['status'] = false;
} else {
	$loggedin['status'] = true;
}
echo json_encode($loggedin);


?>