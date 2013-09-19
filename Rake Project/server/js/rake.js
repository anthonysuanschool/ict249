 var api_url = "http://localhost/Rake/api.php";
 
 $(document).ready(function(){  
	
	var user = $.session.get('rakeuser');
	
	if(user == null || user == "" || user == undefined) {
		$("#wrapper-small").fadeIn();
		
	} else {
	
		$("#wrapper-full").fadeIn();
	}
	
	var login_page = new LoginPage();	
	login_page.load();
	
	var register_page = new RegisterPage();	
	register_page.load();
	
	var forget_page = new ForgetPage();	
	forget_page.load();
	
	var content_page = new ContentPage();	
	content_page.load();
	
	
	
 });
 
 
function validateEmail(email) {	
	var atpos=email.indexOf("@");
	var dotpos=email.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) 
		return false;
	else
		return true;
  
}