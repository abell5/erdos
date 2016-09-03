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
	protected $goal;
	protected $goalDays;
	
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
			return "";
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
	
	public function getGoal() {
		$query = "SELECT `goal`
					   FROM `users`
					   WHERE `username`= :user
					   LIMIT 1";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=> $this->user))) {
			$rows = $stmt->fetch();
			return $rows['goal'];
		}
	}
	
	public function getGoalDays() {
		$query = "SELECT `goalDays`
					   FROM `users`
					   WHERE `username`= :user
					   LIMIT 1";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=> $this->user))) {
			$rows = $stmt->fetch();
			return $rows['goalDays'];
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

	<script language="Javascript">
	$(document).ready(function(){ 
		
		var user="mickey"
		
		refreshDom = function() {
			$("#left-sidebar").height($(document).height());
		}
	
		$(".expand-button").click(function() {
			var expand_id = escape($(this).attr("name"));
			$(".widget-subtopic-container[name="+expand_id+"]").slideToggle("fast", function() {
					refreshDom();
			});
		});
		
		$(".save-edits-btn").on("click", function(e) {
			var goalPackage = new Object();
			goalPackage["user"] = user;
			var dataLink = escape($(this).attr("data-link"));
			console.log(dataLink);
			
			$("input[data-link="+dataLink+"]").each(function(index) {
				if($(this).attr("name") == "goal") {
					goalPackage["goal"] = escape($(this).val());
				} else if($(this).attr("name") == "goalDays") {
					goalPackage["goalDays"] = escape($(this).val());
				}
			});
			
			console.log(goalPackage);

			$.ajax({
				type: 'POST',
				url: 'saveGoals.php',
				data: goalPackage,
				success: function () {
					alert('saved');
				}
			});

		});
		
	});
	
	</script>
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
			<h4><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>Dashboard</h4>
		</div>
		<div class="left-sidebar-item">
			<h4><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Account</h4>
		</div>
		<div class="left-sidebar-item">
			<h4><span style="color: #f1c40f" class="glyphicon glyphicon-leaf" aria-hidden="true"></span>Premium</h4>
		</div>	
	</div>
</div>

<div id="content">
	<div class="widget">
		<div class="widget-header"><h6>Progress</h6></div>
		<div class="widget-body">
		
		<?php
		$mainTopics = ["Basic Algebra", "Advanced Algebra", "Problem Solving and Data Analysis", "Additional Topics in Math"];
		$algebraSubtopics = ["Solving linear equations",
										 "Interpreting linear functions",
										 "Linear inequality and equation problems",
										 "Graphing linear equations",
										 "Linear function word problems",
										 "Systems of linear inequatlities",
										 "Solving systems of linear equations",
										];
		$advancedAlgebraSubtopics = ["Solving quadratic equations",
													   "Interpreting nonlinear expression",
													    "Quadratic and exponentials",
														"Radicals and rational exponents",
														"Operations with radicals and polynomials",
														"Polynomial factors and graphs",
														"Nonlinear equation graphs",
														"Linear and quadratic systems",
														"Structure in expressions",
														"Isolating quantities",
														"Functions"
													   ];
		$psdaSubtopics = ["Ratios, rates,  and proportions",
								    "Percents",
									"Units",
									"Table data",
									"Scatterplots",
									"Key feature of graphs",
									"Linear and exponential growth",
									"Data inferences",
									"Center, spread, and shape of distributions",
									"Data collection and conclusions"
									];
		$atmSubtopics = ["Volume word problems",
								    "Right triangle word problems",
									"Congruence and similarity",
									"Right triangle geometry",
									"Angles, arc lengths, and trig functions",
									"Circle theorems",
									"Circle equations",
									"Complex numbers"
									];
									
		$topicStructure = (object) array("Basic Algerba" => $algebraSubtopics,
														  "Advanced Algebra" => $advancedAlgebraSubtopics,
														  "Problem Solving and Data Analysis" => $psdaSubtopics,
														  "Additional Topics in Math" => $atmSubtopics);
		
		$dashboard = new Dashboard($user, $DBH);
		$listOfTypes = $dashboard->getListofTypes();
		
		/*
		foreach($listOfTypes as $type) {
			
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
		
		foreach($topicStructure as $main => $sub) {
			echo "<div class='widget-main-item'>
						<div class='expand-button' name='".str_replace(' ', '', $main)."'>+</div>".$main."
					</div>";
			echo "<div class='widget-subtopic-container' name='".str_replace(' ', '', $main)."'>";
				for($i = 0; $i < sizeof($sub); $i++) {
					$perc = $dashboard->getPercentageByType($sub[$i]);
					if( $i & 1 ) {
						echo "<div class='widget-subtopic-item grey-bg'>";
					} else {
						echo "<div class='widget-subtopic-item'>";
					}
					echo	 $sub[$i]."<span>". $dashboard->softResponse($perc) . "</span>";
					echo "</div>";
				}
			echo "</div>";
		}
		
		
		
		?>
		
		
		</div>
	</div>
	
	<div class="widget">
		<div class="widget-header"><h6>Goals</h6></div>
			<div class="widget-body">
					<?php
					$goalDash = new Dashboard("mickey", $DBH);
					
					?>
				<div class="light-weight-font">
					<table>
						<tr>
							<th><h7>Target score:</h7>
							<input type="text" name='goal' data-link="goals" value="<?php echo $goalDash->getGoal(); ?>" maxlength="4" style="width: 65px; margin-left: 8px;"></th>
						</tr>
						<tr>
							<th><h7>I will practice</h7>
							<input type="text" class="center" data-link="goals" name='goalDays' value="<?php echo $goalDash->getGoalDays(); ?>" maxlength="1" style="width: 30px">
							<h7>days a week</h7><th>
						</tr>
						<tr>
							<th>
							<div class="save-edits-btn" data-link="goals">Save edits</div>
							</th>
						</tr>
					</table>
				</div>
				
			</div>
		</div>
	</div>
	
	
	<div class="widget">
		<div class="widget-header"><h6>Problem Calendar</h6></div>
		<div class="widget-body">
			<?php
	
class Calendar
{
	protected $relativeTo;
	protected $dayTable;
	protected $user;
	protected $DBH;
	protected $n;
	
	public function __construct($user, $DBH, $n) {
		$this->user = $user;
		$this->DBH = $DBH;
		$this->n = $n;
	}
	
	public function getNumberByDay() {
		$query = "SELECT B.date, C.Num
						FROM 
						(
						select * from (
						select date_add('2003-01-01 00:00:00.000', INTERVAL n5.num*10000+n4.num*1000+n3.num*100+n2.num*10+n1.num DAY ) as date from
						(select 0 as num
						   union all select 1
						   union all select 2
						   union all select 3
						   union all select 4
						   union all select 5
						   union all select 6
						   union all select 7
						   union all select 8
						   union all select 9) n1,
						(select 0 as num
						   union all select 1
						   union all select 2
						   union all select 3
						   union all select 4
						   union all select 5
						   union all select 6
						   union all select 7
						   union all select 8
						   union all select 9) n2,
						(select 0 as num
						   union all select 1
						   union all select 2
						   union all select 3
						   union all select 4
						   union all select 5
						   union all select 6
						   union all select 7
						   union all select 8
						   union all select 9) n3,
						(select 0 as num
						   union all select 1
						   union all select 2
						   union all select 3
						   union all select 4
						   union all select 5
						   union all select 6
						   union all select 7
						   union all select 8
						   union all select 9) n4,
						(select 0 as num
						   union all select 1
						   union all select 2
						   union all select 3
						   union all select 4
						   union all select 5
						   union all select 6
						   union all select 7
						   union all select 8
						   union all select 9) n5
						) A
						where date >=DATE_SUB(NOW(), INTERVAL 90 DAY) and date < NOW()
						order by date
						) B
						LEFT JOIN
						(
							SELECT count(`id`) as Num, CAST(`datetime` AS DATE) AS trueDate
							FROM `response_data`
							WHERE `user_id` = :user AND `datetime`>=DATE_SUB(Now(), INTERVAL :n DAY)
							GROUP BY CAST(`datetime` AS DATE) 
						) C
						ON B.date = C.trueDate
						";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":n"=>$this->n))) {
				$rows = $stmt->fetchAll(PDO::FETCH_BOTH);
				if(empty($rows)) {
					return false;
				} else {					
					$this->dayTable = $rows;
					return true;
				}
	
		}				
	}
	
	public function createCalendarArray() {
		if(!isset($this->dayTable)) {
			if(!$this->getNumberByDay()) {
				return false;
			}
		}
		
		$firstDay = date('w', strtotime($this->dayTable[0]["date"]));
		$calendarWidth = ceil($this->n / 7)+1;
		$calendarArray = [];
		$calendarValueArray = [];
		$headerRows = [];
		
		$k = 0; //This is the counter on the dayTable array
		for($j=0; $j<$calendarWidth; $j++) {
			for($i=0; $i<7; $i++) {
				if($k==0) {
					$i = $firstDay;
					for($q=0; $q<$i; $q++) {
						$calendarArray[$j][$q] = NULL;
						$calendarValueArray[$j][$q] = -1;
					}
				} 
				if($k < $this->n) {
				//echo $i . "<br>";
					$calendarArray[$j][$i] = substr($this->dayTable[$k]['date'],0,10);
					$calendarValueArray[$j][$i] = $this->dayTable[$k]['Num'];
					if (is_null($this->dayTable[$k]['Num'])) {
						$calendarValueArray[$j][$i] = 0;
					}
					$k=$k+1;
				} else {
					$calendarValueArray[$j][$i] = 0;
					$calendarArray[$j][$i] = NULL;
				}
			}
		}
		
		//echo $calendarArray[0][0] . "<br><br>";
		//echo $calendarArray[1][0] . "<br><br>";
		//echo $calendarArray[2][0] . "<br><br>";
		//var_dump($calendarArray);
		
		$highTopLevel = [];
		foreach($calendarValueArray as $topLevel) {
			array_push($highTopLevel, max($topLevel));
		}
		$highestValue = max($highTopLevel);

		for($a=0; $a < sizeOf($calendarValueArray); $a++) {
			for($b=0; $b < 7; $b++) {
				$norm = ($calendarValueArray[$a][$b] - 0) / ($highestValue);
				$calendarValueArray[$a][$b] = $norm;
			}
		}		
		
		//Normalize all values in the table.

		
		echo "<table>";
		
		$dayLabels = ["Su","M","Tu","W","Th","F","Sa"];
		
		$k2 = 0; //Count of placed boxes.  Can maybe use this to leverage month labels.
		for($m=0; $m<7; $m++) {
			//Row actions
			echo "<tr>";
				echo "<th class='center'>" . $dayLabels[$m] . "</th>";
				for($n=0; $n < sizeOf($calendarArray); $n++) {
						//echo "<th>" . $calendarArray[$n][$m] . "</th>";
						//echo $calendarArray[$n][$m] . "<br>";
							if($calendarValueArray[$n][$m] == 0 && isset($calendarArray[$n][$m])) {
								echo "<th>" . "<div class='square' title='" . $calendarArray[$n][$m] . "'
													  style='background-color: #ecf0f1 !important'
													></div>" . "</th>";
								$k2 = $k2+1;
							} else {
								
								echo "<th>" . "<div class='square' title='" . $calendarArray[$n][$m] . "'
														  style='opacity: " . $calendarValueArray[$n][$m] . "'
														></div>" . "</th>";
								$k2 = $k2+1;
							}
							//echo "($m,$n)<br>";


				}			
			echo "</tr>";
		}
		
		echo "</table>";
		
	}
	
	
}
			
$cal = new Calendar('2d91c27926e158e1e39d0aa07a21ac5a', $DBH, 90);
$cal->createCalendarArray();
			
			?>
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
