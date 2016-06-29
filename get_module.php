<?php

if(!isset($_GET['mid'])) {
	header('400 Bad Request');
} else {
	$id = $_GET['mid'];
	$data;
}


try {
	require('include/db_connect.php'); //Creates $DBH
	
	//query is problem
	$query = "SELECT `pid` FROM `module_problems` WHERE `mid` = :id ORDER BY `id`";
	$stmt = $DBH->prepare($query);
	$stmt->bindValue(':id',$id);
	
	if($stmt->execute()) {
		$module_problems= $stmt->fetchAll(PDO::FETCH_COLUMN); //this makes a 0 indexed array with 
																						//0->a, 1->b, etc
		$data = $module_problems;
	}
	
	echo json_encode($data);
	
} catch(Exception $e) {
	echo "Uh-oh";
}

?>