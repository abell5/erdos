<?php

include_once("session_handler.php");


$feedback = $_POST['feedback'];
$comments = $_POST['comments'];

include_once( dirname( __FILE__ ) . '/include/db_connect.php' );
$query = $DBH->prepare( 'INSERT INTO `feedback` (user_id, datetime, feedback, comments) VALUES (:user_id, Now(), :feedback, :comments)');
$query->execute( array(':user_id' => $user, ':feedback' => $feedback, ':comments' => $comments));

?>