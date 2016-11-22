<?php
require_once('include/db_connect.php');

$user = getUserID();
/*I will move these dashboard functions to their own file later*/

require_once('include/dashboardClass.php');

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
	
	<!-- d3js style -->
	<style>
	.bar {
		fill: #3498db;
	}
		.bar:hover {
			fill:#2980b9	;
		}
		
	.title {
	  font: bold 14px "Helvetica Neue", Helvetica, Arial, sans-serif;
	}

	.x-axis {
		font-size: 14px;
		font-family: 'Montserrat', sans-serif !important;
	}
		.x-axis path {
			display:none;
		}
		.x-axis .tick line {
			display: none;
		}

	.y-axis {
		font-size: 14px;
		font-family: 'Montserrat', sans-serif !important;
		text-align: right !important;
	}
	
	.y-axis .tick line {
		stroke: #777;
		stroke-dasharray: 2,2;
	}
		.y-axis path {
			display: none;
		}
	
	.y-axis path {
	}

	
	.axis path,
	.axis line {
	  fill: none;
	  stroke: #000;
	  shape-rendering: crispEdges;
	}

	.x.axis path {
	  display: none;
	}
	</style>
	
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
		console.log("dataArray", dataArray);
		
		/*
		var dataArray = [
								{"major_topic": "Problem Solving and Data Analysis", "percentage": 0.59},
								{"major_topic": "Problem Solving2", "percentage": 0.4},
								{"major_topic": "Problem Solving3", "percentage": 0.8}
								]
		*/
		dataArrayMax = function(dataArray) {
			var percs = [];
			dataArray.forEach(function(d) {
				percs.push(d.percentage)
			});
			return Math.max.apply(Math,percs);
		}
		
		function wrap(text, width) {
		  text.each(function() {
			var text = d3.select(this),
				words = text.text().split(/\s+/).reverse(),
				word,
				line = [],
				lineNumber = 0,
				lineHeight = 1.1, // ems
				y = text.attr("y"),
				dy = parseFloat(text.attr("dy")),
				tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
			while (word = words.pop()) {
			  line.push(word);
			  tspan.text(line.join(" "));
			  if (tspan.node().getComputedTextLength() > width) {
				line.pop();
				tspan.text(line.join(" "));
				line = [word];
				tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
			  }
			}
		  });
		}

		var margin = {top: 20, right: 20, bottom: 50, left: 50},
			  width = 600 - margin.left - margin.right,
			  height = 300 - margin.top - margin.bottom;
			  
		var x = d3.scaleBand()
							.rangeRound([0,width])
							.domain(dataArray.map(function(d) { return d.major_topic; }))
							.paddingInner(0.15)
							.paddingOuter(0.25);
		
		var y = d3.scaleLinear().domain([1,0])
											.range([0,height]);
		
		var xAxis = d3.axisBottom(x);
		
		var yAxis = d3.axisRight(y).ticks(5, "%")
											   .tickSize(width);
		
		var svg = d3.select("#chart").append("svg")
							.attr("width", width+margin.left+margin.right)
							.attr("height",height+margin.top+margin.bottom)
							.append("g")
								.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
		
		/*Title example
		svg.append("text")
		      .attr("class", "title")
			  .attr("x", x(dataArray[0].name))
			  .attr("y", -26)
			  .text("Why Are We Leaving Facebook?"); */
		  
		svg.append("g")
				.attr("class", "x-axis")
				.attr("transform", "translate(0," + height + ")")
				.call(xAxis)
					.selectAll(".tick text")
					.call(wrap, x.bandwidth())
					.attr("transform", "translate(18,0)");
		
		var gy = svg.append("g")
						.attr("class", "y-axis")
						.call(yAxis);

		gy.selectAll("text")
			.attr("x", 0)
			.attr("dy", -4);
						
		svg.selectAll(".bar")
			 .data(dataArray)
			 .enter().append("rect")
					.attr("class","bar")
					.attr("x", function(d) {return x(d.major_topic); })
					.attr("width", x.bandwidth())
					.attr("y", function(d) { return y(d.percentage); })
					.attr("height", function(d) {return height - y(d.percentage) })
					.attr("transform", "translate(18,0)"); //Inner margin
			
		//Progress tooltip	
			var p = $(".widget[name=progress]").offset();
			$(".tool-tip[name=progress]").css("left",p.left-188);
			$(".tool-tip[name=progress]").css("top",p.top+34);		
		
		
		
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

		/*
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
		*/
	
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
		<div class="widget-header"><h6>Mastery of Core Topics</h6></div>
		<div class="widget-body">	
			<div id="chart">
			  
			</div>
		</div>
		
		
		
	</div>
	
	<div class="tool-tip" name="progress">	
		<div class="tool-tip-left">
			Click to expand, and<br>
			see where you stand<br>
			on each SAT subtopic.
		</div>
		<div class="tool-tip-right">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		</div>
	</div>			

	<div class="widget" name="progress">
		<div class="widget-header"><h6>Detailed Breakdown of My Knowledge</h6></div>
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
