<?php
include_once('include/db_connect.php');

$desiredEmail = $_GET['desiredEmail'];

$query = "SELECT * FROM `users` WHERE LOWER(`email`) = :email";
$stmt = $DBH->prepare($query);
$stmt->bindValue(':email',strtolower($desiredEmail));	
$stmt->execute();



if($stmt->rowCount() > 0) {
	$response['available'] = 0;
	echo json_encode($response);
} else {
	$response['available'] = 1;
	echo json_encode($response);
}



?>