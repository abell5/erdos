<?php
require_once('include/db_connect.php');
require_once('include/dashboardClass.php');


global $user;
$user = getUserID();

function getRecs($userId,$DBH) {
		$query = "SELECT `subtopic`, sum(`value`) as `Sum_of_value`
						FROM `recommendations`
						WHERE `userId` = :user
						GROUP BY `subtopic`";
		$stmt = $DBH->prepare($query);
		if($stmt->execute(array(":user"=>$userId))) {
				$rows = $stmt->fetchAll();
				return $rows;
		}
	
}	
//Niave algorithm:  (1/(recommendations + 1)) + perc	
function createRecVector($subtopicScores, $recScores) {	
	$decisionVector =  array();
	//for($i = 0; $i < sizeOf($subtopicScores); $i++) {
	foreach($subtopicScores as $sub) {
		$numRecs = 0;
		$perc = 1;
		if(isset($recScores[$sub->subtopic])) {
			$numRecs = $recScores[$sub->subtopic]['Sum_of_value'];
		}
		if($sub->percentage != -1) {
			$perc = $sub->percentage;
		}
		$score = (1/($numRecs + 1)) + $perc;
		//echo $sub->subtopic . ": " . $score . " (raw perc: " . $sub->percentage . ")<br>";
		if($score != 2) {
			$temp = (object) array("subtopic" => $sub->subtopic, "score" => $score);
			array_push($decisionVector, $temp);	
		}
	}
	return $decisionVector;
}

function scoreCmp($a, $b)
{
	$as = $a->score;
	$bs = $b->score;
	if ($as == $bs) {
		return 0;
	}
	return ($as > $bs) ? +1 : -1;
}

//This function returns the 5 lowest items on the scoreboard
function listOfRecs($decisionVector, $n) {
		$sorted = usort($decisionVector, "scoreCmp");
		return array_slice($decisionVector, 0, $n);
}

//To do:  pull the videos and display their links for the videos above


$dashboard = new Dashboard($user,$DBH);
$percs = $dashboard->getSubtopicPercentages();
$recs = getRecs($user,$DBH);
//var_dump($recs);
//var_dump($percs[2]->percentage);
$test = createRecVector($percs,$recs);
//var_dump($test);

//var_dump(listOfRecs($test,5));

class Scoreboard
{
	
	
}

	
?>

<!-- d3js -->
<script src="https://d3js.org/d3.v4.min.js"></script>

<!--Google Font-->
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,900' rel='stylesheet' type='text/css'>

<!--Main page stylesheets-->
<link rel="stylesheet" href="css/lessons.css">

	<?php
			
		//$dashboard = new Dashboard($user, $DBH);
		
	?>
	
	
	<div class="widget">
		<div class="widget-header"><h6>Videos recommended for you</h6></div>
		<div class="widget-body">	
				<div class="test">
				
				<table><tr>
				<?php
				
				$finalRecs = listOfRecs($test,10);
				
				if(!empty($finalRecs)) {
					foreach($finalRecs as $rec) {
						$query = "SELECT *
										FROM `videos`
										WHERE `subtopic` = :subtopic";
						$stmt = $DBH->prepare($query);
						if($stmt->execute(array(":subtopic"=>$rec->subtopic))) {
							$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
							if(!empty($rows)) {
								displayVideos($rows);
								//var_dump($rows);
							} 
						}
						
					}
				} else {
					echo "You haven't done any problems yet!  Start learning!";
				}
				
				function displayVideos($rows) {
					foreach($rows as $r) {
						if($r["origin"] == "youtube") {
							echo '<th>
							<a href="http://www.youtube.com/watch?v='. $r["video_code"] . '" target="_blank">
								<div class="img-box">
								
									<img src="http://img.youtube.com/vi/' . $r["video_code"] . '/0.jpg"/>
									<div class="img-box-caption">
										' . strtoupper($r["subtopic"]) . '
									</div>
								</div>
							</a>
							</th>';
						}
					}
				}
				
				
				?>
				</tr></table>
				
			  
			</div>		
		
	</div>

