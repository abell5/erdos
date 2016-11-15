<?php
include_once( dirname( __FILE__ ) . '/include/db_connect.php' );
//sessionPersist();
//$user = getUserId();

$pid = $_POST['id'];
$text = $_POST['text'];
$answer = $_POST['answer'];
$subtopic = $_POST['subtopic'];
$major_topic = $_POST['major_topic'];
$difficulty = $_POST['difficulty'];

echo "You can hear me?  Why are you listening?";

$query = "INSERT INTO `sat_problems`
				(
				`id`,
				`text`,
				`answer`,
				`subtopic`,
				`major_topic`,
				`difficulty`
				)
				VALUES
				(
				:pid,
				:text,
				:answer,
				:subtopic,
				:major_topic,
				:difficulty
				)";

$stmt = $DBH->prepare($query);
$stmt->bindValue(':pid', $pid);
$stmt->bindValue(':text', $text);
$stmt->bindValue(':answer', $answer);
$stmt->bindValue(':subtopic',$subtopic);
$stmt->bindValue(':major_topic',$major_topic);
$stmt->bindValue(':difficulty',$difficulty);
$stmt->execute();


?>
	