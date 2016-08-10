<?php 
/* *******************************************************************
* filename : register.php
* author : Joshua Walters  
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this page is the form that allows a new user to register them selfs for gigs
*
* purpose: this page allows a new user to register on our database, including email,userName,password password confirm
* location
*
* input : database.php
*
* processing : 
* 1. checks for post data sent to this page 
* 2. first prints the html elements for the nav and form
* 3. uses POST to push the data back to this page 
* 4. if there was missing or bad data entered then show error messages 
* 5. if everything was entered well, then insert record into users
* 
* output : ouputs html elements for the nav, as well as a form for entereing user information
*
* precondition : user can not be in the db yet, and must have different usernames and different emails than anyone in the db already 
* *******************************************************************
*/
	// uses information in the database.php to link to the db
	session_start();
	require 'database.php';
	if ( !empty($_POST)) {
		// keep track validation errors
		// if data was passsed insert record .. else do nothing 
		$userNameError = null;
		$passwdError = null;
		$confPasswdError = null;
		$cityError = null;
		$stateError = null;
		$zipError = null;
		$emailError = null;
		
		// keep track post values
		
		$userName = $_POST['userName'];
		$passwd = $_POST['passwd'];
		$confPasswd =$_POST['confPasswd'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$email = $_POST['email'];
		
		// validate input
		// checks that you filled all the fields. 
		$valid = true;
		if (empty($userName)) {
			$userNameError = 'Please enter User Name';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Please enter Email';
			$valid = false;
		}
		
		if (empty($passwd) || ($passwd != $confPasswd)) {
			$passwd = "";
			$passwdError = 'Please enter Password';
			$valid = false;
		}
		
		if (empty($confPasswd) || ($passwd != $confPasswd)) {
			$confPasswdError = 'Please conferm Password';
			$confPasswd = "";
			$valid = false;
		}
		
		if (empty($city)) {
			$cityError = 'Please enter City';
			$valid = false;
		}
		
		if (empty($state)) {
			$stateError = 'Please enter State';
			$valid = false;
		}
		
		if (empty($zip)) {
			$zipError = 'Please enter Zip';
			$valid = false;
		}
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM users WHERE email = '$email'";
		//$results = $pdo->query($sql);
		$q = $pdo->prepare($sql);
		$q->execute(array($reuslts));
		$results = $q->fetch(PDO::FETCH_ASSOC);
		//$results = mysql_query($sql);
		if (!empty($results))
		{
			
			$valid = false;	
			$emailError = 'User email Exists';
		}
		Database::disconnect();
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM users WHERE userName = ?";
		//$results = $pdo->query($sql);
		$q = $pdo->prepare($sql);
		$q->execute(array($userName));
		$results = $q->fetch(PDO::FETCH_ASSOC);
		//$results = mysql_query($sql);
		if (!empty($results))
		{
			
			$valid = false;	
			$userNameError = 'User Name Exists';
		}
		Database::disconnect();
		

		// verify password is correct for user name
		// uses data in the form below to insert a row into the db table 
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "INSERT INTO users (userName,password,email,city,state,zip) values(?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($userName,$passwd,$email,$city,$state,$zip));
			header("Location: home.php");
					echo "<h1>Record Added!!!!</h1>";
		
			Database::disconnect();
			
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gigs|Register User</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Gigs</a>
            </div>
           
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Shows</a>
                    </li>
                    <li>
                        <a href="searchbands.php"><i class="fa fa-fw fa-bar-chart-o"></i> Bands</a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

								<div class="row">
								<h1>Register</h1>

										<form action="register.php" method="post">

												<div class="form-group <?php echo !empty($userNameError)?'has-error':'';?>">
														<label class="control-label" for="userName">User Name</label>
														<input type="text" name="userName" class="form-control" id="userName" placeholder="Enter User Name" value="<?php echo !empty($userName)?$userName:'';?>">
														<?php if (!empty($userNameError)): ?>
															<span class="help-inline"><label class="control-label" for="userName">
															<?php echo $userNameError;?>
															</label></span>
														<?php endif; ?>
										 		</div>
												
												<div class="form-group <?php echo !empty($emailError)?'has-error':'';?>">
												<label class="control-label" for="email">Email</label>
													<input name="email" class="form-control" type="text"  id="email" placeholder="Email" value="<?php echo !empty($email)?$email:'';?>">
													<?php if (!empty($emailError)): ?>
														<span class="help-inline"><label class="control-label" for="email">
														<?php echo $emailError;?>
														</label></span>
													<?php endif; ?>
												</div>
												
												<div class="form-group <?php echo !empty($passwdError)?'has-error':'';?>">
												<label class="control-label" for="passwd">Password</label>
													<input name="passwd" id="passwd" class="form-control" type="password" placeholder="Password" value="<?php echo !empty($passwd)?$passwd:'';?>">
													<?php if (!empty($passwdError)): ?>
														<span class="help-inline"><label class="control-label" for="passwd">
														<?php echo $passwdError;?>
														</label></span>
													<?php endif;?>
												</div>
												
												<div class="form-group <?php echo !empty($confPasswdError)?'has-error':'';?>">
												<label class="control-label" for="confPasswd">Confirm Password</label>
													<input name="confPasswd" id="confPasswd" class="form-control" type="password" placeholder="Confirm Password" value="<?php echo !empty($confPasswd)?$confPasswd:'';?>">
													<?php if (!empty($confPasswdError)): ?>
														<span class="help-inline"><label class="control-label" for="confPasswd">
														<?php echo $confPasswdError;?>
														</label></span>
													<?php endif;?>
												</div>
												
												<div class="form-group <?php echo !empty($cityError)?'has-error':'';?>">
												<label class="control-label" for="city">City</label>
													<input name="city" id="city" class="form-control" type="text" placeholder="City" value="<?php echo !empty($city)?$city:'';?>">
													<?php if (!empty($cityError)): ?>
														<span class="help-inline"><label class="control-label" for="city">
														<?php echo $cityError;?>
														</label></span>
													<?php endif;?>
												</div>
												
												<div class="form-group <?php echo !empty($stateError)?'has-error':'';?>">
												<label class="control-label" for="state">State</label>
													<input name="state" id="state" class="form-control" type="text" placeholder="State" value="<?php echo !empty($state)?$state:'';?>">
													<?php if (!empty($stateError)): ?>
														<span class="help-inline"><label class="control-label" for="state">
														<?php echo $stateError;?>
														</label></span>
													<?php endif;?>
												</div>
												
												<div class="form-group <?php echo !empty($zipError)?'has-error':'';?>">
												<label class="control-label" for="zip">Zip</label>
													<input name="zip" id="zip" class="form-control" type="text" placeholder="Zip" value="<?php echo !empty($zip)?$zip:'';?>">
													<?php if (!empty($zipError)): ?>
														<span class="help-inline"><label class="control-label" for="zip">
														<?php echo $zipError;?>
														</label></span>
													<?php endif;?>
												</div>

												<div class="form-actions">
													<button type="submit" class="btn btn-success">Register</button>
													<a class="btn btn-danger" href="index.php">Back</a>
												</div>
										</form>

										
										
								</div><!-- end row -->
								

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
