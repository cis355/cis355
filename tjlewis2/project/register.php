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
		$confirmpassword = null;
		$email = null;
		
		// keep track post values
		$name = $_POST['dname'];
		$password = $_POST['dpassword'];
		$confirmpassword = $_POST['cpassword'];
		$email = $_POST['demail'];
		
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
		
		if (empty($email)) {
			$emailError = 'Please enter email';
			$valid = false;
		} 
		
		if (empty($confirmpassword)) {
			$confirmpasswordError = 'Please confirm password';
			$valid = false;
		} 
		
		if(($password != $confirmpassword) AND (!empty($password)) AND (!empty($confirmpassword))){
			$confirmpasswordError = 'Passwords do not match!';
			$passwordError = 'Passwords do not match!';
			$valid = false;
		}
		
		
		// verify that password is correct for user name
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM Users WHERE user_name = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			
			$rowCnt = mysql_num_rows($results);

			if($rowCnt > 0){
				$nameError = 'Username already in use';
			}
			else {
			
				$sql = "INSERT INTO Users (user_name,email,password) values(?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$email,$password));
				header("Location: login.php"); // redirect
			}
			
			Database::disconnect();
			 // redirect	
		}
		
	} # end if ( !empty($_POST))
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
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="home.php">Home</a></li>
        <li><a href="#">Profiles</a></li>
        <li><a href="#">Listings</a></li>
        <li><a href="#">About</a></li>
		
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<li><input style="margin-top:10px; width:100px; margin-right:15px"; type="text"  class="form-control" name='username'  placeholder="Username"></input></li>
		<li><input style="margin-top:10px; width:100px; margin-right:15px"; type="password" class="form-control" name='password'  placeholder="Password"></input></li>
		<li><button style="margin-top: 10px; margin-right:15px"; type="button" class="btn btn-primary">Login</button></li>
		<li><button style="margin-top: 10px; type="button" class="btn btn-primary">Register</button></li>
		</ul>
  
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">


  <div class="row content">
    <div class="col-sm-2 sidenav">
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
    </div>
	
    <div class="col-sm-8 text-left">
      <h1>Register </h1>
      <p>Register page here</p>
      <hr>
      <h3>Info</h3>
      <p>This is info</p>
	  
	  
	<form class="form-horizontal" method="post" action="register.php">
	  
	 <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
		<label class="control-label">Username :</label>
		<div class="controls">
			<input style="width:300px"; type="text" class="form-control" name="dname" id="User name" value="<?php echo !empty($name)?$name:'';?>">
		<?php if (!empty($nameError)): ?>
			<span class="help-inline"><?php echo $nameError;?></span>
		<?php endif; ?>
		</div>
	 </div>
	 
	 <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
		<label class="control-label">Email :</label>
		<div class="controls">
			<input style="width:300px";type="text" class="form-control" name="demail" id="email" value="<?php echo !empty($email)?$email:'';?>">
		<?php if (!empty($emailError)): ?>
			<span class="help-inline"><?php echo $emailError;?></span>
		<?php endif; ?>	
		</div>
	 </div>
	 
	 <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
		<label class="control-label">Password :</label>
		<div class="controls">
			<input style="width:300px"; type="password" class="form-control" name="dpassword" id="dpassword" value="<?php echo !empty($password)?$password:'';?>">
		<?php if (!empty($passwordError)): ?>
			<span class="help-inline"><?php echo $passwordError;?></span>
		<?php endif; ?>	
		</div>
	 </div>

	 <div class="control-group <?php echo !empty($confimpasswordError)?'error':'';?>">
		<label class="control-label"> Confirm Password :</label>
		<div class="controls">
			<input style="width:300px"; type="password"  class="form-control" name="cpassword" id="cpassword" value="<?php echo !empty($confirmpassword)?$confirmpassword:'';?>">
		<?php if (!empty($confirmpasswordError)): ?>
			<span class="help-inline"><?php echo $confirmpasswordError;?></span>
		<?php endif; ?>	
		</div>
	 </div>
	 
	 <div class="form-actions">
						  <button type="submit" class="btn btn-success">Register</button>
						</div>
	 </form>
	
      </div>
      
	 <div class="col-sm-2 sidenav">
		<div class="well">
        <p>ADS</p>
     </div>
     <div class="well">
        <p>ADS</p>
     </div>
    </div>
	
    </div>
	

	
  </div>


<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>