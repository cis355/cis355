<?php
/* *******************************************************************
* filename : choosebandconfirm.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : allows the business choosing a band to hire to confirm thier choice 
*
* purpose: not only does this page allow the business the chance to back out of a decision on the off
* chance that the button click was a mistake, also if a band is already hired it will warn the business that 
* by hiring a new band it will "unhire" the band that has already been hired for this gig.
*
* input : database.php
*
* processing : 
* 1. checks if logged in 
* 2. checks if bandId, gigId were in the get request
* 3. gets the bookedBand (if any) from select statement
* 4. checks for post data
* 5. prints html nav codes 
* 6. prints the form for confirm with yes/no buttons and hiddent input
* 7. if a band was already hired, displays warning you will be un hiring that band. 
* 8. posts the yes answer back to this page and updates the booked band
* 9. returns to choosebands.php
*
* output : outputs the nav html for this site along with a "are you sure " confirm prompt
* allong with the buttons to go back or hire a different band.
*
* precondition : has to be logged in and has to have bandId,gigId in get request 
* *******************************************************************
*/
session_Start();
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
	
	$dest = "Location: home.php?&errorMsg=removingGig";
	if ( !empty($_GET['bandId'])) {
		$bandId = $_REQUEST['bandId'];
	}
	if ( !empty($_GET['gigId'])) {
		$gigId = $_REQUEST['gigId'];
	}
			
	if(($gigId == null) || ($bandId == null))
	{
		header($dest);
	}
	else
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM gigs WHERE gigId = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($gigId));
		$results = $q->fetch(PDO::FETCH_ASSOC);
		$openGig = $results['open'];
		$bookedBand = $results['bookedBand'];
		
		if ( !empty($_POST)) {
			//good to do code
			

			if (!empty($results))
			{
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "UPDATE gigs  set open = ?, bookedBand = ? WHERE gigId = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array(0,$bandId,$gigId));
				header("Location: chooseband.php?gigId=" . $gigId);
			}
			else 

		header($dest);
			
		}
			
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

    <title>Gigs|Hire Band</title>

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
								<h1>Hire Band</h1>
						<form action="choosebandconfirm.php?gigId=<?php echo $gigId . "&bandId=" . $bandId; ?>" method="post">
								<input type="hidden" name="answer" value="yes"/>
						<?php 
						$pdo = Database::connect();
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$sql = "SELECT * FROM bands WHERE bandId = ?";
						$q = $pdo->prepare($sql);
						$q->execute(array($bandId));
						$results = $q->fetch(PDO::FETCH_ASSOC);
						$bandName = $results['bandName'];				
						Database::disconnect();
						if ($openGig == 1)
							echo "<p class='alert alert-error'>Are you sure you want to hire " . $bandName . "?</p>";
					  else 
						{
							echo "<p class='alert alert-error'>This gig already has a booked Band!</p>";
							echo "<p class='alert alert-error'>Hiring " . $bandName . " will change the booked band!</p>";
							echo "<p class='alert alert-error'>Are you sure you want to hire " . $bandName . "?</p>";
						}
						?>
						<div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn" href="applytogig.php?bandId=<?php echo $bandId;?>">No</a>
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
