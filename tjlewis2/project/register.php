<?php 
/* *******************************************************************  
* filename     : register.php 
* author       : Terry Lewis  
* username     : tjlewis2  
* course       : cs355  
* section      : 1  
* semester : Summer 2016  
*  
* description  : 
*  
* input        : none  
* processing   : The program steps are as follows.    
*          1. connect to database
*		   2. verify that all data is entered correctly
*		   3. insert new user into table
* output       : none  
*  
* precondition : registration form is filled out correctly
* postcondition: user is created
* *******************************************************************
*/
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
		$registerError = null;
		$registerSuccess = null;
		
		// keep track post values
		$name = $_POST['dname'];
		$password = $_POST['dpassword'];
		$confirmpassword = $_POST['cpassword'];
		$email = $_POST['demail'];
		
		// validate input
		$valid = true;
		if ((empty($name))||(empty($password))||(empty($email))||(empty($confirmpassword))) {
			$registerError = 'All fields must be filled in!';
			$valid = false;
		}
		 
		
		if(($password != $confirmpassword) AND (!empty($password)) AND (!empty($confirmpassword))){
			$passwordError = 'Passwords do not match!';
			$valid = false;
		}
		
		
		// verify that password is correct for user name
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT COUNT(*) AS COUNT FROM Users WHERE user_name = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			
			$rowCnt = $results['COUNT'];

			if($rowCnt > 0){
				$nameError = 'Username already in use';
			}
			else {
				//registers user into the database
				$sql = "INSERT INTO Users (user_name,email,password) values(?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$email,$password));
				
				//get generated user_id that was just inserted
				$user_id= $pdo->lastInsertId('user_id');

				
				$registerSuccess = 'Registration successful! Redirecting Now! Please log in.';
				

			}
			
			Database::disconnect();
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
						
						.wrapper {
							text-align: center;
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
      <a class="navbar-brand" href="#">Roommate Finder</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">

      </ul>
      
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
		<h1>Register </h1>
		<p>Please fill out the form below</p>
		<hr>


		<form class="form-group" method="post" action="register.php" align="center">
		
			<div class="form-group <?php echo !empty($nameError)?'error':'';?>">
				<label class="form-label">Username :</label>
				<input style="width:50%; margin:0 auto"; type="text" class="form-control" name="dname" id="User name" value="<?php echo !empty($name)?$name:'';?>">
			</div>

			<div class="form-group <?php echo !empty($emailError)?'error':'';?>">
				<label class="form-label">Email :</label>
				<input style="width:50%; margin:0 auto"; type="text" class="form-control" name="demail" id="email" value="<?php echo !empty($email)?$email:'';?>">

			</div>

			<div class="form-group <?php echo !empty($passwordError)?'error':'';?>">
				<label class="form-label">Password :</label>
				<input style="width:50%; margin:0 auto"; type="password" class="form-control" name="dpassword" id="dpassword" value="<?php echo !empty($password)?$password:'';?>">
			</div>

			<div class="form-group <?php echo !empty($confimpasswordError)?'error':'';?>">
				<label class="form-label"> Confirm Password :</label>
				<input style="width:50%; margin:0 auto"; type="password"  class="form-control" name="cpassword" id="cpassword" value="<?php echo !empty($confirmpassword)?$confirmpassword:'';?>">
			</div>
			

			<div class="form-actions">
				<button type="submit" class="btn btn-success">Register</button>
			</div>
		
			<?php if (!empty($registerError)): ?>
				<font color="red"><span class="help-inline"><?php echo $registerError;?></font></span><br>
			<?php endif; ?>	
			
			<?php if (!empty($nameError)): ?>
				<font color="red"><span class="help-inline"><?php echo $nameError;?></font></span><br>
			<?php endif; ?>	
			
			<?php if (!empty($passwordError)): ?>
				<font color="red"><span class="help-inline"><?php echo $passwordError;?></font></span><br>
			<?php endif; ?>	
			
			<?php if (!empty($registerSuccess)): ?>
				<font size="5" color="green"><span class="help-inline"><?php echo $registerSuccess;?></font></span><br>
				<?php echo "<script>setTimeout(\"location.href = 'login.php';\",4500);</script>";?>
			<?php endif; ?>
			
		</form>

	</div>

	

<?php include("sidenav2.php"); ?>
</div>
</div>


<footer class="container-fluid text-center">
	<p>Roommate Finder</p>
</footer>

</body>
</html>