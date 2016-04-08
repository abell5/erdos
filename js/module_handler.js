 define(['jquery','problem_obj'], function($,prob) {
	
	var Problem = prob.getProblemObject();
	
	var Module = function(name,key_ids) {
		this.name=name;
		this.key_ids=key_ids; //key_ids should be an array
		this.problems = [];
		
		//Make a function that grabs all the problems by ids, and push them into an array of objects
		//which is stored as a variable as part of the object
	}
	
	Module.prototype.getProblem = function(id, callback) {
		var out;
		//console.log(this.problems);
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
				mod.problems.push(p);
				out = mod.problems[mod.problems.length-1];
				callback(out);
				return;
			});
		}
	}
	
	Module.prototype.displayKeys = function() {
		var mod = this;
		this.key_ids.forEach(function (entry) {
			var $slide = $("<div>", {class: "slide_button", width: "20px"});
			$slide.append(entry)
			$slide.data("_problem", entry)
			$slide.data("currentProblem", false);
			
			$slide.bind("click", function() {
				if($slide.data("currentProblem") == false) {
					$(".slide_button").data("currentProblem", false); //turn on all other slide keys
					$slide.data("currentProblem", true); // make this slide the current problem
					
					$("#mainTV").html(""); //clear the mainTV;
					
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