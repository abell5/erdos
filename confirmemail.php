<?php
require_once('include/db_connect.php');

$email = filter_var(($_GET['email']), FILTER_SANITIZE_STRING);
$confirmcode = filter_var($_GET['confirmcode'], FILTER_SANITIZE_STRING);

if(empty($email) || empty($confirmcode)) {
	echo "There was an error confirming your email.";
} else {
	$query = "SELECT `confirmcode` FROM `users` WHERE (`email`) = :email LIMIT 1";
	$stmt = $DBH->prepare($query);
	$stmt->bindValue(':email',$email);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if($row['confirmcode'] == $confirmcode) {
		$query = "UPDATE `users`SET `confirmcode`=1 WHERE (`email`) = :email LIMIT 1";
		$stmt = $DBH->prepare($query);
		$stmt->bindValue(':email',$email);
		$stmt->execute();
		echo "Thank you for confirming your e-mail.";
	} else {
		echo "Incorrect confirmation code.";
	}
}

