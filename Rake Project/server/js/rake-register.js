
 function RegisterPage() {
	
	this.load = function() {
		
		var random_password = $("#random_password").attr('checked');
		if(random_password) {
			$("#password_register").attr('disabled','disabled');
			$("#password_register_retype").attr('disabled','disabled');
			$("#password_register").val("");
			$("#password_register_retype").val("");
		} else {
			$("#password_register").removeAttr('disabled');
			$("#password_register_retype").removeAttr('disabled');			
		}
			
		$("#submit_register").click(function() {	
			var email = $("#email_register").val();
			var password = $("#password_register").val();
			var password_retype = $("#password_register_retype").val();
			var message = "";
			var random_password = $("#random_password").attr('checked');
			if(random_password) {
				$("#password_register").attr('disabled','disabled');
				$("#password_register_retype").attr('disabled','disabled');
				password = "";
			} else {
				$("#password_register").removeAttr('disabled');
				$("#password_register_retype").removeAttr('disabled');
			}
			
			if(email == "")
				message += "Blank email input.";
			if((password == "") && !(random_password))
				message += "<br>Blank password input.";
			if((password != password_retype) && !(random_password))
				message += "<br>Password mismatch.";
			if(!validateEmail(email))
				message += "<br>Email is invalid.";
				
			$("#error_msg_register").html(message);
			if(message != "") {
				
				$("#error_msg_register").fadeIn();
			} else {
				$("#error_msg_register").fadeOut();
				$("#al-register").attr("style", "display:block;");
				var request = '{"Service":"User","Method":"create","Parameters":{"email": "'+email+'","password":"'+password+'"}}';
				$.post( api_url, {"data": request}, function( response ) {
					if( response.Status ) {
						$("#email_login").val(email);
						$("#password_login").val(password);
						$("#wrapper-small-register").attr("style", "display:none");
						$("#wrapper-small").fadeIn();						
					} else {
						if( response.Error != "none")
							message = response.Error;
						else
							message = "Error on registration process.";
						$("#error_msg_register").html(message);
						$("#error_msg_register").fadeIn();
					}
					
				}, "json");
				$("#al-register").attr("style", "display:none;");
			}
		});
		
		$("#random_password").change(function() {
			var random_password = $("#random_password").attr('checked');
			if(random_password) {
				$("#password_register").attr('disabled','disabled');
				$("#password_register_retype").attr('disabled','disabled');
				$("#password_register").val("");
				$("#password_register_retype").val("");
			} else {
				$("#password_register").removeAttr('disabled');
				$("#password_register_retype").removeAttr('disabled');				
			}
		});
		
		$("#register_login").click(function() {
			$("#wrapper-small-register").attr("style", "display:none");
			$("#wrapper-small").fadeIn();		
			$("#email_login").val("");
			$("#password_login").val("");			
		});
		
	};
	
};