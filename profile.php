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
$user = 'ef82ad19df592dd26dc9e1e2b4563a63';

//echo $user;
//echo "<br><br>";

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

	public function getProblemsByDiff($diff) {
		$query = "SELECT A.*, B.difficulty FROM `response_data` as A LEFT JOIN `sat_problems` as B
						ON A.pid = B.id
						WHERE `user_id` = :user AND `difficulty` = :diff";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":diff"=>$diff))) {
				$rows = $stmt->fetchAll();
				var_dump($rows);
		}
	}

	public function getCorrectByDiff($diff) {
		$query = "SELECT A.*, B.difficulty FROM `response_data` as A LEFT JOIN `sat_problems` as B
						ON A.pid = B.id
						WHERE `user_id` = :user AND `difficulty` = :diff AND `response` = `correct_answer`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":diff"=>$diff))) {
				$rows = $stmt->fetchAll();
				var_dump($rows);
		}
	}
	
	public function getNumberByDiff($diff) {
		$query = "SELECT count(`A`.`id`) as Num
						FROM `response_data` as A LEFT JOIN `sat_problems` as B
						ON A.pid = B.id
						WHERE `user_id` = :user AND `difficulty` = :diff
						GROUP BY `difficulty`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":diff"=>$diff))) {
				$rows = $stmt->fetch();
				if(empty($rows)) {
					return 0;
				} else {
					return $rows['Num'];
				}
		}
	}

		public function getNumberCorrectByDiff($diff) {
		$query = "SELECT count(`A`.`id`) as Num
						FROM `response_data` as A LEFT JOIN `sat_problems` as B
						ON A.pid = B.id
						WHERE `user_id` = :user AND `difficulty` = :diff AND `response` = `correct_answer`
						GROUP BY `difficulty`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":diff"=>$diff))) {
				$rows = $stmt->fetch();
				if(empty($rows)) {
					return 0;
				} else {
					return $rows['Num'];
				}
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

	public function getPercentageByDiff($diff) {
			$denominator = $this->getNumberByDiff($diff);
			$numerator = $this->getNumberCorrectByDiff($diff);
			
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

	public function getListOfDiffs() {
		$query = "SELECT DISTINCT `difficulty`
						FROM `sat_problems`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute()) {
			$rows=$stmt->fetchAll(PDO::FETCH_COLUMN);
			return $rows;
		}			
	}
	
}

//$dashboard = new Dashboard($user, $DBH);
//var_dump($dashboard->getListOfDiffs());
?>

<html>
<head>

<!--Favicon-->
<link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico' />

<!--MathJax-->
<script type="text/javascript" async src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML"></script>

<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript and CSS -->
<script src="js/bootstrap.min.js"></script>
<link href="css/bootstrap.css" rel="stylesheet">

<!--Google Font-->
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,900' rel='stylesheet' type='text/css'>

<!--Main page stylesheets-->
<link rel="stylesheet" href="css/profile.css">


</head>
<body>
<div id="topbar">

</div>

<div id="left-sidebar" class="shadow">
	<div class="left-sidebar-header">
		<div class="left-sidebar-logo">
			<img src="img/module-logo.png"/>
		</div>
		<h3>abell5@g.clemson.edu</h3>
	</div>
	<div class="left-sidebar-menu">
		<div class="left-sidebar-item selected">
			<h4><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Dashboard</h4>
		</div>
		<div class="left-sidebar-item">
			<h4><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>Settings</h4>
		</div>
		<div class="left-sidebar-item">
			<h4><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>Premium</h4>
		</div>	
	</div>
</div>

<div id="content">
	<div class="widget">
		<div class="widget-header"><h6>Progress</h6></div>
		<div class="widget-body">
			<div class="widget-main-item">
				<div class="expand-button">+</div>Basic Algebra<span class="grey">We haven't practiced this topic yet.</span>
			</div>
			<div class="widget-subtopic-item">
				Solving linear equations<span class="grey">We haven't practiced this topic yet.</span>
			</div>
			<div class="widget-subtopic-item">
				Interpreting linear functions<span class="grey">We haven't practiced this topic yet.</span>
			</div>
			<div class="widget-subtopic-item">
				Equation word problems<span class="grey">We haven't practiced this topic yet.</span>
			</div>
			<div class="widget-subtopic-item">
				Graphing linear equations<span class="grey">We haven't practiced this topic yet.</span>
			</div>
			<div class="widget-subtopic-item">
				Linear function word problems<span class="grey">We haven't practiced this topic yet.</span>
			</div>			
			<div class="widget-main-item">Advanced Algebra<span class="grey">We haven't practiced this topic yet.</span></div>
			<div class="widget-main-item">Problem Solving and Data Analysis<span class="grey">We haven't practiced this topic yet.</span></div>
			<div class="widget-main-item">Additional Topics in Math<span class="grey">We haven't practiced this topic yet.</span></div>
		</div>
	</div>
</div>

</body>
</html>



<?php
/*
$dashboard = new Dashboard($user, $DBH);

$listOfDiffs = $dashboard->getListofDiffs();

foreach($listOfDiffs as $diff) {
	$perc = $dashboard->getPercentageByDiff($diff);
	if($perc!=-1) {
		echo "<tr>";
			echo "<th>" . $diff . "</th>";
			echo "<th>" . $perc . "</th>";
			echo "<th>" . $dashboard->getNumberByDiff($diff) . "</th>";
			echo "<th>" . $dashboard->softResponse($diff) . "</th>";
		echo "</tr>";
	}
}
*/

/*
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
*/
?>
