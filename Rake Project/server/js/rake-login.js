 
 function LoginPage() {
	
	
	this.load = function() {
	
		
		$("#submit_login").click(function() {			

			var email = $("#email_login").val();
			var password = $("#password_login").val();
			var message = "";
			
			if(email == "")
				message += "Blank email input.";
			if(password == "")
				message += "<br>Blank password input.";
			if(!validateEmail(email))
				message += "<br>Email is invalid.";
				
			$("#error_msg_login").html(message);
			
			if(message != "") {
				
				$("#error_msg_login").fadeIn();
			} else {
				$("#error_msg_login").fadeOut();
				$("#al-login").attr("style", "display:block;");
				var request = '{"Service":"User","Method":"authenticate","Parameters":{"email": "'+email+'","password":"'+password+'"}}';
				$.post( api_url, {"data": request}, function( response ) {
					console.log( response.Status );
					console.log( response.Result ); 
					
					if(response.Status) {
						$.session.set( "rakeuser",  response.Result);
						$("#wrapper-full").fadeIn();
						$("#wrapper-small").attr("style", "display:none");
					} else {
						message = "Invalid Email or Password.";
						$("#error_msg_login").html(message);
						$("#error_msg_login").fadeIn();
					}
				}, "json");
				$("#al-login").attr("style", "display:none;");
			}
		});
		
		$("#register").click(function() {
			$("#wrapper-small").attr("style", "display:none");
			$("#wrapper-small-register").fadeIn();
		});
		
		$("#forgot_password").click(function() {
			$("#wrapper-small").attr("style", "display:none");
			$("#wrapper-small-forget").fadeIn();
		});
		
		
	};
	
	
 };
 
 
 