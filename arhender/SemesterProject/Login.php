<?php
/* *******************************************************************
 filename     : Login.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the logic to handle validating
				and allowing login for the User
Input         : user input from the fields placed into a post array

Process:
1. check if post is empty, if it is just display the login page
2. if it isn't values were posted for login
3. validate the values and set valid to false if the values are blank
4. if after validation the values are valid, check the values in the login function
5. if it returns true the user is valid for the selected login type
6. set the session variables
7. redirect to the profile page
Output: session variables that are set
Precondition: user has a valid login within the selected table mentors or students
Postcondition: A logged in user who now can navigate the website properly
*********************************************************************  */
      session_start(); 
    
	echo "
<head>
	<meta charset='utf-8' />
	<title>Mentor Mingle</title>
	<link rel='stylesheet' type='text/css' href='global.css' />
</head>


	<header>
	<div align='left'>
		<a href='-'><img src='resources/MentorMingle.png' alt='Mentor Mingle logo'/></a>
			<H3>Mentor Mingle</H3>		
         </div>
	</header>";
	
	
   # include connection data and functions 
    require 'database.php'; 
     
    # if there was data passed, then verify password,  
    # otherwise do nothing (that is, just display html for login) 
    
	if ( !empty($_POST)) { 
        // keep track validation errors 
		
		
        $nameError = null; 
        $passwordError = null; 
         
        // keep track post values 
        $name = $_POST['name']; 
        $password = $_POST['password']; 
		$LoginType = $_POST['formLoginType'];
	
		
		
		
		
        // validate input 
        $valid = true; 
		$validcredentials = false;
        if (empty($name)) { 
            $nameError = 'Please enter user name'; 
            $valid = false; 
        } 
         
        if (empty($password)) { 
            $passwordError = 'Please enter password'; 
            $valid = false; 
        }  
        
		if($LoginType !=="Students" and $LoginType !=="Mentors"){
			
             			
			 $valid = false;
			 $passwordError = 'Incorrect credentials or login type';
		}
		
		
		if($valid){
			#check if the credentials provided are valid in the database
			$validcredentials = database::login($LoginType, $name, $password);
			if($validcredentials){
				$_SESSION['name'] = $name; #if they are set the session variables and redirect
				$_SESSION['LoginType'] = $LoginType;
				$_SESSION['YourProfile']= True;
				header("Location: Profile.php?user=" . $_SESSION['name']);
				
				
			}
			else
			{
				#otherwise display the password error as follows
				$passwordError = 'Incorrect credentials or login type';
			}
			
			
			
		}
		
	
    } # end if ( !empty($_POST)) 
		
	
	
?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="utf-8"> 
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
</head> 

<body> 
    <div class="container"> 
     
                <div class="span10 offset1"> 
                    <div class="row"> 
                        <h3>Login</h3> 
                    </div> 
             
                    <form class="form-horizontal" action="Login.php" method="post"> 
                     
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>"> 
                        <label class="control-label">User Name</label> 
                        <div class="controls"> 
                              <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>"> 
                              <?php if (!empty($nameError)): ?> 
                                  <span class="help-inline"><?php echo $nameError;?></span> 
                              <?php endif; ?> 
                        </div> 
                      </div> 
                       
                      <div class="control-group <?php echo !empty($passwordError)?'error':'';?>"> 
                        <label class="control-label">Password</label> 
                        <div class="controls"> 
                              <input name="password" type="password" placeholder="password" value="<?php echo !empty($password)?$password:'';?>"> 
                              <?php if (!empty($passwordError)): ?> 
                                  <span class="help-inline"><?php echo $passwordError;?></span> 
                              <?php endif;?> 
                        </div> 
                      </div> 
					    
                       
                      <div class="form-actions"> 
                          <button type="submit" class="btn btn-success">Login</button>  
                        <a class="btn btn-danger" href="signup.php">Sign Up</a>
						</div>
<select name="formLoginType">
  <option value="Mentors">Mentor</option>
  <option value="Students">Student</option>
</select>
							
                    </form> 
                </div> 
				

  
    </div> <!-- /container --> 
  </body> 
</html> 