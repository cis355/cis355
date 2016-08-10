<?php
/* *******************************************************************
* filename : listedgigs.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : shows all the gigs that the businessId business has listed along with 
* button links to update/delete/choose functions
*
* purpose: this page allows a business to go through the gigs that they have listed in the past and 
* see how many people have applied to this gig. from there they can update it and up the payment to get more bands to apply 
* or delete the gig, or choose a band to play at their show. 
*
* input : database.php
*
* processing : 
* 1. check if logged in and for businessId in the get request 
* 2. joins the business and gigs table to get data about gigs and displays it in a table with the data
* 3. adds buttons for update,delete,chooseband to manipulate the gig information on the business side
*
* output :prints the nav html elements and a table populated with gig data that has been inserted by the 
* current business
*
* precondition : must be logged in, and businessId must be in the url for the get request
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
	
	$businessId = null;
	$dest = "Location: home.php?errorMsg=readingListedGigs";
	if ( !empty($_GET['businessId'])) {
		$businessId = $_REQUEST['businessId'];
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
		
	if(($businessId == null))
	{
		header($dest);
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

    <title>Gigs|My Listed Gigs</title>

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
								<h1>Listed Gigs <a href='home.php'><button type='' class='btn btn-danger'>Back</button></a></h1>
								
								
								<div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i>Gigs</h3>
                            </div>
									<table class="table table-striped">
										<thead>
											<tr>
												<th>Business Name</th>
												<th>City</th>
												<th>Date</th>
												<th>Time</th>
												<th>Applicants</th>
												<th>Payment</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
										<?php
											if (!empty($businessId))
											{		
												 $sql = "SElECT 
												 business.businessName as name,
												 business.city as city,
												 gigs.gigId as gigId,
												 gigs.gigDate as date, 
												 gigs.timeStart as start,
												 gigs.timeEnd as end, 
												 gigs.pendingBands as bands,
												 gigs.bandPayment as payment
												 FROM gigs 
												 INNER JOIN business ON business.businessId = gigs.bookingBusiness 
												 WHERE bookingBusiness =" . $businessId;
												 $pdo = Database::connect();
												 foreach ($pdo->query($sql) as $row) {
															echo '<tr>';
															echo '<td>'. $row['name'] . '</td>';
															echo '<td>'. $row['city'] . '</td>';
															echo '<td>'. $row['date'] . '</td>';
															echo '<td>'. $row['start'] . '-' . $row['end'] . '</td>';
															if (!empty($row['bands']))
															{
																$bandsArray = explode(",", $row['bands']);
																echo "<td>" . sizeof($bandsArray) . "</td>";
																$active = true;
															}
															else
															{
																echo '<td>0</td>';
																$active = false;
															}
															echo '<td>$' . $row['payment'] . '</td>';
															if ($active)
																echo "<td><a href='chooseband.php?gigId=" . $row['gigId'] . "'><button type='' class='btn btn-primary'>Choose Band</button></a></td>";
															else
																echo "<td style='color: red;'>No Applicants</td>";
															echo "<td><a href='removegigconfirm.php?gigId=" . $row['gigId'] . "'><button align='center' type='' class='btn btn-danger'>Delete</button></a></td>";
															echo "<td><a href='updategig.php?gigId=" . $row['gigId'] . "'><button align='center' type='' class='btn btn-warning'>Update</button></a></td>";
															echo '</tr>';
												 }
												 Database::disconnect();
											}
										?>
										</tbody>
									</table>
									</div>
									</div>
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
