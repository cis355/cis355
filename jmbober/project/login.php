<?php 
/* *******************************************************************
* filename : login.php
* author : Jenny Bober
* username : jmbober
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description: Creates a form for user to enter a username and password
               and log in if their input matches a record in the users table
               Also has a button to create a new account
*
* Structure:  PHP
                start session
                If post isn't empty...
                  create variables
                  validate input
                  connect to database
                  verify that password is correct for the username
              HTML
                Head --links to bootstrap
                Body --Create input form
                 
* precondition : database connection is valid, users table exists with proper fields
* postcondition: if user input matched a record, $_SESSION contains id and username,
                  and user is redirected to the index. Otherwise, outputs an error msg
*
* Code adapted from George Corser
* *******************************************************************/

  session_start();
  require 'database.php';

  #if there was data passed, then verify password,
  #otherwise do nothing (that is, just display html for login)
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$passwordError = null;
	
		// keep track post values
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		// validate input
		$valid = true;
		if (empty($username)) {
			$usernameError = 'Please enter username';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter password';
			$valid = false;
		}
				
		// Verify that password is correct for the username
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
			$q = $pdo->prepare($sql);
			$q->execute(array($username));
			$result = $q->fetch(PDO::FETCH_ASSOC);
			if($result['password']==$password) {
				$_SESSION['username'] = $username;
        $_SESSION['id']=$result['id'];
				Database::disconnect();
				header("Location: index.php"); // redirect
		  }
			else $passwordError = 'Password is not valid.';
			Database::disconnect();
			
		}#end if valid
	} # end if(!empty($_POST))
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
        <!-- FORM -->
        <form class="form-horizontal" action="login.php" method="post">
          <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
            <label class="control-label">Username</label>
            <div class="controls">
              <input name="username" type="text"  placeholder="Username" value="<?php echo !empty($username)?$username:'';?>">
              <?php if (!empty($usernameError)): ?>
                <span class="help-inline"><?php echo $usernameError;?></span>
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
          </br>
          <div class="form-actions">
            <button type="submit" class="btn btn-success">Login</button>
             <a class="btn" href="create.php" class="btn btn-success">Create new account</a>
          </div>
        </form>
      </div>
    </div> <!-- /container -->
  </body>
</html>
