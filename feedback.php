<?php

$feedback = $_POST['feedback'];
$comments = $_POST['comments'];

include_once( dirname( __FILE__ ) . '/include/db_connect.php' );
$query = $DBH->prepare( 'INSERT INTO `feedback` (datetime, feedback, comments) VALUES (Now(), :feedback, :comments)');
$query->execute( array(':feedback' => $feedback, ':comments' => $comments));

?>