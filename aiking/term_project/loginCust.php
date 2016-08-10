<?php  
     
    session_start(); 
     
    # include connection data and functions 
    require 'CRUD/database.php'; 
     
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
            $sql = "SELECT * FROM customers WHERE name = ? LIMIT 1"; 
            $q = $pdo->prepare($sql); 
            $q->execute(array($name)); 
            $results = $q->fetch(PDO::FETCH_ASSOC); 
            if($results['password']==$password) { 
                $_SESSION['name'] = $name;
                Database::disconnect(); 
                header("Location: index.html"); // redirect 
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
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-casual.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
</head>

<body> 
    <div class="container"> 
     
                <div class="span10 offset1"> 
                    <div class="row"> 
                        <h3 style="color: #fff;">Login</h3> 
                    </div> 
             
                    <form class="form-horizontal" action="loginCust.php" method="post"> 
                     
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>"> 
                        <label class="control-label" style="color: #fff;">User Name</label> 
                        <div class="controls"> 
                              <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>"> 
                              <?php if (!empty($nameError)): ?> 
                                  <span class="help-inline"><?php echo $nameError;?></span> 
                              <?php endif; ?> 
                        </div> 
                      </div> 
                       
                      <div class="control-group <?php echo !empty($passwordError)?'error':'';?>"> 
                        <label class="control-label" style="color: #fff;">Password</label> 
                        <div class="controls"> 
                              <input name="password" type="password" placeholder="password" value="<?php echo !empty($password)?$password:'';?>"> 
                              <?php if (!empty($passwordError)): ?> 
                                  <span class="help-inline"><?php echo $passwordError;?></span> 
                              <?php endif;?> 
                        </div> 
                      </div> 
                       
					  </br>
					   
                      <div class="form-actions"> 
                          <button type="submit" class="btn btn-success">Login</button> 
                          <a class="btn" style="color: #fff;" href="index.html">Back</a>
                        </div> 
                         
                    </form> 
                     
                </div> 
                 
    </div> <!-- /container --> 
  </body>
</html>