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
				require(['modules'], function(mod) {
					console.log("begin");
					
					var Module = mod.getModuleObject();
					
					var Fractions = new Module("Fractions", [1,2]);
					Fractions.displayKeys();
					
				});
			});
		
		</script>
		
	</head>



	<body>
		Version 0.2, designed for SAT prep
		<div id="keys"></div>
		<div id="mainTV">
			<div id="helperTV"></div>
		</div>

	</body>



</html>