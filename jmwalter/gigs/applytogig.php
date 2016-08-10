<?php
/* *******************************************************************
* filename : applytogig.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this page lists all open gigs a passed in band can apply to 
* and gives a button link to confirm application
*
* purpose: this page is designed to list all open gigs availiable to a band
* this allows them to add their band to the list of bands that want to play 
* at that particular gig.
*
* input : database.php
*
* processing : 
* 1. checks if user is logged in with session variables
* 2. checks for bandId in get request 
* 3. prints body html code 
* 4. loops through open gigs from gigs table in db
* 5.prints end of html code
* output :this prints the nav parts of the site as well as records from gigs
* in a table with a confirm appliation button that takes you to applytogigconfirm.php
*
* precondition : needs to have a bandId in the get request to display
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
	
	$bandId = null;
	if ( !empty($_GET['bandId'])) {
		$bandId = $_REQUEST['bandId'];
	}
	
	
	require 'database.php';
	
		// uses information in the database.php to link to the db
	
	
	function checkIfBandExists($arr,$id)
	{
		foreach($arr as $entry)
		{
			if ($entry == $id)
				return true;
			
		}
		return false;
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
								<h1>Gig Application <a href='home.php'><button type='' class='btn btn-danger'>Back</button></a></h1>
								
								
								<div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i>Open Gigs</h3>
                            </div>
										<table class="table table-striped">
										<thead>
											<tr>
												<th>Business Name</th>
												<th>Business Location</th>
												<th>Contact Information</th>
												<th>Gig Date</th>
												<th>Pays</th>
											</tr>
										</thead>
										<tbody>
										<?php
										
											if (!empty($bandId))
											{
												 $today = date('Y-m-d');
												 $pdo = Database::connect();
												 $sql = "SELECT 
												  gigs.gigId as gigId,
													business.businessName as name, 
													business.city as city,
													business.state as state,
													business.zip as zip,
													business.phone as phone,
													business.email as email,
													gigs.gigDate as date,
													gigs.timeStart as start,
													gigs.timeEnd as end,
													gigs.pendingBands as bands,
													gigs.bandPayment as payment
												 FROM `gigs` INNER JOIN business on business.businessId = gigs.bookingBusiness
												 WHERE gigs.gigDate > " . $today . " AND gigs.open = true;";
												 foreach ($pdo->query($sql) as $row) {
													 $myBands = explode(",", $row['bands']);	
															echo '<tr>';
															echo '<td>'. $row['name'] . '</td>';
															echo '<td>'. $row['city'] . ',' . $row['state'] . ',' . $row['zip'] . '</td>';
															echo '<td>' . $row['phone'] . ',' . $row['email'] . '</td>';
															echo '<td>' . $row['date'] . ',' . $row['start'] . '-' . $row['end'] . '</td>';
															echo '<td>$' . $row['payment'] . '</td>'; 
															if(!checkIfBandExists($myBands,$bandId))//checks if this band has already applied to the gig
																echo "<td><a href='applytogigconfirm.php?gigId=" . $row['gigId'] . "&bandId=" . $bandId . "'><button type='' class='btn btn-primary'>Get a gig</button></a></td>";		
															else
															{
																echo "<td><fieldset disabled><button style='color: red;' type='' class='btn btn-default'>Applied</button></fieldset></td>";
																echo "<td><a href='unapplytogigconfirm.php?gigId=" . $row['gigId'] . "&bandId=" . $bandId . "'><button type='' class='btn btn-danger'>Back out</button></a></td>";
															}	
															echo '</tr>';
													
												 }
												
												 Database::disconnect();
											}
										?>
										</tbody>
									</table>									
								
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
