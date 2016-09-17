<?php
require_once('include/db_connect.php');

global $user;
$user = getUserID();
/*I will move these dashboard functions to their own file later*/

/*****NOTE:  In the response_data table, the user ID is stored in `user_id`, but in the `users` table it is stored in userId.  This could be a problem in the future, and definitely not clean code.*/
class Dashboard
{
	protected $user;
	protected $DBH;
	protected $major_topics;
	protected $subtopics;
	protected $goal;
	protected $goalDays;
	
	public function __construct($user, $DBH) {
		$this->user = $user;
		$this->DBH = $DBH;
	}
	
	/*
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
	*/

	public function getCorrectByMajorTopic($topic) {
		$query = "SELECT *
						FROM `response_data`
						WHERE `user_id` = :user AND `major_topic` = :major_topic AND `response` = `correct_answer`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":major_topic"=>$topic))) {
				$rows = $stmt->fetchAll();
				var_dump($rows);
		}
	}

	public function getCorrectBySubopic($topic) {
		$query = "SELECT *
						FROM `response_data`
						WHERE `user_id` = :user AND `subtopic` = :subtopic AND `response` = `correct_answer`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":subtopic"=>$topic))) {
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
	
	public function getNumberByMajorTopic($topic) {
		$query = "SELECT count(`id`) as Num
						FROM `response_data`
						WHERE `user_id` = :user AND `major_topic` = :major_topic
						GROUP BY `major_topic`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":major_topic"=>$topic))) {
				$rows = $stmt->fetch();
				if(empty($rows)) {
					return 0;
				} else {
					return $rows['Num'];
				}
		}		
	}
	
	public function getNumberBySubtopic($topic) {
		$query = "SELECT count(`id`) as Num
						FROM `response_data`
						WHERE `user_id` = :user AND `subtopic` = :subtopic
						GROUP BY `subtopic`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":subtopic"=>$topic))) {
				$rows = $stmt->fetch();
				if(empty($rows)) {
					return 0;
				} else {
					return $rows['Num'];
				}
		}		
	}
	
	public function getNumberCorrectByMajorTopic($topic) {
		$query = "SELECT count(`id`) as Num
						FROM `response_data`
						WHERE `user_id` = :user AND `major_topic` = :major_topic AND `response` = `correct_answer`
						GROUP BY `major_topic`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":major_topic"=>$topic))) {
				$rows = $stmt->fetch();
				if(empty($rows)) {
					return 0;
				} else {
					return $rows['Num'];
				}
		}				
	}

	public function getNumberCorrectBySubtopic($topic) {
		$query = "SELECT count(`id`) as Num
						FROM `response_data`
						WHERE `user_id` = :user AND `subtopic` = :subtopic AND `response` = `correct_answer`
						GROUP BY `subtopic`";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array(":user"=>$this->user, ":subtopic"=>$topic))) {
				$rows = $stmt->fetch();
				if(empty($rows)) {
					return 0;
				} else {
					return $rows['Num'];
				}
		}				
	}
	
	public function getPercentageByMajorTopic($topic) {
			$denominator = $this->getNumberByMajorTopic($topic);
			$numerator = $this->getNumberCorrectByMajorTopic($topic);
			
			if($denominator!=0) {
				$percentage = $numerator/$denominator;
			} else {
				return -1;
			}
			return $percentage;	
	}

	public function getPercentageBySubtopic($topic) {
			$denominator = $this->getNumberBySubtopic($topic);
			$numerator = 1; $this->getNumberCorrectBySubtopic($topic);
			
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
	
	public function getListOfMajorTopics() {
		$query = "SELECT DISTINCT `major_topic`
						FROM `sat_problems`
						WHERE `major_topic` != ''";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute()) {
			$rows=$stmt->fetchAll(PDO::FETCH_COLUMN);
			return $rows;
		}			
	}

	public function getListOfSubtopics() {
		$query = "SELECT DISTINCT `subtopic`
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
	
	public function getSubtopicsByMajorTopic($topic) {
		$query = "SELECT distinct `subtopic`
						FROM `sat_problems`
						WHERE `major_topic`= :major_topic";
		$stmt = $this->DBH->prepare($query);
		if($stmt->execute(array("major_topic"=>$topic))) {
			$rows=$stmt->fetchAll(PDO::FETCH_COLUMN);
			return $rows;
		}	
	}
	
	public function getTopicStructure() {
		$topicStructure = (object) null;
		
		
		$majorTopics = $this->getListOfMajorTopics();
		//var_dump($majorTopics);
		foreach($majorTopics as $major) {
			$temp = (array)$topicStructure;
			$temp[$major] = $this->getSubtopicsByMajorTopic($major);
			$topicStructure = (object)$temp;
		}
		
		//var_dump($topicStructure);	
		return $topicStructure;
		
	}

	
}

//$dashboard = new Dashboard($user, $DBH);
//var_dump($dashboard->getListOfDiffs());
?>
<!-- d3js -->
<script src="https://d3js.org/d3.v4.min.js"></script>

<!--Google Font-->
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,900' rel='stylesheet' type='text/css'>

<!--Main page stylesheets-->
<link rel="stylesheet" href="css/profile.css">

	<?php
			
		$dashboard = new Dashboard($user, $DBH);
		$listOfMajorTopics = $dashboard->getListOfMajorTopics();
		$topicStructure = $dashboard->getTopicStructure();
		
	?>

	<script language="Javascript">
	$(document).ready(function(){ 
			
		$(".expand-button").click(function() {
			var expand_id = escape($(this).attr("name"));
			$(".widget-subtopic-container[name="+expand_id+"]").slideToggle("fast", function() {
					refreshDom();
			});
		});
		
		/*D3js widget*/
		
		var dataArray = <?php
								$percentageData = array();
								
								foreach($listOfMajorTopics as $major) {
									$temp = (object) array("major_topic" => $major, "percentage" => $dashboard->getPercentageByMajorTopic($major));
									array_push($percentageData, $temp);
									
									//array_push($percentageData, $dashboard->getPercentageByMajorTopic($major));
								}
								echo json_encode($percentageData, JSON_PRETTY_PRINT);
								
								//var_dump($percentageData);
								?>;
		//console.log("hello");
		console.log(dataArray);
		getData = function(dataArray) {						
			for(var propName in dataArray) {
				if(dataArray.hasOwnProperty(propName)) {
					return dataArray[propName];
					// do something with each element here
				}
			}
		}

		var width = ($("#chart").width() - 20); 
		//console.log(width);
		//console.log(Math.max.apply(Math,dataArray));
		var height = 200;
		
		dataArrayMax = function(dataArray) {
			var percs = [];
			dataArray.forEach(function(d) {
				percs.push(d.percentage)
			});
			return Math.max.apply(Math,percs);
		}
		
		var widthScale = d3.scaleLinear()
									.domain([0, dataArrayMax(dataArray)])
									.range([0,width]);
		
		//var Xaxis = d3.axisLeft(widthScale);
		var Xaxis = d3.axisBottom(widthScale)
							  .ticks(5);
		var Yaxis = d3.axisLeft( d3.scaleLinear().range([0,width]) )
							  .ticks(5);
							  
		var canvas = d3.select("#chart")
								.append("svg")
								.attr("width", width)
								.attr("height", height)
								.append("g")
								.attr("transform", "translate(30,30)");				
		
		console.log(dataArray);
		
		var bars = canvas.selectAll("rect")
							.data(dataArray)
							.enter()
							.append("rect")
							.append("text");
		
		var rectAttributes = bars
									  .attr("width", function(d) {
												return widthScale( d.percentage );
											})
										.attr("height", 50)
										.attr("fill", "green")
										.attr("y", function(d,i) {
											return i * 60; //The number here should be height + desired gap distance
										});
		var textAttributes = text
									  .attr("fill", "white")
									  .attr("y", function(d,i) {return i * 60; })
									  .text( function (d) { return d.name; });
									  
		
		
		canvas.append("g")
			.attr("transform","translate(0,150)")
			.call(Xaxis);
		
		canvas.append("g")
			.call(Yaxis)
			
		refreshDom();
	
	
	});
	

					
	</script>



	<!--
	<div class="widget">
		<div class="widget-header"><h6>Progress</h6></div>
		<div class="widget-body">
		</div>
	</div>
	-->
	
	<div class="widget">
		<div class="widget-header"><h6>D3js Test</h6></div>
		<div class="widget-body">	
			<div id="chart">
			  
			</div>
		</div>
		
		
		
	</div>
	
	<div class="widget">
		<div class="widget-header"><h6>Progress</h6></div>
		<div class="widget-body">
		
		<?php
		
		foreach($topicStructure as $main => $sub) {
			echo "<div class='widget-main-item'>
						<div class='expand-button' name='".str_replace(' ', '', $main)."'>+</div>".$main."
					</div>";
			echo "<div class='widget-subtopic-container' name='".str_replace(' ', '', $main)."'>";
				for($i = 0; $i < sizeof($sub); $i++) {
					$perc = $dashboard->getPercentageBySubtopic($sub[$i]);
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
					if($highestValue != 0) {
						//Normalize all values in the table.
						for($a=0; $a < sizeOf($calendarValueArray); $a++) {
							for($b=0; $b < 7; $b++) {
								$norm = ($calendarValueArray[$a][$b] - 0) / ($highestValue);
								$calendarValueArray[$a][$b] = $norm;
							}
						}		
					
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
					
					} else {
						echo "You haven't done any problems yet!  Start learning!";
					}
				}
				
			}
						
			$cal = new Calendar($user, $DBH, 90);
			$cal->createCalendarArray();
			
			?>
		</div>
<?php
		/*
		$mainTopics = ["Basic Algebra", "Advanced Algebra", "Problem Solving and Data Analysis", "Additional Topics in Math"];
		$algebraSubtopics = ["Solving linear equations",
										 "Interpreting linear functions",
										 "Linear inequality and equation word problems",
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
		*/
?>	
