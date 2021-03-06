//var api_url = "http://localhost/rake1/api.php";

var api_url = "http://rakeapp.anthonysuan.com/api.php";



$(document).on( 'pageinit', function(){ 	

	
	$("#random-password").change(function() {
		var random_password = $("#random-password").is(":checked");
		if(random_password) {			
			$("#register-form .password").attr('disabled','disabled');
			$("#register-form .rpassword").attr('disabled','disabled');
			$("#register-form .password").val("");
			$("#register-form .rpassword").val("");

		} else {
			$("#register-form .password").removeAttr('disabled');
			$("#register-form .rpassword").removeAttr('disabled');			
		}
	});
});


$(document).ready(function(){  
	
	var user = $.session.get('rakeuser');
	if(user == null || user == "" || user == undefined) {
		setTimeout(hideSplashShowLogin, 5000);
	} else {
		setTimeout(hideSplashShowDashboard, 1000);
	}
	
	var user = $.session.get('rakeuser');
	if(user == null || user == "" || user == undefined) {
	} else {
		scrapeList();
	}
	
	$( '#login-form .submit' ).click(function() {
		var email = $("#login-form .email").val();
		var password = $("#login-form .password").val();
		var message = "";

		if(email == "")
			message += "Blank email input.<br>";
		if(password == "")
			message += "Blank password input.<br>";
		if(!validateEmail(email))
			message += "Email is invalid.";
			
		if(message != "") {				
			$("#login-popup").html(message);
			$( "#login-popup" ).popup( "open" )
		} else {
				$('.scraper_list').html("");
				$.mobile.loading( 'show');
				var request = '{"Service":"User","Method":"authenticate","Parameters":{"email": "'+email+'","password":"'+password+'"}}';
				$.post( api_url, {"data": request}, function( response ) {
					console.log( response.Status );
					console.log( response.Result ); 
					
					if(response.Status) {
						$.session.set( "rakeuser",  response.Result);
						$.mobile.changePage("#dashboard", "fade");
						scrapeList();
					} else {
						message = "Invalid Email or Password.";
						$("#login-popup").html(message);
						$( "#login-popup" ).popup( "open" )
					}
					$.mobile.loading( 'hide');
				}, "json");
				
			}
		
	});
	
	$( '#register-form .submit' ).click(function() {
		var email = $("#register-form .email").val();
		var password = $("#register-form .password").val();
		var password_retype = $("#register-form .rpassword").val();
		var message = "";

		var random_password = $("#random-password").is(":checked");
		
			
		if(email == "")
			message += "Blank email input.<br>";
		if((password == "") && !(random_password))
			message += "Blank password input.<br>";
		if((password != password_retype) && !(random_password))
			message += "Password mismatch.<br>";
		if(!validateEmail(email))
			message += "Email is invalid.";

		
		if(message != "") {
			
			$("#register-popup").html(message);
			$( "#register-popup" ).popup( "open" )
		} else {
			$.mobile.loading( 'show');
			var request = '{"Service":"User","Method":"create","Parameters":{"email": "'+email+'","password":"'+password+'"}}';
			$.post( api_url, {"data": request}, function( response ) {
				if( response.Status ) {
					$("#login-form .email").val(email);
					$("#login-form .password").val(password);
					$.mobile.changePage("#login", "fade");
				} else {
					if( response.Error != "none")
						message = response.Error;
					else
						message = "Error on registration process.";
					$("#register-popup").html(message);
					$( "#register-popup" ).popup( "open" )
					
				}
				$.mobile.loading( 'hide');
				}, "json");
				
			}
	});
	
	$( '#forgot-password-form .submit' ).click(function() {
		var email = $("#forgot-password-form .email").val();
		var message = "";

		if(email == "")
				message += "Blank email input.";
			
			if(message != "") {
				$("#forgot-password-popup").html(message);
				$( "#forgot-password-popup" ).popup( "open" )
				
			} else {

				$.mobile.loading( 'show');
				
				var request = '{"Service":"User","Method":"requestPasswordChange","Parameters":{"email": "'+email+'"}}';
				$.post( api_url, {"data": request}, function( response ) {
					if( response.Status ) {
						$("#login-form .email").val(email);
						$.mobile.changePage("#login", "fade");				
					} else {
						if( response.Error != "none")
							message = response.Error;
						else
							message = "Error on request process.";
						$("#forgot-password-popup").html(message);
						$( "#forgot-password-popup" ).popup( "open" )
					}
					$.mobile.loading( 'hide');
				}, "json");
				
			}
	});
	
	
	
	
	$( '.footer-login' ).click(function() {
		$.mobile.changePage("#login", "fade");
	});
	
	$( '.footer-sign-up' ).click(function() {
	
		$.mobile.changePage("#register", "fade");
		
		var random_password = $("#random-password").is(":checked");
		if(random_password) {
			$("#register-form .password").attr('disabled','disabled');
			$("#register-form .rpassword").attr('disabled','disabled');
			$("#register-form .password").val("");
			$("#register-form .rpassword").val("");
		} else {
			$("#register-form .password").removeAttr('disabled');
			$("#register-form .rpassword").removeAttr('disabled');			
		}			
	});
	
	$( '.footer-forgot-password' ).click(function() {
		$.mobile.changePage("#forgot-password", "fade");
	});
});

function scrapeList() {
	var request = '{"Service":"Scraper","Method":"getScrapersByUser","Parameters":{"user": "'+$.session.get('rakeuser')+'"}}';
	$.post( api_url, {"data": request}, function( response ) {
		if( response.Status ) {			
			$('.scraper_list').html("");
			$.each(response.Result, function (index) {
				$(".scraper_list").append('<li><a class="scraper_item" id="scraper_id_'+index+'">'+response.Result[index]+'</a></li>').listview( "refresh" );;

			});
		}					
	}, "json");

}


function hideSplashShowLogin() {
	$.mobile.changePage("#login", "fade");
}

function hideSplashShowDashboard() {
	$.mobile.changePage("#dashboard", "fade");
}

function validateEmail(email) {	
	var atpos=email.indexOf("@");
	var dotpos=email.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) 
		return false;
	else
		return true;
  
}