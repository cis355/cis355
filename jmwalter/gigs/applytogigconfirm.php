<?php 
/* *******************************************************************
* filename : applytogigconfirm.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this page gives the band applying to a gig the chance to confirm their application
*
* purpose: the purpose of this page is to prevent accedental applications, or miss clicks 
* and confirm the choice for sure
*
* input : database.php
*
* processing : 
* 1. checks if logged in
* 2. checks for gigId and bandId in get request 
* 3. checks for post data sent over 
* 4. displays html for a form with a confirm button and hidden input field 
* 5.posts respons back to this page to handle processing
* 6. updates the gigs table with the gigId and adds this band as a pending band
* output :
*
* precondition : needs to be logged in and have gigId,bandId in get request.
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
	$bandId = null;
	if ( !empty($_GET['gigId'])) {
		$gigId = $_REQUEST['gigId'];
	}
		if ( !empty($_GET['bandId'])) {
		$bandId = $_REQUEST['bandId'];
	}
		
	if(($gigId == null) || ($bandId == null))
	{
		$dest = "Location: home.php?errorMsg=Applying_to_gig";
		header($dest);
	}
	else
	{
		
		if ( !empty($_POST)) {
			//good to do code
				$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM gigs WHERE gigId = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($gigId));
			$results = $q->fetch(PDO::FETCH_ASSOC);

			if (!empty($results))
			{
				$updateBands = $results['pendingBands'];
				if(empty($updateBands))
					$updateBands = $bandId;
				else
				$updateBands = $updateBands . "," . $bandId;
				
					$sql = "UPDATE gigs set pendingBands = ? WHERE gigId = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($updateBands,$gigId));
				$dest = "Location: applytogig.php?bandId=" . $bandId; 
				header($dest);
			}
			else 
				$dest = "Location: home.php?errorMsg=Applying_to_gig";
		header($dest);
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

    <title>Gigs|Gig Application</title>

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
								<h1>Gig Application</h1>
								
							<form class="form-horizontal" action="applytogigconfirm.php?gigId=<?php echo $gigId . "&bandId=" . $bandId; ?>" method="post">
								<input type="hidden" name="answer" value="yes"/>
							<p class="alert alert-error">Are you sure you want to apply?</p>
							<div class="form-actions">
								<button type="submit" class="btn btn-success">Yes</button>
								<a class="btn btn-danger" href="applytogig.php?bandId=<?php echo $bandId;?>">No</a>
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
