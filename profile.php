<?php


require_once('session_handler.php');
sessionPersist();

global $user;

if(isset($_SESSION['canary']['email'])) {
	$user = $_SESSION['canary']['email'];
} elseif(isset($_SESSION['canary']['id'])) {
	$user = $_SESSION['canary']['id'];
}

/********THIS IS A TEST STATEMENT, REMOVE THIS LATER************/
$user = '0e4602da371c691fc2e348bf3f53a3e1';

echo $user;
echo "<br><br>";

/*I will move these dashboard functions to their own file later*/
require_once('include/db_connect.php');

class Dashboard
{
	protected $user;
	protected $DBH;
	protected $types;
	
	public function __construct($user, $DBH) {
		$this->user = $user;
		$this->DBH = $DBH;
	}
	
	public function getProblemsByType($type) {
		$query = "SELECT *
						FROM `response_data`
						WHERE `user_id` = :user AND `type` = :type";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":type"=>$type))) {
				$rows = $stmt->fetchAll();
				var_dump($rows);
		}
	}

	public function getCorrectByType($type) {
		$query = "SELECT *
						FROM `response_data`
						WHERE `user_id` = :user AND `type` = :type AND `response` = `correct_answer`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":type"=>$type))) {
				$rows = $stmt->fetchAll();
				var_dump($rows);
		}
	}
	
	public function getNumberByType($type) {
		$query = "SELECT count(`id`) as Num
						FROM `response_data`
						WHERE `user_id` = :user AND `type` = :type
						GROUP BY `type`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":type"=>$type))) {
				$rows = $stmt->fetch();
				if(empty($rows)) {
					return 0;
				} else {
					return $rows['Num'];
				}
		}		
	}
	
	public function getNumberCorrectByType($type) {
		$query = "SELECT count(`id`) as Num
						FROM `response_data`
						WHERE `user_id` = :user AND `type` = :type AND `response` = `correct_answer`
						GROUP BY `type`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":type"=>$type))) {
				$rows = $stmt->fetch();
				if(empty($rows)) {
					return 0;
				} else {
					return $rows['Num'];
				}
		}				
	}
	
	public function getPercentageByType($type) {
			$denominator = $this->getNumberByType($type);
			$numerator = $this->getNumberCorrectByType($type);
			
			if($denominator!=0) {
				$percentage = $numerator/$denominator;
			} else {
				return -1;
			}
			return $percentage;
			
	}
	
	public function softResponse($p) {
		if($p>=0 && $p < 0.67) {
			return "We should work on this topic.";
		}
		elseif($p>= 0.67 && $p < 0.80) {
			return "You are on the road to mastery!";
		}
		elseif($p>=0.8) {
			return "You rock this topic.";
		}
		else
		{
			return "We haven't practiced this topic yet.";
		}
	}
	
	public function getListOfTypes() {
		$query = "SELECT DISTINCT `type`
						FROM `sat_problems`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute()) {
			$rows=$stmt->fetchAll(PDO::FETCH_COLUMN);
			return $rows;
		}			
	}
	
}


?>

<html>
<head>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}


</style>
</head>
<body>
<table style="width:60%" border="1">
<?php
$dashboard = new Dashboard($user, $DBH);

$listOfTypes = $dashboard->getListofTypes();

foreach($listOfTypes as $type) {
	$perc = $dashboard->getPercentageByType($type);
	if($perc) {
		echo "<tr>";
			echo "<th>" . $type . "</th>";
			echo "<th>" . $perc . "</th>";
			echo "<th>" . $dashboard->getNumberByType($type) . "</th>";
			echo "<th>" . $dashboard->softResponse($perc) . "</th>";
		echo "</tr>";
	}
}

?>
</table>

</body>
</html>

