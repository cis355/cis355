<?php
/* *******************************************************************  
* filename     : loginProject.php  
* author       : Erik Federspiel & Start Bootstrap & Star Tutorial
*  				 https://startbootstrap.com/template-overviews/simple-sidebar/
				 https://www.startutorial.com/
* username     : ecfeders  
* course       : cs355  
* section      : 11-MW  
* semester : Summer 2016  
*  
* description  : php file that checks user name and password
 *  
 * processing   : The program steps are as follows.   
 *          1. display page
 *          2. enter information
			3. wait for button to click
 *          4. after button click go to correct form 
 *          5. based on button click do operations  
 
 * output       : see if correct login to go to create account page
 *  
 * precondition : css documents and php files in same directory/databaseProject.php
 * postcondition: actions based on button clicks
 * *******************************************************************   */ 
 ?>
 
<?php  

    session_start();
    # include connection data and functions 
    require 'databaseProject.php'; 
    
    # if there was data passed, then verify password,  
    # otherwise do nothing (that is, just display html for login)

    if ( !empty($_POST)) { 
        // keep track validation errors 
        $nameError = null; 
        $passwordError = null; 
         
        // keep track post values 
        $name = $_POST['name']; 
        $password = $_POST['password']; 
         
        // validate input 
        $valid = true; 
        if (empty($name)) { 
            $nameError = 'Please enter user name'; 
            $valid = false; 
        } 
         
        if (empty($password)) { 
            $passwordError = 'Please enter password'; 
            $valid = false; 
        }  
		
         
        // verify that password is correct for user name 
        if ($valid) { 
            $pdo = Database::connect(); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $sql = "SELECT * FROM workers WHERE name = ? LIMIT 1"; 
            $q = $pdo->prepare($sql); 
            $q->execute(array($name)); 
            $results = $q->fetch(PDO::FETCH_ASSOC); 
            if($results['password']==$password) { 
			    $_SESSION['name'] = $name;
                $_SESSION['buss-id'] = $results['buss_id']; 
                Database::disconnect(); 
                header("Location: project.php"); // redirect 
            } 
            else { 
                $passwordError = 'Password is not valid'; 
                Database::disconnect(); 
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
	<link href="css/create.css" rel="stylesheet">
</head> 

<body> 
    <div class="container"> 
     
                <div class="span10 offset1"> 
                    <div class="row"> 
                        <h3>Login</h3> 
                    </div> 
             
			        	<!-- Form that user cna input username and password and 
							then it uses php to check
						-->
                    <form class="form-horizontal" action="loginProject.php" method="post"> 
                     
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
                              <input name="password" type="password" placeholder="Password" value="<?php echo !empty($password)?$password:'';?>"> 
                              <?php if (!empty($passwordError)): ?> 
                                  <span class="help-inline"><?php echo $passwordError;?></span> 
                              <?php endif;?> 
                        </div> 
                      </div> 
                       
                      <div class="form-actions"> 
                          <button type="submit" class="btn btn-success">Login</button> 
                          <a href="createAccount.php" class="btn btn-danger">Sign Up</a>
                        </div> 
                         
                    </form> 
                    
                </div> 
                 
    </div> <!-- /container --> 
  </body> 
</html> 