<?php
//Convert \( \frac{4}{5} \) to a decimal.


?>

<html>
	<head>
		<script type="text/javascript" async
		  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
		</script>
		<script src="js/config.js"></script>
		<script data-main="js/main.js" src="js/lib/require.js"></script>
		<script>
		
			require(['js/main'], function() {
				require(['problem_obj'], function(prob) {
						//console.log(prob);
						
						var Problem = prob.getProblemObject();
						
						prob.world();
						
						var problem1 = new Problem(1
												,'Convert \\( \\frac{4}{5} \\) to a decimal.'
												,0.8
												,[ [1.2, "displayHelperPlaintext('Close!  But I think you are mixing up the numerator and denominatory.'); displayHelperProblem(problem1)" ] ]
												,"longForm"
											  );
											  
					
						});
					
			
			});
		
		</script>
		
	</head>



	<body>

		<div id="mainTV">
			<div id="helperTV"></div>
		</div>

	</body>



</html>