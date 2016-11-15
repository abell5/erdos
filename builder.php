<?php
require_once('include/db_connect.php');

$query = "SELECT `AUTO_INCREMENT`
				FROM  INFORMATION_SCHEMA.TABLES
				WHERE TABLE_NAME   = 'sat_problems'
				;";
				
$stmt = $DBH->prepare($query);
$rows;
if($stmt->execute()) {
	$rows = $stmt->fetch();
}

if(isset($_POST['id'])) {
	echo "here";
}


?>

<style>

table {
	text-align: left;
	vertical-align: top;
}

.submit-btn {
	margin-top: 15px;
	display: block;
	height: 28px;
	width: 100px;
	text-align: center;
	background-color: #2c3e50;
	padding-top: 6px;
	border-radius: 3px;
	text-transform: uppercase;
	font-family: Optima, Segoe, "Segoe UI", Candara, Calibri, Arial, sans-serif;
	font-size: 16px;
	font-weight: 300;
	color: #fff;
}
	.submit-btn:hover {
		cursor: pointer;
	}

	.answer_wrapper {
		
		/*
		border: 1px solid #000;
		*/
	}
	

input[type=text], input[type=password], select {
    width: 100%;
    padding: 5px;
	height: 35px;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
	font-family: 'Montserrat', sans-serif !important;
	font-size: 14px;
}
	.input-margin {
		margin-bottom: 10px;
	}
	
</style>

<script src="js/jquery.js"></script>
<script type="text/javascript">


/*
Idea:
	The whole thing should be done using ajax, not php forms.
	When you click submit it should load ajax and on success just clear everything.
	Going to be the easiest way to do everything.
	
	If you do it that way, then you can do a "for each" element
		then for each "sat_answer" group, have its own ajax go
	So total, for a complete original question, there should be 6 calls.  1 for main and 5 for resposne"

*/
	$(document).ready(function() {
		console.log("here");
		$(".submit-btn").on("click", function(e) {
			$(this).hide();
			
			var pid;
			var problem_text;
			var problem_answer;
			var problem_subtopic;
			var problem_major_topic;
			var problem_difficulty;
			
			pid = $("input[name='pid']").val();
			
			problem_text = $(".problem_wrapper").find("textarea[name='text']").val();
			problem_answer = $(".problem_wrapper").find("select[name='answer']").val();
			problem_subtopic = $(".problem_wrapper").find("input[name='subtopic']").val();
			problem_major_topic = $(".problem_wrapper").find("select[name='major_topic']").val();
			problem_difficulty = $(".problem_wrapper").find("select[name='difficulty']").val();
			
			$.ajax({
				type: 'post',
				url: 'post_builder_problem.php',
				data: {
						id: pid,
						text: problem_text,
						answer: problem_answer,
						subtopic: problem_subtopic,
						major_topic: problem_major_topic,
						difficulty: problem_difficulty
						},
				success: function() {
					console.log("Red 1:  Success");
				}				
			})
			
			$(".answer_wrapper").each( function() {
				var $this = $(this);
				
				var text = $this.find("input[name='text']").val();
				if(text) {
					var choice;
					var action;
					var action_to;
					var assist_text;
					
					choice = $this.find("input[name='choice']").val();
					action = $this.find("select[name='action']").val();
					action_to = $this.find("input[name='action_to']").val();
					assist_text = $this.find("textarea[name='assist_text']").val();
					console.log(assist_text);
				
					$.ajax({
						type: 'post',
						url: 'post_builder_answers.php',
						data: {
								pid: pid,
								text: text,
								choice: choice,
								action: action,
								action_to: action_to,
								assist_text: assist_text						
								},
						success: function() {
							console.log("Success echo 1");
						}	
					});
				
				
				}
				
			});
			
			setTimeout(function() { location.reload(); }, 2000);
		
		});
	
	});
</script>


<html>

Hello

<form method="POST" action="builder.php">

		<div class="problem_wrapper">
			<table>
				<tr>
					<th><input type="text" name='pid' value='<?php echo $rows["AUTO_INCREMENT"]; ?>' style="width: 40px"/></th>
				</tr>
				<tr>
					<th><textarea rows="8" cols="60" name="text" placeholder="text"></textarea></th>
				</tr>
				<tr>
					<th><select name="major_topic">
								<option value="Problem Solving and Data Analysis">Problem Solving and Data Analysis</option>
								<option value="General Skills">General Skills</option>
								<option value="Advanced Algebra">Advanced Algebra</option>
								<option value="Heart of Algebra">Heart of Algebra</option>
								<option value="Additional Topics in Mathematics">Additional Topics in Mathematics</option>
							</select></th>
					<th><input type="text" name="subtopic" style="width: 100px" placeholder="subtopic"></th>
					<th><select name="difficulty">
								<option value="easy">Easy</option>
								<option value="medium">Medium</option>
								<option value="hard">Hard</option>
							</select></th>
				</tr>
				<tr>
					<th><select name="answer" style="width: 40px">
								<option value="a">a</option>
								<option value="b">b</option>
								<option value="c">c</option>
								<option value="d">d</option>
								<option value="e">e</option>
							</select></th>
				</tr>
			</table>
		</div>
		
		
		<?php
		
		function numToChoice($num) {
			$result;
			switch($num) {
				case 0: 
					$result = "a";
					break;
				case 1:
					$result = "b";
					break;
				case 2:
					$result = "c";
					break;
				case 3:
					$result = "d";
					break;
				case 4:
					$result = "e";
					break;
			}
			return $result;
		}
		
		for($i=0; $i<5; $i++) {
		echo '
				<div class="answer_wrapper">
					<table>
					<tr>
							<th><input type="text" name="choice" style="width: 30px" value="';
							echo numToChoice($i); 							
							echo '"/></th>
							<th><input type="text" name="text" placeholder="text"></th>
							<th><select name="action">
										<option value="displayText">displayText</option>
										<option value="descend">descend</option>
										<option value="recommend">recommend</option>
										<option value="correct_step">correct_step</option>
										<option value="correct">correct</option>
									</select></th>
							<th><input type="text" name="action_to" style="width: 40px" placeholder="to"></th>
							<th><textarea rows="8" cols="60" name="assist_text" placeholder="assist_text"></textarea></th>
					</tr>
					</table>			
				</div>
				';
		}
		?>
	
	
	<div class="submit-btn">Submit</div>
	
	
</form>

</html>


</html>