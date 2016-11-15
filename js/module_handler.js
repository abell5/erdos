jQuery(function ($) {
	
var Problem = function(id,callback, text,answer,branches,major_topic,subtopic,child, parent,onCorrect,choiceSet,module,image,difficulty) {
	if(typeof callback === "undefined"){callback=null;}
	if(typeof text=== "undefined"){text=null;}
	if(typeof answer=== "undefined"){answer=null;}
	if(typeof branches === "undefined"){branches=null;}
	if(typeof major_topic === "undefined"){major_topic=null;}
	if(typeof subtopic === "undefined"){subtopic=null;}
	if(typeof child=== "undefined"){child=null;}
	if(typeof parent === "undefined"){parent=null;}
	if(typeof onCorrect === "undefined"){onCorrect=null;}
	if(typeof choiceSet === "undefined"){choiceSet=null;}
	if(typeof module === "undefined"){module=null;}
	if(typeof image === "undefined"){image=null;}
	if(typeof difficulty === "undefined"){image=null;}
	
	this.difficulty = difficulty;
	this.id = id;
	this.text = text;
	this.answer = answer;
	this.module = module;
	this.image = image;
	
	this.choiceSet = choiceSet; //Going to place a number-of-choices-dimensional array with text and 
										   //action
	
	this.branches = branches; //Branches are stored as an array of 2 dimensional arrays... a pointer
										 //and an action. Ex. [ [pointer1,action1], [pointer2,action2] ... ]
	this.major_topic=major_topic;
	this.subtopic = subtopic;
	this.child = child;
	this.parent = parent;
	this.onCorrect = onCorrect;
	
	this.build(id, callback);
};

//get all info from the database

//callback is used for when the question is built
Problem.prototype.build = function(pid, callback) {
	if(typeof callback === "undefined"){this.callback=null;}
	var curr_prob = this;
	$.ajax({
		url: "build_problem.php",
		type: "get",
		data: {id: pid},
		success: function(response) {
			var data = $.parseJSON(response);
			//console.log(data);	
			
			curr_prob.choiceSet = data['choices'];
			curr_prob.id = data['problem']['id'];
			curr_prob.text = data['problem']['text'];
			curr_prob.answer=data['problem']['answer'];
			curr_prob.major_topic=data['problem']['major_topic'];
			curr_prob.subtopic=data['problem']['subtopic'];
			curr_prob.difficulty=data['problem']['difficulty'];
			curr_prob.image=data['problem']['image'];
			
			if(callback) { callback(curr_prob); }
		},
		error: function(xhr) {
			console.log("error");
		}
	});
}

postResponse = function(pid,ptext,response,response_text,module,major_topic,subtopic,correct_answer,displayedTree) {
	$.ajax({
		type: 'post',
		url: 'post_response_data.php',
		data: {
			pid: pid,
			ptext: ptext,
			response: response,
			response_text: response_text,
			module: module,
			major_topic: major_topic,
			subtopic: subtopic,
			correct_answer: correct_answer,
			displayedTree: displayedTree
		},
		success: function() {
			console.log('Succesfully called');
		}
	});	
}

postRecommendation = function(pid, major_topic, subtopic, displayed_tree,n) {
	$.ajax({
		type: 'post',
		url: 'post_recommendation_data.php',
		data: {
			pid: pid,
			major_topic: major_topic,
			subtopic: subtopic,
			displayed_tree: displayed_tree,
			n: n
		},
		success: function() {
				console.log("Succesfully caleld");
		}
	});
}

function scroll_to(div){
	setTimeout(function() {
		$('html, body').animate({
			scrollTop: $(div).offset().top
		},1000);
	}, 500);
}

function newNotice(text) {
	var $notice = $("<div>", {class: "app-notice"});	
	var $header = $("<div>", {class: "app-notice-header-box"});
		$header.html('<div class="app-notice-header"><h6>Notice</h6></div><div class="app-notice-close-btn"><span style="" class="glyphicon glyphicon-remove" aria-hidden="true"></span></div>');		
	var $body  = $("<div>", {class: "app-notice-body"});
		$body.html(text);
	
	$notice.append($header);
	$notice.append($body);
	
	return $notice;
}

function redirectToDashboard() {
	var text = "Awesome job finishing another module!<br><br>We have updated your progress in <a href='app.php?p=dashboard'>your dashboard</a>.";
	$notice = newNotice(text);
	$(".Notice").append($notice);
	$notice.show();
}

Problem.prototype.checkAnswer = function(ans) {
	var choice = findChoiceByLetter(ans, this.choiceSet);
	var instructions = choice['action'];
	var assist_text = choice['assist_text'];
	if(this.module.noData==false) {
		postResponse(this.id,this.text,ans,choice['text'],this.module.name,this.major_topic,this.subtopic,this.answer,this.module.displayedTree);
	}
	if(this.answer==ans) { //if the answer is correct, disble the button and display correct
		disableButtonOnCorrect(this.id, ans);
		if(this.id == this.module.key_ids[this.module.key_ids.length-1]) {
			//console.log("last question");
			redirectToDashboard();	
		}
	}
	if(assist_text != "") {
		this.module.displayHelperText(this.id, assist_text);
	}
	if(instructions == "correct_step" || instructions == "descend") {
		//console.log("descending");
		//console.log(choice['action_to']);
		this.descend(choice['action_to']);
	}
	if(instructions == "recommend") {
		console.log("here");
		var n = 1;
		if(this.difficulty=="medium") {
			n = 2;
		} else if (this.difficulty=="easy") {
			n = 3;
		}
		postRecommendation(this.id, this.major_topic, this.subtopic,this.module.displayedTree, n);
	}
	
/*
	if(this.answer == ans) {
		if(choice['assist_text'] != "") {
			this.module.displayHelperText(id, choice['assist_text']);
			console.log(choice['pid']);
		}
		if(instructions=="correct_step") }
		
		disableButtonOnCorrect(this.id);	
	} else {
		
		
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
*/
}

disableButtonOnCorrect = function(id, ans) {
		var $form = $(".magic-radio[name=problem"+id+"][value="+ans+"]").parent(".choice_buffer");
		$form.css("background-color", "#B1EAC2");
		$form.children("label").append('<span class="glyphicon glyphicon-ok" aria-hidden="true" style="margin-left: 10px"></span>');
		/*
		var $button = $(".button[name='problem"+id+"']")
		$button.removeClass("btn-primary");
		$button.addClass("btn-success");
		$button.html("Correct!");
		$button.css("cursor", "default");
		$button.attr('disabled', true);
		*/
}

findChoiceByLetter = function(ans, set) {
	for (i=0; i < set.length; i++) {
		if(set[i]['choice'] == ans) {
			return set[i];
		}
	}
	return false;
}

Problem.prototype.descend= function(id,text) {
	if(typeof text=== "undefined"){text=null;}
	if(text === null) {
		this.module.displayHelper(id);
		return;
	}
	this.module.displayHelper(id,text);
}

Problem.prototype.displayMe = function(loc) {
	var curr_prob = this;
	
	var $_problemWrapper = $("<div>", {class: "_problemWrapper"});
	$_problemWrapper.data("_problem", this );
	
	if(curr_prob.image!="") {
		var image = new Image();
		image.src = 'data:image/png;base64,'+curr_prob.image;
		$_imageBox = $("<div>", {class: "imageBox" })
		$_imageBox.append(image).appendTo($_problemWrapper);
	}
	
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
	
	var $checkAnswerButton = $("<div>", {class: "go-btn", name: "problem"+this.id });
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
	if(loc=="#helperTV") { scroll_to($_problemWrapper); }
	
}


getProblemObejct = function() {
	return Problem;
}

var Module = function(name,key_ids,noData) {
	this.name=name;
	this.key_ids=key_ids; //key_ids should be an array
	this.problems = [];
	this.displayedTree = [];  //the tree of displayed problems... note that 2 main problems can never be displayed anyway.
	this.noData = noData;
	this.displayedHelperTextStrings = []; //ids to prevent lots of helper text.
	
	//Make a function that grabs all the problems by ids, and push them into an array of objects
	//which is stored as a variable as part of the object
}

//Would be a great idea to write out the async sequence
/*  Async sequence

1.  getProblem searches through its array of loaded problems (var problems)
2.  getProblem has a callback (CB1).  CB1 is the action that will be done when the problem is done being getted (lol).
3.  new Problem takes a callback (CB2).  CB2 is called by CB3, when new Problem is fully instantiated.  This operates at ALMOST the exact same level as CB1 (there are no async issues here), but its nice because it allows the problem to be stored.
[FUTURE WORK MAY BE COMBINING CB1 and CB2.  BUT FOR NOW THIS ALL WORKS].
4.  There is a callback hidden in the problem building class (CB3).  All this does is wait for the sql to finish before calling CB2.

So in order:
1.  getProblem fires holding CB1 (the getted callback)
2.  (assuming no problem) new Problem fires holding CB2 (the deposited)
3.  build fires holding CB3 (the waiting callback)
4.  Sql occurs, causing a hold.
5.  CB3 fires causing CB2 to fires
6.  CB2 fires depositing the problem into the bank, and calls CB1
7.  CB1 fires and we are all gooooood.
*/

Module.prototype.getProblem = function(id, callback) {
	var out; //shortened from out_problem ; but this is the problem object created in the if 
				//statement below

	this.problems.forEach(function(entry) {
		if (entry['id']==id) {
			out = entry;
			callback(out);
			return;
		}
	});
	
	if(out==null) {
		var mod = this;
		new Problem(id, function(p) {
			p.module = mod;
			//console.log("this line", p.module.name);
			mod.problems.push(p);
			out = mod.problems[mod.problems.length-1];
			callback(out);
			return;
		});
	}
}

Module.prototype.displayHelper = function(id,text) {
	if(typeof text === "undefined"){text=null;}
	var mod = this;

	for (i=0; i<mod.displayedTree.length; i++) {
		if(mod.displayedTree[i] == id) {
			console.log("already displayed");
			return false
		}
	}
	
	mod.getProblem( id, function(p)  {
		$("#helperTV").show();
		if(text!=null) {
			$("#helperTV").append(text);
		}
		p.displayMe( $("#helperTV") );
		mod.displayedTree.push(id);
	});
	
}

Module.prototype.displayHelperText = function(id, text) {
	if(text == null) { //if text isn't set, return false because there is nothing to display
		return false;
	}
	
	var mod =this; //avoid pointer confusion
	for (i=0; i<mod.displayedHelperTextStrings.length; i++) { //check if the text string is already displayed, return false if it is
		if(mod.displayedHelperTextStrings[i] == text) {
			console.log("already displayed");
			return false
		}
	}

	//The following code physically displays the text
	var $textDiv = $("<div>", {class: "helperText"});
	$textDiv.append(text);
	$("#helperTV").show();
	$("#helperTV").append($textDiv);
	mod.displayedHelperTextStrings.push(text);
	MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
	scroll_to($textDiv);
}

Module.prototype.displayKeys = function() {
	var mod = this;
	var count = 0;
	var lastKey = this.key_ids.length;
	
	this.key_ids.forEach(function (entry) {

		count = count+1;
		var $slide = $("<div>", {class: "slide_button key-button key-font"});
		//var $slide = $("<div>", {class: "btn btn-default"});
		$slide.append(count)
		$slide.data("_problem", entry)
		$slide.data("currentProblem", false);
		
		$slide.bind("click", function() {
			if($slide.data("currentProblem") == false) {
				$(".slide_button").data("currentProblem", false); //turn on all other slide keys
				$(".slide_button").removeClass("pressed");
				$slide.data("currentProblem", true); // make this slide the current problem
				$slide.addClass("pressed");
				
				
				$("#helperTV").html(""); //clear helperTV
				$("#helperTV").hide();
				mod.displayedTree = [];
				mod.displayedHelperTextStrings = [];
				
				$("#mainTV").html(""); //clear the mainTV					
				
				mod.getProblem( $slide.data("_problem"), function(p) {
					console.log("pushing id", p.id);
					mod.displayedTree.push(p.id);
					p.displayMe( $("#mainTV") );					
				});
			}
		});
		$("#keys").addClass("btn-group");
		$("#keys").attr("role", "group");
		
		//if(count==lastKey) { $slide.addClass("no-border") }
		$("#keys").append($slide);
	});
	
}

getModuleObject = function() {
	return Module;
}

});