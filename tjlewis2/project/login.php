<?php 

/* *******************************************************************  
* filename     : login.php 
* author       : Terry Lewis  
* username     : tjlewis2  
* course       : cs355  
* section      : 1  
* semester : Summer 2016  
*  
* description  : This file is responsible for displaying the login page and allowing
*				 users to sign on 
*  
* input        : none  
* processing   : The program steps are as follows.    
*          1. connect to database
*		   2. verify user input
*		   3. find user in database and log them in. Otherwise, display message telling user	
*			  that username or password is incorrect
* output       : none  
*  
* precondition : user is already in database
* postcondition: user is logged in
* *******************************************************************
*/
	session_start();
	
	# include connection data and functions
	require 'database.php';
	// keep track validation errors
	$error = "";
	
	if ( !empty($_POST)) {

		
		// keep track post values
		$name = $_POST['username'];
		$password = $_POST['password'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$error = $error . 'Please enter user name <br />';
			$valid = false;
		}
		
		if (empty($password)) {
			$error = $error . 'Please enter password <br />';
			$valid = false;
		} 
		
		// verify that password is correct for user name
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM Users WHERE user_name = ? LIMIT 1";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			
			
			if($results['password']==$password) {
				$_SESSION['name'] = $name;
				Database::disconnect();
				header("Location: mylistings.php"); // redirecting
			}
			else {
				$error = $error . 'username or password incorrect <br />';
				Database::disconnect();
			}
		}
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 250%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;}
    }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    
      
		<form action = "" method = "post">
			<ul class="nav navbar-nav navbar-right">
			<li><p style="margin-top:15px; margin-right:15px;"><font color="white" size="3">WELCOME, Please <a href="login.php" class="btn btn-default btn-md blue-color">Login</a> Or <a href="register.php" class="btn btn-default btn-md blue-color">Register</a></font></p></li>
			<li></li> 
		</form>
		
		</ul>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">
  <div class="row content">
	<?php include("sidenav.php"); ?>
    <div class="col-sm-8 text-left">
      <h1>Welcome to Roommate Finder. Find your new roommate!</h1>
      <p>Please login: </p>
	  <form align="center" id="loginform" action="" method="post" novalidate autocomplete="off" class="idealforms login">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" name="username" id="username" placeholder="Username">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" name="password" id="password" placeholder="Password">
			</div>
			<button type="submit" name="submit" class="btn btn-default btn-lg blue-color"> 
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Login
			</button>
			<div align="center"><p><font color="red"><?php echo $error; ?></font></p></div>
			<div class="clearfix"></div>
		</form><!-- end .login -->
    </div>
	<?php include("sidenav2.php"); ?>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Roommate Finder</p>
</footer>

</body>
</html>