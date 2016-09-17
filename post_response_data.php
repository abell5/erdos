<?php
include_once( dirname( __FILE__ ) . '/include/db_connect.php' );
include_once("session_handler.php");
sessionPersist();

$user = getUserId();

$pid = $_POST['pid'];
$ptext = $_POST['ptext'];
$response = $_POST['response'];
$response_text = $_POST['response_text'];
$module= $_POST['module'];
$major_topic = $_POST['major_topic'];
$subtopic = $_POST['subtopic'];
$correct_answer = $_POST['correct_answer'];
$displayedTree = $_POST['displayedTree'];

echo "You can hear me?  Why are you listening?";


$query = "INSERT INTO `response_data` (`user_id`, `datetime`,`pid`, `ptext`, `response`, `response_text`,`module`,`major_topic`,`subtopic`,`correct_answer`,`displayedTree`) VALUES (:user_id, Now(), :pid, :ptext, :response, :response_text, :module, :major_topic, :subtopic, :correct_answer, :displayedTree)";
$stmt = $DBH->prepare($query);

$stmt->bindValue(':user_id', $user);
$stmt->bindValue(':pid', $pid);
$stmt->bindValue(':ptext', $ptext);
$stmt->bindValue(':response', $response);
$stmt->bindValue(':response_text', $response_text);
$stmt->bindValue(':module', $module);
$stmt->bindValue(':major_topic', $major_topic);
$stmt->bindValue(':subtopic', $subtopic);
$stmt->bindValue(':correct_answer', $correct_answer);
$stmt->bindValue(':displayedTree', implode(",",$displayedTree));
$stmt->execute();


?>
	