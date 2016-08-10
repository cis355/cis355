<?php 
/* *******************************************************************
* filename : unapplytogigconfirm.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : allows the user to confirm they want to take their name off a gig application 
*
* purpose: incase a band has applied to a gig and either cant play it, or has another show that time, 
* this page allows them to withdraw from the application 
*
* input : database.php
*
* processing : 
* 1. check if logged in 
* 2. check if gigId and bandId was in the url for the get reaquest 
* 3. checks for post data sent to this page 
* 4. prints the html elements for the nav and form "are you sure" prompt 
* 5. POSTS the data back to this page and confirms that the band can be remvoed from the pending bands on this gig 
* 6. or sends user back to home 
*
* output : outputs the html elements for the nav and the "are you sure" y/n  prompt 
*
* precondition :  must be logged in and url must contain gigId and bandId information 
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
	
	//function responsible for taking the applied band list and removing the given id
	function removeFromList($arr,$removeId)
	{
		$retArr = array();
		foreach($arr as $i)
		{
			if ($i != $removeId)
				array_push($retArr,$i);
		}
		return $retArr;
	} 
	
	
	if ( !empty($_GET['gigId'])) {
		$gigId = $_REQUEST['gigId'];
	}
		if ( !empty($_GET['bandId'])) {
		$bandId = $_REQUEST['bandId'];
	}
		
	if(($gigId == null) || ($bandId == null))
	{
		$dest = "Location: home.php?errorMsg=Unapplying_to_gig";
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
				$tempBandList = explode(",", $results['pendingBands']);	
				$usersBands = removeFromList($tempBandList, $bandId);
				$updateBands = implode(",", $usersBands);
				$sql = "UPDATE gigs set pendingBands = ? WHERE gigId = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($updateBands,$gigId));
				$dest = "Location: applytogig.php?bandId=" . $bandId; 
				header($dest);
			}
			else 
				$dest = "Location: home.php?errorMsg=Unapplying_to_gig";
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

    <title>Gigs|Remove Gig Application</title>

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
								<h1>Remove Gig Application</h1>
								
							<form class="form-horizontal" action="unapplytogigconfirm.php?gigId=<?php echo $gigId . "&bandId=" . $bandId; ?>" method="post">
								<input type="hidden" name="answer" value="yes"/>
							<p class="alert alert-error">Are you sure you want to unapply?</p>
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
