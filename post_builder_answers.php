<?php
include_once( dirname( __FILE__ ) . '/include/db_connect.php' );
//sessionPersist();
//$user = getUserId();

$pid = $_POST['pid'];
$text = $_POST['text'];
$choice = $_POST['choice'];
$action = $_POST['action'];
if(isset($_POST['action_to'])) {
	$action_to = $_POST['action_to'];
} else {
	$action_to = 0;
}
echo $action . "<br>";
$assist_text = $_POST['assist_text'];



echo "You can hear me?  Why are you listening?";

$query = "INSERT INTO `sat_answers`
				(
				`pid`,
				`text`,
				`choice`,
				`action`,
				`action_to`,
				`assist_text`
				)
				VALUES
				(
				:pid,
				:text,
				:choice,
				:action,
				:action_to,
				:assist_text		
				)";

$stmt = $DBH->prepare($query);
$stmt->bindValue(':pid', $pid);
$stmt->bindValue(':text', $text);
$stmt->bindValue(':choice', $choice);
$stmt->bindValue(':action', $action);
$stmt->bindValue(':action_to', $action_to);
$stmt->bindValue(':assist_text', $assist_text);
$stmt->execute();


?>
	