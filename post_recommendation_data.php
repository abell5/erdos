<?php
include( dirname( __FILE__ ) . '/include/db_connect.php' );
include_once("session_handler.php");
sessionPersist();

$user = getUserId();

$pid = $_POST['pid'];
$major_topic = $_POST['major_topic'];
$subtopic = $_POST['subtopic'];
$displayed_tree = $_POST['displayed_tree'];

echo "You can hear me?  Why are you listening?";


$query = "INSERT INTO `recommendations` (`userId`,  `major_topic`, `subtopic`, `value`, `referring_id`,`displayed_tree`,`datetime`)
				VALUES (:user_id, :major_topic, :subtopic, 1, :pid, :displayed_tree, Now())";
$stmt = $DBH->prepare($query);

$stmt->bindValue(':user_id', $user);
$stmt->bindValue(':major_topic', $major_topic);
$stmt->bindValue(':subtopic', $subtopic);
$stmt->bindValue(':pid', $pid);
$stmt->bindValue(':displayed_tree', implode(",",$displayed_tree));
$stmt->execute();


?>
	