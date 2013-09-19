
function ForgetPage() {
	
	this.load = function() {
		
		$("#submit_forget").click(function() {	
			var email = $("#email_forget").val();
			var message = "";
			if(email == "")
				message += "Blank email input.";
			
			$("#error_msg_forget").html(message);
			if(message != "") {
				
				$("#error_msg_forget").fadeIn();
			} else {
				v$("#error_msg_forget").fadeOut();
				$("#al-forget").attr("style", "display:block;");
				var request = '{"Service":"User","Method":"requestPasswordChange","Parameters":{"email": "'+email+'"}}';
				$.post( api_url, {"data": request}, function( response ) {
					if( response.Status ) {
						$("#email_login").val(email);
						$("#wrapper-small-forget").attr("style", "display:none");
						$("#wrapper-small").fadeIn();				
					} else {
						if( response.Error != "none")
							message = response.Error;
						else
							message = "Error on request process.";
						$("#error_msg_forget").html(message);
						$("#error_msg_forget").fadeIn();
					}
					
				}, "json");
				$("#al-forget").attr("style", "display:none;");
			}
				
		});
		
		$("#register_forget").click(function() {
			$("#wrapper-small-forget").attr("style", "display:none");
			$("#wrapper-small-register").fadeIn();
		});
	};
};