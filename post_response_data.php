<?php
include_once( dirname( __FILE__ ) . '/include/db_connect.php' );
include_once("session_handler.php");

$pid = $_POST['pid'];
$ptext = $_POST['ptext'];
$response = $_POST['response'];
$response_text = $_POST['response_text'];

echo "You can hear me?  Why are you listening?";


$query = "INSERT INTO `response_data` (`user_id`, `pid`, `ptext`, `response`, `response_text`) VALUES (:user_id, :pid, :ptext, :response, :response_text)";
$stmt = $DBH->prepare($query);

$stmt->bindValue(':user_id', $user);
$stmt->bindValue(':pid', $pid);
$stmt->bindValue(':ptext', $ptext);
$stmt->bindValue(':response', $response);
$stmt->bindValue(':response_text', $response_text);
$stmt->execute();


?>
