<?php
require_once('include/db_connect.php');

global $user;
$user = getUserID();

/*I will move these dashboard functions to their own file later*/


class Profile
{
	protected $user;
	protected $DBH;
	protected $goal;
	protected $goalDays;
	
	public function __construct($user, $DBH) {
		$this->user = $user;
		$this->DBH = $DBH;
	}
	
	public function getGoal() {
		$query = "SELECT `goal`
					   FROM `users`
					   WHERE `userId`= :user
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
					   WHERE `userId`= :user
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

<!--Main page stylesheets-->
<link rel="stylesheet" href="css/profile.css">

<script language="Javascript">
$(document).ready(function(){ 
	
	$(".square").mouseover(function() {
			$(this).children(".arrow_box").show();
		}).mouseout(function() {
			$(this).children(".arrow_box").hide();
	});
	
	refreshDom = function() {
		$("#left-sidebar").height($(document).height());
	}
	
	$(".save-edits-btn").on("click", function(e) {
		var dataLink = escape($(this).attr("data-link")); //Used a general 'data-link' so I can generalize this statement, but its honestly not  a great solution becuase I hard code goal below haha.
		var editsPackage = new Object();
		
		
		$("input[data-link="+dataLink+"]").each(function(index) {
				editsPackage[$(this).attr("name")] = escape($(this).val());
		});
		
		console.log(editsPackage);

		$.ajax({
			type: 'POST',
			url: 'saveGoals.php',
			data: editsPackage,
			success: function (res) {
				var loggedin = $.parseJSON(res)
				console.log(loggedin);
				if(loggedin['status'] == false) {
					$(".app-notice-body").html("Great job seting your goals!  If you want to save these goals for the future, you'll need to <a href='register.php'>register an account here.</a>")
					$(".app-notice").show();
				}
			}
		});

	});

	//Calendar tooltip
	var c = $(".widget[name=calendar]").offset();
	$(".tool-tip[name=calendar]").css("left",c.left-155);
	$(".tool-tip[name=calendar]").css("top",c.top+80);	
	
	//$(".tool-tip[name=progress]").show();		
	
	var displayCookies = 
	<?php
		$toolTipList = ["progress","calendar"];
		$show = [];
		foreach($toolTipList as $tooltip) {
			if(!isset($_COOKIE["{$tooltip}"])) {
				array_push($show,$tooltip);				
			} elseif ($_COOKIE["{$tooltip}"] == 1) {
				array_push($show,$tooltip);	
			}
		}
		echo json_encode($show);
	?>;
	for(i=0; i<displayCookies.length;i++) {
		var temp = displayCookies[i];
		$(".tool-tip[name="+displayCookies[i]+"]").show();
	}
	
	refreshDom();
	
});

</script>

<?php
$profile = new Profile($user, $DBH);
?>
<div class="app-notice">
	<div class="app-notice-header-box">
		<div class="app-notice-header">
			<h6>Notice</h6>
		</div>
		<div class="app-notice-close-btn">
			<span style="" class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		</div>
	</div>
	<div class="app-notice-body">
	
	</div>	
</div>

	<div class="tool-tip" name="calendar">	
		<div class="tool-tip-left">
			Mouseover any<br>
			square to see your<br>
			work on that day.
		</div>
		<div class="tool-tip-right">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		</div>
	</div>	
	<div class="widget" name="calendar">
		<div class="widget-header"><h6>Problem Calendar</h6></div>
		<div class="widget-body" style="height: 170px">

		<?php
				
			class Calendar
			{
				protected $relativeTo;
				protected $dayTable;
				protected $user;
				protected $DBH;
				protected $n;
				protected $highestValue;
				protected $highestValueDay;
				
				public function __construct($user, $DBH, $n) {
					$this->user = $user;
					$this->DBH = $DBH;
					$this->n = $n;
				}
				
				public function getHighestValue() {
					return $this->highestValue;
				}
				
				public function getHighestValueDay() {
					return $this->highestValueDay;
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
					
					$unnormalizedCalendarValueArray = $calendarValueArray;
					
					$highTopLevel = [];
					foreach($calendarValueArray as $topLevel) {
						array_push($highTopLevel, max($topLevel));
					}
					$highestValue = max($highTopLevel);
					$highestValueDay;
					if($highestValue != 0) {
						//Normalize all values in the table.
						for($a=0; $a < sizeOf($calendarValueArray); $a++) {
							for($b=0; $b < 7; $b++) {
								if($calendarValueArray[$a][$b] == $highestValue) {
									$highestValueDay = $calendarArray[$a][$b];
								}
								$norm = ($calendarValueArray[$a][$b] - 0) / ($highestValue);
								$calendarValueArray[$a][$b] = $norm;
							}
						}
						
						$this->highestValue = $highestValue;
						$this->highestValueDay = $highestValueDay;
						
						echo "<div class='widget-body-left'>";
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
												echo "<th>" . "<div class='square'
																	  style='background-color: #ecf0f1 !important'
																	><div class='arrow_box'>" . $unnormalizedCalendarValueArray[$n][$m] . " problems answered on<br>" . $calendarArray[$n][$m] . "</div></div>" . "</th>";
												$k2 = $k2+1;
											} elseif($unnormalizedCalendarValueArray[$n][$m] == 1) {
												
												echo "<th>" . "<div class='square'
																		  style='background-color: rgba(39,174,96," . $calendarValueArray[$n][$m] . ")'
																		><div class='arrow_box'>" . $unnormalizedCalendarValueArray[$n][$m] . " problem answered on<br>" . $calendarArray[$n][$m] . "</div>" . "</th>";
												$k2 = $k2+1;
											} elseif($unnormalizedCalendarValueArray[$n][$m] > 0) {
												echo "<th>" . "<div class='square'
																		  style='background-color: rgba(39,174,96," . $calendarValueArray[$n][$m] . ")'
																		><div class='arrow_box'>" . $unnormalizedCalendarValueArray[$n][$m] . " problems answered on<br>" . $calendarArray[$n][$m] . "</div>" . "</th>";
												$k2 = $k2+1;
											} else {
												echo "<th>" . "<div class='square2'
																		  style='background-color: rgba(39,174,96," . $calendarValueArray[$n][$m] . ")'
																		></th>";
												$k2 = $k2+1;												
											}
											//echo "($m,$n)<br>";


								}			
							echo "</tr>";
						}
						
						echo "</table>";
						
						echo "</div>";
						
						echo "<div class='widget-body-right'>";
							echo "<div class='calendar-right-inset'>
										<div class='calendar-right-header'>
											Record Practice Day
										</div>
										<div class='calendar-right-body'>
											<div class='calendar-bold calendar-bold-number'>" . $this->getHighestValue() . "</div><br> problems on <br><div class='calendar-bold'>". $this->getHighestValueDay() ."</div>
										</div>
									</div>";
						
						echo "</div>";
					
					} else {
						echo "You haven't done any problems yet!  Start learning!";
					}
				}
				
			}
						
			$cal = new Calendar($user, $DBH, 90);
			$cal->createCalendarArray();
			
			?>
		


		</div>
	</div>
	
<div class="widget">
	<div class="widget-header"><h6>Goals</h6></div>
		<div class="widget-body">

			<div class="light-weight-font">
				<table>
					<tr>
						<th><h7>Target score:</h7>
						<input type="text" name='goal' data-link="goals" value="<?php echo $profile->getGoal(); ?>" maxlength="4" style="width: 65px; margin-left: 8px;"></th>
					</tr>
					<tr>
						<th><h7>I will practice</h7>
						<input type="text" class="center" data-link="goals" name='goalDays' value="<?php echo $profile->getGoalDays(); ?>" maxlength="1" style="width: 30px">
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
