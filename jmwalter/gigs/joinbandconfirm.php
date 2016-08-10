<?php 
/* *******************************************************************
* filename : joinbandconfirm.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : gives the user a choice to confirm that they 
* want to join band with passed in band id
*
* purpose: this confirmation page is incase the user accedentally clicks the join band button 
* or clicks on the wrong band. 
*
* input : database.php
*
* processing : 
* 1. checks if logged in 
* 2. checks if bandId was passed over in the get request 
* 3. pulls the band name from bands using the bandId in a select statment
* 4. checks if post data was passed back
* 5. prints the nav html codes and form to pass back to this page with "are you sure" y/n prompty
* 6. uses the data passed back from the POST as a confirmation and updates the bands "members" field
* with the logged in users user id
*
* output : outputs the nav html elements and an html form with an "are you sure " prompt
*
* precondition :must be logged in and bandId needs to be in the getRequest 
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
	$dest = "Location: home.php?errorMsg=joiningBand";
		if ( !empty($_GET['bandId'])) {
		$bandId = $_REQUEST['bandId'];
	}
	
	function checkIfExists($arr,$id)
	{
		foreach($arr as $entry)
		{
			if ($entry == $id)
				return true;
		}
		return false;
	}
		
	if($bandId == null)
	{
		header($dest);
	}
	else
	{
		$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM bands WHERE bandId = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($bandId));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			$bandName = $results['bandName'];
		
		
		if ( !empty($_POST)) {
			//good to do code
			

			if (!empty($results))
			{
				
				
				$membersArray = explode(",", $results['members']);
				if (!checkIfExists($membersArray, $userId))
				{
					//add it 
					array_push($membersArray,$userId);
				}
				$updateMembers = implode(",",$membersArray);
				
				$sql = "UPDATE bands set members = ? WHERE bandId = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($updateMembers,$bandId));
				Database::disconnect();	
				header("Location: home.php");
			}
			else 

		header($dest);
			
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
								<h3>Join <?php echo $bandName;?></h3>
						
						
								<form class="form-horizontal" action="joinbandconfirm.php?bandId=<?php echo $bandId;?>" method="post">
									 <input type="hidden" name="answer" value="yes"/>
								<p class="alert alert-error">Are you sure to join <?php echo $bandName;?>?</p>
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
