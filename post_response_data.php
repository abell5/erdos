<?php
include_once( dirname( __FILE__ ) . '/include/db_connect.php' );
include_once("session_handler.php");

$pid = $_POST['pid'];
$ptext = $_POST['ptext'];
$response = $_POST['response'];
$response_text = $_POST['response_text'];
$module= $_POST['module'];
$type = $_POST['type'];
$correct_answer = $_POST['correct_answer'];
$displayedTree = $_POST['displayedTree'];

echo "You can hear me?  Why are you listening?";


$query = "INSERT INTO `response_data` (`user_id`, `datetime`,`pid`, `ptext`, `response`, `response_text`,`module`,`type`,`correct_answer`,`displayedTree`) VALUES (:user_id, Now(), :pid, :ptext, :response, :response_text, :module, :type, :correct_answer, :displayedTree)";
$stmt = $DBH->prepare($query);

$stmt->bindValue(':user_id', $user);
$stmt->bindValue(':pid', $pid);
$stmt->bindValue(':ptext', $ptext);
$stmt->bindValue(':response', $response);
$stmt->bindValue(':response_text', $response_text);
$stmt->bindValue(':module', $module);
$stmt->bindValue(':type', $type);
$stmt->bindValue(':correct_answer', $correct_answer);
$stmt->bindValue(':displayedTree', implode(",",$displayedTree));
$stmt->execute();


?>
	