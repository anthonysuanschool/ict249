 
 function ContentPage() {
	
	
	this.load = function() {
		
		
		$("#logout").click(function() {
			$.session.remove("rakeuser");
			$("#wrapper-full").attr("style", "display:none");
			$("#wrapper-small").fadeIn();
		});
	};
	
	
 };