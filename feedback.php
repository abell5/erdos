<?php

include_once("session_handler.php");


$feedback = $_POST['feedback'];
$comments = $_POST['comments'];
$displayedTree = $_POST['displayedTree'];

include_once( dirname( __FILE__ ) . '/include/db_connect.php' );
$query = $DBH->prepare( 'INSERT INTO `feedback` (user_id, datetime, displayedTree, feedback, comments) VALUES (:user_id, Now(), :displayedTree, :feedback, :comments)');
$query->execute( array(':user_id' => $user, ':displayedTree' => $displayedTree, ':feedback' => $feedback, ':comments' => $comments));

?>