<?php  
     
    session_start(); 
     
    # include connection data and functions 
    require 'database.php'; 
     
    # if there was data passed, then verify password,  
    # otherwise do nothing (that is, just display html for login) 
    if ( !empty($_POST)) { 
        // keep track validation errors 
        $userNameError = null; 
        $passwordError = null; 
         
        // keep track post values 
        $userName = $_POST['userName']; 
        $password = $_POST['password']; 
         
        // validate input 
        $valid = true; 
        if (empty($userName)) { 
            $userNameError = 'Please enter user name'; 
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
            $sql = "SELECT * FROM campUser WHERE userName=? LIMIT 1";
            $q = $pdo->prepare($sql);
            $q->execute(array($userName)); 
            $results = $q->fetch(PDO::FETCH_ASSOC); 
            if($results['password']==$password) { 
                $_SESSION['userName'] = $userName; 
                Database::disconnect(); 
				var_dump("got here");
                header("Location: camps.php"); // redirect 
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
</head> 

<body> 
    <div class="container"> 
     
                <div class="span10 offset1"> 
                    <div class="row"> 
                        <h3>Login</h3> 
                    </div> 
             
                    <form class="form-horizontal" action="login.php" method="post"> 
                     
                      <div class="control-group <?php echo !empty($userNameError)?'error':'';?>"> 
                        <label class="control-label">User Name</label> 
                        <div class="controls"> 
                              <input name="userName" type="text"  placeholder="userName" value="<?php echo !empty($userName)?$userName:'';?>"> 
                              <?php if (!empty($userNameError)): ?> 
                                  <span class="help-inline"><?php echo $userNameError;?></span> 
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
                          <button type="submit" class="btn btn-success">Create</button> 
                          <a class="btn" href="camps.php">Back</a> 
                        </div> 
                         
                    </form> 
                     
                </div> 
                 
    </div> <!-- /container --> 
  </body> 
</html> 