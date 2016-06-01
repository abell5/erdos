/*Will seperate into 2 files later, and implement RequireJS...*/
/*For now, begin the class object...*/
define(['jquery'], function($) {
	
	//The callback here is called once the problem is fully instantiated.
	var Problem = function (id,callback=null, text=null,answer=null,branches=null, type=null, child=null, parent=null, onCorrect=null,choiceSet=null,module=null) {
		this.id = id;
		this.text = text;
		this.answer = answer;
		this.module = module;
		
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
				
				curr_prob.choiceSet = data['choices'];
				curr_prob.id = data['problem']['id'];
				curr_prob.text = data['problem']['text'];
				curr_prob.answer=data['problem']['answer'];
				curr_prob.type=data['problem']['type'];
				
				
				console.log(curr_prob.choiceSet);
				
				if(callback !== null) { callback(curr_prob); }
			},
			error: function(xhr) {
				console.log("error");
			}
		});
	}
	
	Problem.prototype.checkAnswer = function(ans,button=null) {
		choice = findChoiceByLetter(ans, this.choiceSet);
		
		$.ajax({
			type: 'POST',
			url: 'post_response_data.php',
			data: {
				pid: this.id,
				ptext: this.text,
				response: ans,
				response_text: choice['text']	
			},
			success: function() {
				console.log('Succesfully called');
			}
		});
		
		if(this.answer == ans) {
			if(choice['assist_text'] != "") {
				this.module.displayHelperText(0, choice['assist_text']);
				console.log(choice['pid']);
			}
			//$(".button").find("[data-_form='problem"+this.id+"']").css("border","3px solid #000");
			var $button = $(".button[name='problem"+this.id+"']")
			$button.removeClass("btn-primary");
			$button.addClass("btn-success");
			$button.html("Correct!");
			//$button.unbind("click");
			$button.css("cursor", "default");
			$button.attr('disabled', true);
			
		} else {
			var instructions = choice['action'];
			
			if(instructions=="descend") {
				if(choice['assist_text'] == null) {
					this.descend(choice['action_to']);
					return;
				}
				this.descend(choice['action_to'], choice['assist_text']);
			}
			if(instructions=="displayText") {
				this.module.displayHelperText(choice['pid'],choice['assist_text']);
			}
		}
	}
	
	findChoiceByLetter = function(ans, set) {
		for (i=0; i < set.length; i++) {
			if(set[i]['choice'] == ans) {
				return set[i];
			}
		}
		return false;
	}
	
	Problem.prototype.descend= function(id,text=null) {
		if(text === null) {
			this.module.displayHelper(id);
			return;
		}
		this.module.displayHelper(id,text);
	}

	
	/*
	Problem.prototype.checkBranches = function(val) {
		this.branches.forEach(function (entry) {
			if(entry[0] == val) {
				var action = new Function(entry[1]);
				console.log(action);
				action();
			}
		});
	}
	*/

	Problem.prototype.displayMe = function(loc) {
		var curr_prob = this;
		
		var $_problemWrapper = $("<div>", {class: "_problemWrapper"});
		$_problemWrapper.data("_problem", this );
		
		var $problemTextbox = $("<div>", {class: "problemTextbox" });
		$problemTextbox.append( this.text ).appendTo($_problemWrapper);
		
		var $choiceBox = $("<div>", {class: "choiceBox"});
		$choiceBox.appendTo($_problemWrapper);
		
		var $choiceForm = $("<form id='problem"+this.id+"'>");
		for (i=0; i < this.choiceSet.length; i++) {
				//$choiceBox.append(this.choiceSet[i]['choice']);
				
				
				$choiceForm.append("<div class='choice_buffer'><input class='magic-radio' type='radio' name='problem"+this.id+"' id='"+this.id+i+"' value='"+this.choiceSet[i]['choice']+"'><label for='"+this.id+i+"'>"+this.choiceSet[i]['text']+"</label></div>");
				//$choiceForm.append("<input type='radio' class='magic-radio' value='"+this.choiceSet[i]['choice']+"' name='problem"+this.id+"'> "+this.choiceSet[i]['text'] + "<br>");
		}
		$choiceForm.append("</form>");
		$choiceForm.appendTo($choiceBox);
		
		var $checkAnswerButton = $("<div>", {class: "button btn btn-primary", name: "problem"+this.id });
		$checkAnswerButton.data("_form", "problem"+this.id);
		$checkAnswerButton.append("Go").appendTo($_problemWrapper);	
		
		$checkAnswerButton.bind ( "click", function () {	
			
			//var answer = $('form[id="problem'+curr_prob.id+'"] > input:radio:checked').val();
			var answer = $("input[name='problem"+curr_prob.id+"']:checked").val();
			var problemObj = $(this).closest("._problemWrapper").data("_problem");
			problemObj.checkAnswer(answer);
			
		});
		
		//Final append statement
		$(loc).append( $_problemWrapper );
		MathJax.Hub.Queue(["Typeset",MathJax.Hub]); //update MathJax
		
		/*
		var $answerBox = $("<div>", {class:"answerBox"});
		$answerBox.appendTo($_problemWrapper);
		*/
		//If statements
		/*
		if(this.type=="short_answer") {
			var $answerForm = $("<input/>", {type: 'text', name: 'answer'});
			($answerForm).appendTo($answerBox);
		}
		*/
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

