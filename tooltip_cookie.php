<?php
include_once("session_handler.php");
sessionPersist();
$user = getUserId();

$cookieName = $_POST['name'];
$cookieValue = "closed";

if(!isset($_COOKIE["{$cookieName}"])) {
	setcookie($cookieName,1, time() + (86400 * 30), "/"); //86400 = 1 day
} else {
	setcookie($cookieName,2,time() + (86400 * 30), "/");
}



?>