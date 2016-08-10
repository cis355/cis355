<?php 
/* *******************************************************************
* filename : updateband.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : allows the user to update band info
*
* purpose: if a band has changed its information or entered it with errors the first time 
* this page allows them to change that data and resave it.
*
* input : database.php
*
* processing : 
* 1. checks if logged in 
* 2. checks if bandId was passed in url for get request 
* 3. check for post data 
* 4. prints html elements for the nav and form for updating band info
* 5. uses a select statment to pre fill the fields with existing data from that record 
* 6. sends the POST data back to this page and checks for validity 
* 7. if valid updates the record with the dat and returns home 
* 8. else prinst error messages 
*
* output : prints out html elments for the nav and prints the form for updating band info
* with fields pre set with existing data 
*
* precondition : must be logged in and bandId was sent in url for get request 
* *******************************************************************
*/
	session_start();
	require 'database.php';
		if (($_SESSION['gigsUserName'] == '') || ($_SESSION['gigsUserId'] == ''))
		header("Location: login.php");
	else
	{
		$userName = $_SESSION['gigsUserName'];
		$userId = $_SESSION['gigsUserId'];
	} 
	
	$bandId = null;
	$dest = "Location: home.php?&errorMsg=updateBand";
	if ( !empty($_GET['bandId'])) {
		$bandId = $_REQUEST['bandId'];
	}

	if ($bandId == null)
		header($dest);
	
	if ( !empty($_POST)) {
		// keep track validation errors
		// if data was passsed insert record .. else do nothing 
		$bandNameError = null;
		$cityError = null;
		$stateError = null;
		$zipError = null;

		// keep track post values
		$bandName = $_POST['bandName'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		
		// validate input
		// checks that you filled all the fields. 
		$valid = true;
		if (empty($bandName)) {
			$bandNameError = 'Please enter User Name';
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
		$sql = "SELECT * FROM bands WHERE bandName = ?";
		//$results = $pdo->query($sql);
		$q = $pdo->prepare($sql);
		$q->execute(array($bandName));
		$results = $q->fetch(PDO::FETCH_ASSOC);
		if (!empty($results))
		{
			if($results['bandId'] != $bandId)	//a band othe than the one being updated has this name.
			{
				$valid = false;	
				$bandNameError = 'Band already exists';
			}
		}
		Database::disconnect();
		
		// verify password is correct for user name
		// uses data in the form below to insert a row into the db table 
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE bands set bandName = ?, city = ?, state = ?, zip = ? WHERE bandId = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($bandName,$city,$state,$zip,$bandId));
			header("Location: home.php");		
			Database::disconnect();
		}
	}
	else
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM bands where bandId = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($bandId));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$bandName = $data['bandName'];
		$city = $data['city'];
		$state = $data['state'];
		$zip = $data['zip'];
		Database::disconnect();
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

    <title>Gigs|Update Band Profile</title>

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
								<h1>Update Band Profile</h1>
								
							<form action="updateband.php?bandId=<?php echo $bandId;?>" method="post">
							
								<div class="form-group <?php echo !empty($bandNameError)?'has-error':'';?>">
									<label class="control-label" for="bandName">User Name</label>
									<input type="text" name="bandName" class="form-control" id="bandName" placeholder="Enter Band Name" value="<?php echo !empty($bandName)?$bandName:'';?>">
									<?php if (!empty($bandNameError)): ?>
										<span class="help-inline"><label class="control-label" for="bandName">
										<?php echo $bandNameError;?>
										</label></span>
									<?php endif; ?>
								</div>
								
								<div class="form-group <?php echo !empty($cityError)?'has-error':'';?>">
								<label class="control-label" for="city">Your Bands Home Town</label>
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
									<a class="btn btn-danger" href="home.php">Back</a>
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
