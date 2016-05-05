/*Will seperate into 2 files later, and implement RequireJS...*/
/*For now, begin the class object...*/
define(['jquery'], function($) {
	
	//The callback here is called once the problem is fully instantiated.
	var Problem = function (id,callback=null, text=null,answer=null,branches=null, type=null, child=null, parent=null, onCorrect=null,choiceSet=null) {
		this.id = id;
		this.text = text;
		this.answer = answer;
		
		this.choiceSet = choiceSet; //Going to place a number-of-choices-dimensional array with text and 
											   //action
		
		this.branches = branches; //Branches are stored as an array of 2 dimensional arrays... a pointer
											 //and an action. Ex. [ [pointer1,action1], [pointer2,action2] ... ]
		this.type = type;
		this.child = child;
		this.parent = parent;
		this.onCorrect = onCorrect;
		
		this.build(id, callback);
	};
	
	//get all info from the database

	//callback is used for when the question is built
	Problem.prototype.build = function(pid, callback=null) {
		var curr_prob = this;
		$.ajax({
			url: "build_problem.php",
			type: "get",
			data: {id: pid},
			success: function(response) {
				var data = $.parseJSON(response);
				console.log(data);
				
				curr_prob.id = data['problem']['id'];
				curr_prob.text = data['problem']['text'];
				curr_prob.answer=data['problem']['answer'];
				curr_prob.type=data['problem']['type'];
				
				if(callback !== null) { callback(curr_prob); }
			},
			error: function(xhr) {
				console.log("error");
			}
		});
	}
	
	Problem.prototype.checkAnswer = function(ans) {
		if(this.answer == ans) {
			this.onCorrect();
		} else {
			console.log("Incorrect");
			this.checkBranches(ans);
		}
	}

	Problem.prototype.checkBranches = function(val) {
		this.branches.forEach(function (entry) {
			if(entry[0] == val) {
				var action = new Function(entry[1]);
				console.log(action);
				action();
			}
		});
	}

	Problem.prototype.displayMe = function(loc) {
		//console.log("function : displayMe (", loc, ")");
		//Create the problem wrapper
		var $_problemWrapper = $("<div>", {class: "_problemWrapper", width: "500px"});
		$_problemWrapper.data("_problem", this );
	
		var $problemTextbox = $("<div>", {class: "problemTextbox" });
		$problemTextbox.append( this.text ).appendTo($_problemWrapper);
		
		var $answerBox = $("<div>", {class:"answerBox"});
		$answerBox.appendTo($_problemWrapper);
		
		//If statements
		if(this.type=="short_answer") {
			var $answerForm = $("<input/>", {type: 'text', name: 'answer'});
			($answerForm).appendTo($answerBox);
		}
		
		var $checkAnswerButton = $("<div>", {class: "button" });
		$checkAnswerButton.data("_form", $answerForm);
		$checkAnswerButton.append("Button").appendTo($_problemWrapper);	
		7
		$checkAnswerButton.bind ( "click", function () {	
			
			var problemObj = $(this).closest("._problemWrapper").data("_problem");
			var answer = $(this).data("_form").val();
			
			problemObj.checkAnswer(answer);			
		});
		
		//Final append statement
		$(loc).append( $_problemWrapper );
		MathJax.Hub.Queue(["Typeset",MathJax.Hub]); //update MathJax
	}
	
	
	function world() {
		console.log("world");
	}
	
	return {
		getProblemObject: function() { return Problem; },
		
		world: function() { world(); }
	};
});
//going to change these to "Problem.prototype.displayme"


/*
//Display a problem on the TV, default to the mainTV
function displayProblem(prob,loc=mainTV) {
	//short_answer problem display
	if(prob.type=="short_answer") {
		
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
*/

