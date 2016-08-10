<?php
/* *******************************************************************  
* filename     : updatepassword.php 
* author       : Terry Lewis  
* username     : tjlewis2  
* course       : cs355  
* section      : 1  
* semester : Summer 2016  
*  
* description  : This file is responsible for allowing a user to update
*				 their password
*  
* input        : none  
* processing   : The program steps are as follows.    
*          1. connect to database
*		   2. verify that the new passwords match
*		   3. update the password in the database
* output       : none  
*  
* precondition : user an account
* postcondition: password is updated
* *******************************************************************
*/
	session_start();
		require 'database.php';
	if (empty($_SESSION['name'])) header("Location: login.php");
	
	if(!empty($_POST)) {

		$passwordSuccess = null;
		$passwordError = null;
		$username = null;
	
		$username = $_SESSION['name'];
		
		$password = $_POST['dpassword'];
		$confirmpassword = $_POST['cpassword'];
	
		$valid = true;

		if (empty($password)) {
			$passwordError = 'Please enter password';
			$valid = false;
		} 
	
		if (empty($confirmpassword)) {
			$passwordError = 'Please enter password';
			$valid = false;
		}
		
		if($valid) {

			if($password != $confirmpassword){
				$passwordError = 'Passwords do not match!';
				$valid = false;
				
			}
			else {
			
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$sql = ("UPDATE users SET password = '{$password}' WHERE user_name = '{$username}' ");
				$q = $pdo->prepare($sql);
				$q->execute();
				$passwordSuccess = 'Password updated! Redirecting to update page!';
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
    .row.content {height: 400px; min-width:1000px}
    
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

	.button2 {
    position: absolute;
    top: 50%;
	}

	
  </style>
</head>
<body>

<?php include("navbar.php"); ?>  

<div class="container-fluid text-center">
  <div class="row content">
  
	<?php include("sidenav.php"); ?>
	
    <div class="col-sm-8 text-left" >
      <h1>Change Your Password </h1>

		<div class="wrapper">
		
			<form action="#" method="post">
			
			<div>
				<label class="control-label"  style="margin-left:-135px";><font size="4">New Password:</font></label>
				<input style="width:150px; margin-right:5px; display:inline"; 
				type="password" class="form-control" name="dpassword" id="dpassword"><br>
			</div>	
		
			<div>
				<label class="control-label" style="margin-left:-215px; margin-top: 50px";><font size="4">Confirm New Password:</font></label>
				<input style="width:150px; display:inline"; 
				type="password" class="form-control" name="cpassword" id="cpassword"><br>
			</div>
			
			<button  onclick="window.location='updateprofile.php'" style="display:inline; width:15%; height:50px; margin-right:20px; margin-top:50px"; type="button" class="btn btn-primary">Back</button>
			
			<div class="form-actions" style="display:inline";>
			<button style="width:15%; height:50px; margin-right:0px; margin-top:50px"; type="success" class="btn btn-success">Submit</form></button><br>
			</div>
			
			<?php if (!empty($passwordError)): ?>
					<span class="help-inline"><?php echo '<br>' . $passwordError;?></span>
			<?php endif; ?>	
			
			<?php if (!empty($passwordSuccess)): ?>
				<font size="5" color="green"><span class="help-inline"><?php echo $passwordSuccess;?></font></span><br>
				<?php echo "<script>setTimeout(\"location.href = 'updateprofile.php';\",4500);</script>";?>
			<?php endif; ?>
			
			</form>
			
		</div>
					
    </div>
	
	<?php include("sidenav2.php"); ?>
  </div>
</div>


<footer class="container-fluid text-center">
  <p>Roommate Finder</p>
</footer>

</body>
</html>