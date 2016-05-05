require(['jquery','problem_obj'], function($, prob) {
	
	var Problem = prob.getProblemObject();
	
	branches = {
		frac2dec: function () {
			var helperProblem = new Problem(2, 'Hmm.. remember that we divide the numerator by the denominator.  Which number is the numerator, 4 or 5?', 4, null, "short_answer");
			var $helperTV = $( "#helperTV");
			helperProblem.displayMe($helperTV);
		}
	}
	
	var problem1 = new Problem(1
										,'Convert \\( \\frac{4}{5} \\) to a decimal.'
										,0.8
										,[ [1.2, "branches.frac2dec()" ] ]
										,"short_answer"
									  );
	
	var $TV = $("#mainTV");
	problem1.displayMe($TV);
	
});