/*Will seperate into 2 files later, and implement RequireJS...*/
/*For now, begin the class object...*/


var Problem = function (id,text,answer,branches, type, child=null, parent=null) {
	this.id = id;
	this.text = text;
	this.answer = answer;
	this.branches = branches; //Branches are stored as an array of 2 dimensional arrays... a pointer
										 //and an action. Ex. [ [pointer1,action1], [pointer2,action2] ... ]
	this.type = type;
	this.child = child;
	this.parent = parent;
	
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
			var action = new Function(entry[1]);
			action();
		}
	});
}


//Display a problem on the TV, default to the mainTV
function displayProblem(prob,loc=mainTV) {
	//longForm problem display
	if(prob.type=="longForm") {
		
		htmldata = '<div class="problemTextbox">' + prob.text + '</div>';
		htmldata += '<div class="answerBox"><input type="text" style="width: 60px"name="answer"></input></div>';
		htmldata += '<div class="button">Blah</div>';
		
		loc.innerHTML += htmldata;	

		//Make sure to fix dependency issues using RequireJS
		//MathJax.Hub.Queue(["Typeset",MathJax.Hub]); //update MathJax
	}
	
}
//display plaintext in the mainTV
function displayPlaintext(text,loc=mainTV) {
	htmldata = '<div class="plaintext">' + text + '</div>';
	
	loc.innerHTML += htmldata;
	MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
}


//Display a problem in the helperTV

function displayHelperProblem(prob) {
	loc = document.getElementById("helperTV");
	displayProblem(prob,loc); //
	MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
}

//Display plaintext in the helperTV
function displayHelperPlaintext(text) {
	loc = document.getElementById("helperTV");
	
	htmldata = '<div class="plaintext">' + text + '</div>';
	
	loc.innerHTML += htmldata;
	MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
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
	/*Test problem*/
	var problem1 = new Problem(1
											,'Convert \\( \\frac{4}{5} \\) to a decimal.'
											,0.8
											,[ [1.2, "displayHelperPlaintext('Close!  But I think you are mixing up the numerator and denominatory.'); displayHelperProblem(problem1)" ] ]
											,"longForm"
										  );
	/************/
	
jQuery(function($) {

	var mainTV = document.getElementById("mainTV");
	//Submit answer method
	$("body").on("click", ".button", function() {
		//Events that happen when div is clicked
		k = getInputValue("answer");
		problem1.checkAnswer(k);
	});
	
	displayProblem(problem1);	
	
});


