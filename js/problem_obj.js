/*Will seperate into 2 files later, and implement RequireJS...*/
/*For now, begin the class object...*/

var Problem = function (text,answer,branches) {
	this.text = text;
	this.answer = answer;
	this.branches = branches; //Branches are stored as an array of 2 dimensional arrays... a trigger
										 //and an action/pointer.  [ [1,2], [3,4] ... ]
	
	console.log('Problem class instantiated');
};

Problem.prototype.checkAnswer = function(ans) {
	if(this.answer == ans) {
		console.log("correct");
	} else {
		console.log("Incorrect");
		this.checkBranches(ans);
	}
}

Problem.prototype.checkBranches = function(val) {
	this.branches.forEach(function (entry) {
		if(entry[0] == val) {
			console.log(entry[1]);
		}
	});
}



/*Begin the engine code...*/
/*Engine methods*/
function getInputValue(inputName) {
	
	var i = document.getElementsByName(inputName);
	
	if (i[0].tagName == "INPUT" && i[0].type == "text") {
		return i[0].value;
	} else {
		console.log("Non-input DOM element selected");
	}
}

/*Main document code*/
jQuery(function($) {
	
	//Submit answer method
	$("body").on("click", "#button", function() {
		//Events that happen when div is clicked
		k = getInputValue("answer");
		problem1.checkAnswer(k);
	});
	
	
	
	var problem1 = new Problem('Convert \\( \\frac{4}{5} \\) to a decimal.'
												,0.8
												,[ [1.2,"wrong way" ] ]
												);
	
	$('#problemTextbox').text(problem1.text); //Still unsure on whether to use .text() or .html()
	
	
});


