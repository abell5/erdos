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
