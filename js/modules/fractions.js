require(['jquery','problem_obj'], function($, prob) {
	
	var Problem = prob.getProblemObject();
	
	branches = {
		frac2dec: function () {
			var helperProblem = new Problem(2, 'Hmm.. remember that we divide the numerator by the denominator.  Which number is the numerator, 4 or 5?', 4, null, "longForm");
			var $helperTV = $( "#helperTV");
			helperProblem.displayMe($helperTV);
		}
	}
	
	var problem1 = new Problem(1
										,'Convert \\( \\frac{4}{5} \\) to a decimal.'
										,0.8
										,[ [1.2, "branches.frac2dec()" ] ]
										,"longForm"
									  );
	
	var $TV = $("#mainTV");
	problem1.displayMe($TV);
	
});

//var problem1 = new Problem(1,1,1,1,1);
/*
	function getInputValue(inputName) {
		
		var i = document.getElementsByName(inputName);
		
		if (i[0].tagName == "INPUT" && i[0].type == "text") {
			return i[0].value;
		} else {
			console.log("Non-input DOM element selected");
		}
	}

		var problem1 = new Problem(1
												,'Convert \\( \\frac{4}{5} \\) to a decimal.'
												,0.8
												,[ [1.2, "displayHelperPlaintext('Close!  But I think you are mixing up the numerator and denominatory.'); displayHelperProblem(problem1)" ] ]
												,"longForm"
											  );

	var mainTV = document.getElementById("mainTV");
	//Submit answer method
	$("body").on("click", ".button", function() {
		//Events that happen when div is clicked
		k = getInputValue("answer");
		problem1.checkAnswer(k);
	});
	
	displayProblem(problem1);	
		
*/