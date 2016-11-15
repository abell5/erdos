<?php
require_once('session_handler.php');
sessionPersist();
sessionDestroy();

header("Location: app.php");


?>