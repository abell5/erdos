/*Will seperate into 2 files later, and implement RequireJS...*/
/*For now, begin the class object...*/

var Problem = function (text) {
	this.text = text;
	
	console.log('Problem class instantiated');
};


/*Begin the engine code...*/
/*Engine methods*/


/*Main document code*/
jQuery(function($) {
	
	//Submit answer method
	$("body").on("click", "#button", function() {
		//Events that happen when div is clicked
		console.log("clicked");
	});
	
	var problem1 = new Problem('Convert \\( \\frac{4}{5} \\) to a decimal.');
	
	$('#problemTextbox').text(problem1.text); //Still unsure on whether to use .text() or .html()
	
	
});


