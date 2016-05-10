 define(['jquery','problem_obj'], function($,prob) {
	
	var Problem = prob.getProblemObject();
	
	var Module = function(name,key_ids) {
		this.name=name;
		this.key_ids=key_ids; //key_ids should be an array
		this.problems = [];
		this.displayedTree = [];  //the tree of displayed problems... note that 2 main problems can never be displayed anyway.
		this.displayedHelperTextFrom = []; //ids to prevent lots of helper text.
		
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
	
	Module.prototype.displayHelper = function(id,text=null) {
		var mod = this;

		for (i=0; i<mod.displayedTree.length; i++) {
			if(mod.displayedTree[i] == id) {
				console.log("already displayed");
				return false
			}
		}
		
		mod.getProblem( id, function(p)  {
			if(text!=null) {
				$("#helperTV").append(text);
			}
			p.displayMe( $("#helperTV") );
			mod.displayedTree.push(id);
		});
		
	}
	
	Module.prototype.displayHelperText = function(id, text) {
		var mod = this;
		
		if(text == null) {
			return false;
		}
		for (i=0; i<mod.displayedHelperTextFrom.length; i++) {
			if(mod.displayedHelperTextFrom[i] == id) {
				console.log("already displayed");
				return false
			}
		}
		
		
		$("#helperTV").append(text);
		console.log(mod.displayedHelperTextFrom)
		mod.displayedHelperTextFrom.push(id);
		MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
		
	}
	
	Module.prototype.displayKeys = function() {
		var mod = this;
		var count = 0;
		this.key_ids.forEach(function (entry) {
			count = count+1;
			var $slide = $("<div>", {class: "slide_button", width: "20px"});
			$slide.append(count)
			$slide.data("_problem", entry)
			$slide.data("currentProblem", false);
			
			$slide.bind("click", function() {
				if($slide.data("currentProblem") == false) {
					$(".slide_button").data("currentProblem", false); //turn on all other slide keys
					$slide.data("currentProblem", true); // make this slide the current problem
					
					$("#helperTV").html(""); //clear helperTV
					mod.displayedTree = [];
					mod.displayedHelperTextFrom = [];
					
					$("#mainTV").html(""); //clear the mainTV					
					
					mod.getProblem( $slide.data("_problem"), function(p) {
						p.displayMe( $("#mainTV") );					
					});
				}
			});
			
			$("#keys").append($slide);
		});
		
	}
 
	return {
		getModuleObject: function() { return Module; },
	};
 
 });