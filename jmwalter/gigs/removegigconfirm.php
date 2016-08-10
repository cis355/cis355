<?php 
/* *******************************************************************
* filename : removegigconfirm.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this page removes a gig from the gig table 
*
* purpose: to confirm that a business really wants to remove this gig from public listings 
*
* input : database.php
*
* processing : 
* 1. checks if logged in
* 2. checks if gigId was passed over the url for the get request 
* 3. check for POST data sent to this page
* 4. prints the html elements for the nav and form prompty "are you sure " y/n
* 5. returns the post data to this page and removes the gig record with id of gigId from gigs table 
*  
* output : outputs the html elements for the nav and a "are you sure prompt" y/n form for 
* deleting a gig.
*
* precondition : gigId was passed in the url for the get request and user is logged in
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
	
	$dest = "Location: home.php?&errorMsg=removingGig";
	
	if ( !empty($_GET['gigId'])) {
		$gigId = $_REQUEST['gigId'];
	}
			
	if($gigId == null )
	{
		header($dest);
	}
	else
	{
		if ( !empty($_POST)) {
			//good to do code
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "DELETE FROM gigs WHERE gigId = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($gigId));
			Database::disconnect();	
			header("Location: home.php");
			
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

    <title>Gigs|Remove Gig</title>

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
								<h1>Delete Gig</h1>
								
						<form action="removegigconfirm.php?gigId=<?php echo $gigId; ?>" method="post">
							 <input type="hidden" name="answer" value="yes"/>
					  <p class="alert alert-error">Are you sure you want to delete this gig?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Yes</button>
						  <a class="btn btn-danger" href="home.php">No</a>
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
