$(document).ready(function() {

	$("#hideLogin").click(function() {
		$("#loginForm").hide();
		$("#registerForm").show();
	});

	$("#hideRegister").click(function() {
		//console.log("register was pressed");
		$("#registerForm").hide();
		$("#loginForm").show();
	});
});