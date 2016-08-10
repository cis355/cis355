<?php 
/* *******************************************************************
* filename : updategig.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : allows a business to update gig information 
*
* purpose: if a business needs to change gig information like door fee, band payment 
* or date/time or possibly entered the data wrong in the first place then the business
* can update the information here. 
*
* input : database.php
*
* processing : 
* 1. checks if logged in 
* 2. checks if gigId was passed in url for get request 
* 3. check for post data 
* 4. prints html elements for the nav and form for updating gig info
* 5. uses a select statment to pre fill the fields with existing data from that record 
* 6. sends the POST data back to this page and checks for validity 
* 7. if valid updates the record with the data and returns home 
* 8. else prinst error messages 
* 
* output : prints the html nav elements and the form for updating gig info with the 
* fields pre filled with existing data 
*
* precondition : must be logged in and gigId was sent over the url 
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
	
$gigId = null;
	$dest = "Location: home.php?errorMsg=updatingGig";
	if ( !empty($_GET['gigId'])) {
		$gigId = $_REQUEST['gigId'];
	}
	
	if($gigId == null)
		header($dest);	
	
	// uses information in the database.php to link to the db

	if ( !empty($_POST)) {
		// keep track validation errors
		// if data was passsed insert record .. else do nothing 
		$startError = null;
		$endError = null;
		$dateError = null;
		$bandPayment = 0.00;
		$charge = 0.00;
		
		// keep track post values
		$startTime = $_POST['startTime'];
		$endTime = $_POST['endTime'];
		$bandPayment = $_POST['bandPayment'];
		$charge = $_POST['charge'];
		$gigDate = $_POST['gigDate'];
		
		
		// validate input
		// checks that you filled all the fields. 
		$valid = true;
		if (empty($startTime)) {
			$startError = 'Please enter start time';
			$valid = false;
		}
		
		if (empty($gigDate)) {
			$dateError = 'Please enter Date';
			$valid = false;
		}
		
		if (empty($endTime)) {
			$endError = 'Please enter end time';
			$valid = false;
		}

		// uses data in the form below to insert a row into the db table 
		if ($valid) {
			 
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE gigs  set gigDate = ?, timeStart = ?, timeEnd = ?, bandPayment = ?, customerCharge = ? WHERE gigId = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($gigDate,$startTime,$endTime,$bandPayment,$charge,$gigId));
			Database::disconnect();
			header("Location: home.php");
		}
	}
	else 
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM gigs where gigId = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($gigId));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$gigDate = $data['gigDate'];
		$startTime = $data['timeStart'];
		$endTime = $data['timeEnd'];
		$bandPayment = $data['bandPayment'];
		$charge = $data['customerCharge'];		
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

    <title>Gigs|Update Gig</title>

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
								<h1>Update Gig</h1>
								
								<?php $destination = "updategig.php" . "?gigId=" . $gigId; ?>
								<form action="<?php echo $destination;?>" method="post">

										<div class="form-group <?php echo !empty($dateError)?'has-error':'';?>">
												<label class="control-label" for="gigDate">Enter Gig Date</label>
												<input type="text" name="gigDate" class="form-control" id="gigDate" placeholder="Date (YYYY-MM-DD)" value="<?php echo !empty($gigDate)?$gigDate:'';?>">
												<?php if (!empty($dateError)): ?>
													<span class="help-inline"><label class="control-label" for="gigDate">
													<?php echo $dateError;?>
													</label></span>
												<?php endif; ?>
										</div>												
										
										<div class="form-group <?php echo !empty($startError)?'has-error':'';?>">
										<label class="control-label" for="startTime">Enter Gig Start Time</label>
											<input name="startTime" id="startTime" class="form-control" type="text" placeholder="Start time (HH:MM:SS)" value="<?php echo !empty($startTime)?$startTime:'';?>">
											<?php if (!empty($startError)): ?>
												<span class="help-inline"><label class="control-label" for="startTime">
												<?php echo $startError;?>
												</label></span>
											<?php endif;?>
										</div>
										
										<div class="form-group <?php echo !empty($endError)?'has-error':'';?>">
										<label class="control-label" for="endTime">Enter Gig End Time</label>
											<input name="endTime" id="endTime" class="form-control" type="text" placeholder="End time (HH:MM:SS)" value="<?php echo !empty($endTime)?$endTime:'';?>">
											<?php if (!empty($endError)): ?>
												<span class="help-inline"><label class="control-label" for="endTime">
												<?php echo $endError;?>
												</label></span>
											<?php endif;?>
										</div>
										
										<div class="form-group <?php echo !empty($nope)?'has-error':'';?>">
										<label class="control-label" for="bandPayment">Band Payment Amount</label>
											<input name="bandPayment" id="bandPayment" class="form-control" type="text" placeholder="$0.00" value="<?php echo !empty($bandPayment)?$bandPayment:'';?>">
										</div>
										
										<div class="form-group <?php echo !empty($nope)?'has-error':'';?>">
										<label class="control-label" for="charge">Customer Charge Amount</label>
											<input name="charge" id="charge" class="form-control" type="text" placeholder="$0.00" value="<?php echo !empty($charge)?$charge:'';?>">
										</div>

										<div class="form-actions">
											<button type="submit" class="btn btn-success">Update</button>
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
