<?php

if(!isset($_GET['id'])) {
	header('400 Bad Request');
} else {
	$id = $_GET['id'];
	$data;
}


try {
	require('include/db_connect.php'); //Creates $DBH
	
	//query is problem
	$query = "SELECT * FROM `sat_problems` WHERE `id` = :id";
	$stmt = $DBH->prepare($query);
	$stmt->bindValue(':id',$id);
	//next_query is choices
	
	$nquery = "SELECT * FROM `sat_answers` WHERE `pid` = :nid";
	$nstmt = $DBH->prepare($nquery);
	$nstmt->bindValue(':nid',$id);
	
	if($stmt->execute()) {
		if($nstmt->execute()) {
			$problem_rows = $stmt->fetch(PDO::FETCH_ASSOC);
			$choice_rows = $nstmt->fetchAll(PDO::FETCH_ASSOC); //this makes a 0 indexed array with 
																							//0->a, 1->b, etc
			
			//$data = $problem_rows;
			$data = (object) ['problem' => $problem_rows, 'choices' => $choice_rows];
			//var_dump($data);
		}
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