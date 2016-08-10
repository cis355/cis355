<?php/* *******************************************************************
* filename : registerbusiness.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this allows the user to register a new business in the businees table 
*
* purpose: if the user wants to add a new business to hold gigs at, they can use this page 
* to enter business contact and location info as well as business name to a new record in the business 
* table 
*
* input : database.php
*
* processing : 
* 1. checks if logged in 
* 2. checks for post data sent to this page 
* 3. prints the html elements for the nav and form 
* 4. posts the form data back to this page 
* 5. if data was passed back in the POST and not valid show error messages 
* 6. if valid insert new business information 
*
* output : outputs the html elements for the nav as well as the form for new business registration 
*
* precondition : must be logged in, business name must be unique 
* *******************************************************************
*/
session_Start();
	if (($_SESSION['gigsUserName'] == '') || ($_SESSION['gigsUserId'] == ''))
		header("Location: login.php");
	else
	{
		$userName = $_SESSION['gigsUserName'];
		$userId = $_SESSION['gigsUserId'];
	}
	require 'database.php';
	if ( !empty($_POST)) {
		// keep track validation errors
		// if data was passsed insert record .. else do nothing 
		$businessNameError = null;
		$checkError = null;
		$cityError = null;
		$stateError = null;
		$zipError = null;
		$phoneError = null;
		$emailError = null;
		$description = "No description";
		$description = $_POST['description'];
		

		
		// keep track post values
		$checkValue = $_POST['agreeToOwn'];
		$businessName = $_POST['businessName'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		
		
		// validate input
		// checks that you filled all the fields. 
		$valid = true;
		if (empty($businessName)) {
			$businessNameError = 'Please enter Business Name';
			$valid = false;
		}
		
		if (empty($phone))
		{
			$valid = false;
			$phoneError = 'A phone number must be entered';
		}
		
		if (empty($email))
		{
			$valid = false;
			$emailError = 'An email address must be entered';
		}
		
		if (empty($checkValue))
		{
			$valid = false;
			$checkError = 'Must agree to have owner permission';
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
		$sql = "SELECT * FROM business WHERE businessName = ?";
		//$results = $pdo->query($sql);
		$q = $pdo->prepare($sql);
		$q->execute(array($businessName));
		$results = $q->fetch(PDO::FETCH_ASSOC);
		if (!empty($results))
		{
			
			$valid = false;	
			$businessNameError = 'Business already exists';
		}
		Database::disconnect();
		

		// verify password is correct for user name
		// uses data in the form below to insert a row into the db table 
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "INSERT INTO business (businessName,businessOwner, businessDescription,city,state,zip,phone,email) values(?, ?, ?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($businessName,$userId,$description,$city,$state,$zip,$phone,$email));
			Database::disconnect();
			//safeRedirect("home.php",true);
			
			header("Location: home.php");
					echo "<h1>Record Added!!!!</h1>";
		
			
			
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

    <title>Gigs|Register Business</title>

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
								<h1>Register Business</h1>

										<form action="registerbusiness.php" method="post">

												<div class="form-group <?php echo !empty($businessNameError)?'has-error':'';?>">
														<label class="control-label" for="businessName">Business Name</label>
														<input type="text" name="businessName" class="form-control" id="businessName" placeholder="Enter Business Name" value="<?php echo !empty($businessName)?$businessName:'';?>">
														<?php if (!empty($businessNameError)): ?>
															<span class="help-inline"><label class="control-label" for="businessName">
															<?php echo $businessNameError;?>
															</label></span>
														<?php endif; ?>
										 		</div>
												
												<div class="form-group <?php echo !empty($nope)?'error':'';?>">
												<label class="control-label">Business Description:(optional)</label>
													<textarea rows="3" name="description" class="form-control" type="text" placeholder="Description" value="<?php echo !empty($description)?$description:'';?>"></textarea>
												</div>
												
												
												<div class="form-group <?php echo !empty($cityError)?'has-error':'';?>">
												<label class="control-label" for="city">Business Home City</label>
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
												
												<div class="form-group <?php echo !empty($emailError)?'has-error':'';?>">
												<label class="control-label" for="email">Email</label>
													<input name="email" class="form-control" type="text"  id="email" placeholder="Email" value="<?php echo !empty($email)?$email:'';?>">
													<?php if (!empty($emailError)): ?>
														<span class="help-inline"><label class="control-label" for="email">
														<?php echo $emailError;?>
														</label></span>
													<?php endif; ?>
												</div>
												
												<div class="form-group <?php echo !empty($phoneError)?'has-error':'';?>">
												<label class="control-label" for="phone">Phone Number:</label>
													<input name="phone" id="phone" class="form-control" type="text" placeholder="###-###-####" value="<?php echo !empty($phone)?$phone:'';?>">
													<?php if (!empty($phoneError)): ?>
														<span class="help-inline"><label class="control-label" for="phone">
														<?php echo $phoneError;?>
														</label></span>
													<?php endif;?>
												</div>
												
												<p>
												<div class="form-group" <?php echo !empty($checkError)?'has-error':'';?>">
														<label class="checkbox-inline">
																<input type="checkbox" name="agreeToOwn" value="agree">I agree that i own this business or have explicit permission from the owner
																<?php if (!empty($checkError)): ?>
																	<span class="help-inline" style="color: red;"><?php echo $checkError;?></span>
																<?php endif;?>
														</label>
												</div>
												</p>

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
