/**
*  This is the first JS file to be laoded into require JS, sets up paths
*/

//General rule of thumb is you use define when you want to define a module that will be reused by your application and you use require to simply load a dependency.
//Configure RequireJS

requirejs.config({
	
	baseUrl: "js",
	
	paths: {
		jquery: 'http://code.jquery.com/jquery-latest.min',
		problem_obj: 'problem_obj',
		
		main: '../main',
		
		//modules
		fractions: 'modules/fractions'
	}
	
});