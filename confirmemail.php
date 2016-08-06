<?php
require_once('include/db_connect.php');

$user = filter_var(($_GET['user']), FILTER_SANITIZE_STRING);
$confirmcode = filter_var($_GET['confirmcode'], FILTER_SANITIZE_STRING);

if(!isset($user) || !isset($confirmcode)) {
	echo "There was an error confirming your email.";
} else {
	$query = "SELECT `confirmcode` FROM `users` WHERE (`username`) = :username LIMIT 1";
	$stmt = $DBH->prepare($query);
	$stmt->bindValue(':username',$user);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if($row['confirmcode'] == $confirmcode) {
		$query = "UPDATE `users`SET `confirmcode`=1 WHERE (`username`) = :username LIMIT 1";
		$stmt = $DBH->prepare($query);
		$stmt->bindValue(':username',$user);
		$stmt->execute();
	} else {
		echo "Incorrect confirmation code.";
	}
}

