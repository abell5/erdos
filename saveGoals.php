<?php

require_once('session_handler.php');
sessionPersist();


/*CHECK THAT EMAIL MATCHES, NOT ID.
A USER SHOULD ONLY BE ABLE TO SAVE THIS STUFF IF THEY ARE LOGGED IN.*/

global $user;
$user = $_SESSION['canary']['id'];

if($user == $_POST['user']) {
	echo "user doesn't match";
	return false;
} else {
	$goal = intval($_POST['goal']);
	$goalDays = intval($_POST['goalDays']);
	$user = $_POST['user']; //<------- THIS LINE NEEDS TO BE REMOVED
	$query = 'UPDATE `users`
				  SET `goal` = :goal, `goalDays` = :goalDays
				  WHERE `username` = :user';
	$stmt = $DBH->prepare($query);
	if($stmt->execute( array(':user' => $user, ':goal' => $goal, ':goalDays' => $goalDays))) {
		echo "Why are you listening to this?";
	} else {
		//Error handling
	}
}


?>