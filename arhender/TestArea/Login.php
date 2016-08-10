<?php  
      session_start(); 
    
	
	
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
        
		
		
		
		if($valid){
			$validcredentials = database::login($LoginType, $name, $password);
			if($validcredentials){
				$_SESSION['name'] = $name;
				$_SESSION['LoginType'] = $LoginType;
				$_SESSION['YourProfile']= True;
				header("Location: Profile.php?user=" . $_SESSION['name']);
				
				
			}
			else
			{
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
                              <input name="password" type="password" placeholder="password Address" value="<?php echo !empty($password)?$password:'';?>"> 
                              <?php if (!empty($passwordError)): ?> 
                                  <span class="help-inline"><?php echo $passwordError;?></span> 
                              <?php endif;?> 
                        </div> 
                      </div> 
					    
                       
                      <div class="form-actions"> 
                          <button type="submit" class="btn btn-success">Login</button>  
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

