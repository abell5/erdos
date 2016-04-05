/**
*  This is the first JS file to be laoded into require JS, sets up paths
*/

//Configure RequireJS

requirejs.config({
	
	baseUrl: "js",
	
	paths: {
		jquery: 'http://code.jquery.com/jquery-latest.min',
		problem_obj: 'problem_obj'
	}
	
});