<?php


if(!isset($_GET['qid'])) {
	header('400 Bad Request');
} else {
	$qid = $_GET['qid'];
	$data;
	$mc;
}


try {
	require('include/db_connect.php'); //Creates $DBH
	
	$query = "SELECT * FROM `ques` WHERE `id` = :id";
	$stmt = $DBH->prepare($query);
	$stmt->bindValue(':id',$qid);
	
	if($stmt->execute()) {
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($data['type']="mc") {
			$data = array_merge($rows, get_mc($qid, $DBH));
		} else {
			$data = $rows;
		}
	}
		//var_dump($data);
	

	echo json_encode($data);
	
	
} catch(Exception $e) {
	echo "Uh-oh";
}

function get_mc($mc_id, $DB) {

	$query = "SELECT `value` FROM `mc` WHERE `q_id` = :qid";
	$stmt = $DB->prepare($query);
	$stmt->bindValue(':qid',$mc_id);
	/*Get rows*/
	if($stmt->execute()) {
		$options = $stmt->fetchAll(PDO::FETCH_COLUMN);
		$length = sizeof($options);
		$options['num_of_response'] = $length;
		return $options;
	}
	
}

?>