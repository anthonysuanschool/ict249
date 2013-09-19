<div id="wrapper-small-register">
    	<div id="login-content">
	    	<div id="login-logo">
    	        	<img src="images/logo.png" />
        	    </div>
	    	<div id="register-form">
				<h4>Register a new account.</h4>
    	    	<form name="register-form">
					<span>email</span><br>
	    	      	<input type="text" name="email" value="" id="email_register"/><br>
					
					<span>password</span><br>
            	    <input type="password" name="password" value="" id="password_register" style="margin-bottom:0px;" /><br>
					<span>retype password</span><br>
            	    <input type="password" name="password_retype" value="" id="password_register_retype" style="margin-bottom:0px;" /><br>
					<input type="checkbox" value="1" name="random_password" id="random_password"> <span>Generate Random Password</span>
					<br><br><br>
					<div class="ajax-loader" id="al-register"><img src="images/ajax-loader.gif"></div><br>
                	<center><div class="submit" id="submit_register">Register</div></center><br>
					<span id="error_msg_register" class="error_msg"></span>
	            </form>
				<center>
				<br>
				<span id="register_login">Login</span>
				<br>
            </div>
        </div>
    </div>