<?php

if(!isset($_GET['id'])) {
	header('400 Bad Request');
} else {
	$id = $_GET['id'];
	$data;
}


try {
	require('include/db_connect.php'); //Creates $DBH
	
	
	$query = "SELECT * FROM `problems` WHERE `id` = :id";
	$stmt = $DBH->prepare($query);
	$stmt->bindValue(':id',$id);
	
	if($stmt->execute()) {
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		$data = $rows;
		//var_dump($data);
	}
	
	echo json_encode($data);
	
} catch(Exception $e) {
	echo "Uh-oh";
}


/*
function get_mc($mc_id, $DB) {

	$query = "SELECT `value` FROM `mc` WHERE `q_id` = :qid";
	$stmt = $DB->prepare($query);
	$stmt->bindValue(':qid',$mc_id);
	//Get rows
	if($stmt->execute()) {
		$options = $stmt->fetchAll(PDO::FETCH_COLUMN);
		$length = sizeof($options);
		$options['num_of_response'] = $length;
		return $options;
	}
	
}
*/
?>