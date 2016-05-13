
<html>
	<head>

		
		<script type="text/javascript" async
		  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
		</script>
		<script src="js/config.js"></script>
		
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/magic-check.css">
		<link rel="stylesheet" href="css/master.css">
		
		
		<script data-main="js/main.js" src="js/lib/require.js"></script>
		<script>
		
			require(['js/main'], function() {
				require(['jquery', 'modules'], function($,mod) {
					console.log("begin");
					
					var Module = mod.getModuleObject();
					
					var Fractions = new Module("Fractions", [1,3,2]);
					Fractions.displayKeys();

					
				});
			});
		
		</script>
		<!--JQuery-->
		
		
	</head>



	<body>
	
<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div id="keys"></div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div id="mainTV">	
					<h1>Let's begin!</h1>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div id="helperTV">	
					<h1>Let's begin!</h1>
				</div>
			</div>
		</div>
</div>	
	
	</body>



</html>
