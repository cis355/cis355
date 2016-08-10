<?php
/* *******************************************************************
* filename : chooseband.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this page prints out the bands that have applied 
* for the given gig and allows you to choose which one you want to hire
*
* purpose: the purpose of this page is to allow the business a way to hire, one of the applicant bands
* to play for the gig they have listed. 
*
* input : database.php
*
* processing : 
* 1. checks if logged in 
* 2. checks for gigId in get request
* 3. gets the pending bands that have applied from this gig with select statment
* 4. gets the hired band (if any) for this gig and adds it to a variable 
* 5. takse the applied bands and puts them into an int array
* 6. prints html and loops through all bands in the int array
* 7. loops through all bands in bands table and uses the checkifexists 
* 		fucntion to see if the band is one that has applied
* 8.  if they are the bookedBand then change the hirfe button to already hired...
* output : prints the nav parts of this site as well as a table with all the applied bands 
* and hired/hire buttons to choose a band to perform at your show.
*
* precondition : must be logged in and have gigId in get request
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
	
	$dest = "Location: home.php?&errorMsg=removingGig";
	
	if ( !empty($_GET['gigId'])) {
		$gigId = $_REQUEST['gigId'];
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
		
	if($gigId == null )
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
		$pendingBands = $results['pendingBands'];
		$bookedBand = $results['bookedBand'];
		$bandsArray = explode(",",$pendingBands);
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

    <title>Gigs|Choose Band</title>

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
								<h1>Choose Band</h1>
								<a href='clearbandfromgig.php?gigId=<?php echo $gigId;?>'><button align='center' type='' class='btn btn-warning'>Clear Hired Band</button></a>		
								<div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i>Open Gigs</h3>
                            </div>
										<table class="table table-striped">
						<thead>
							<tr>
								<th>Band Name</th>
								<th>City</th>
							</tr>
						</thead>
						<tbody>
						<?php
							if (!empty($gigId))
							{		

								  $pdo = Database::connect();
								 foreach($bandsArray as $tmpBand)
								 {
									$sql = "SELECT * from bands WHERE bandId =" . $tmpBand;
									foreach ($pdo->query($sql) as $row) {
											echo '<tr>';
											echo '<td>'. $row['bandName'] . '</td>';
											echo '<td>'. $row['city'] . '</td>';
											if ($tmpBand == $bookedBand)
												echo "<td style='color: red;'>Hired</td>";
											else
												echo "<td><a href='choosebandconfirm.php?gigId=" . $gigId . "&bandId=" . $tmpBand . "'><button align='center' type='' class='btn btn-success'>Hire Band</button></a></td>";
											echo '</tr>';
									}
									 
								 }
								 //$sql = "SELECT * from bands";
								
								 
								 Database::disconnect();
							}
						?>
						</tbody>
					</table>
					<a href='home.php'><button type='' class='btn btn-danger'>Back</button></a>									
								
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
