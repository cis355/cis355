<?php
/* *******************************************************************
* filename :  home.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this is the main dashboard page for all users/bands/businesses 
* all functions are branched from here
*
* purpose: this page allows a main control dashboard for bands/businesses/users to update/delete/create 
* gigs bands business ect. 
*
* input : database.php
*
* processing : 
* 1. checks if logged in 
* 2. prints the nav/log in html codes 
* 3. uses database to print tables for (users bands,users business,join band)
* 4. adds form for searching bands by bandname and passes back to this page in post
* 5. uses the string from post to refine search on band name.
*
* output : outputs the nav html for this site
* logut/edit user info
* create/update/delete/quit/join bands
* create/update/delete business
* list/view listed gigs
* apply to gig (as band)
*
* precondition : needs to be logged in 
* *******************************************************************
*/
	require 'database.php';
	session_Start();
	if (($_SESSION['gigsUserName'] == '') || ($_SESSION['gigsUserId'] == ''))
		header("Location: login.php");
	else
	{
		$userName = $_SESSION['gigsUserName'];
		$userId = $_SESSION['gigsUserId'];
	}
	
	$errorMsg = null;
		if ( !empty($_GET['errorMsg'])) {
		$errorMsg = $_REQUEST['errorMsg'];
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
	
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gigs|Home</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

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
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <!--<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $userName;?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $userName;?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong><?php echo $userName;?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>-->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $userName;?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="updateuserinfo.php"><i class="fa fa-fw fa-user"></i>Edit Profile</a>
                        </li>
                       <!--<li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>-->
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
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

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                             <?php echo $userName;?>'s Dashboard
                        </h1>
                        <ol class="breadcrumb">
                            
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

								<?php
								if ($errorMsg != null)
								{
									echo "<div class='row'><div class='col-lg-12'><div class='alert alert-danger alert-dismissable'>";                 
								
										echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
										echo "<i class='fa fa-info-circle'></i>  <strong>There was a problem!!!</strong> Source:" . $errorMsg; 
								echo "</div></div></div>";
								}   
                ?>
                <!-- /.row -->

               <!-- <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">26</div>
                                        <div>New Comments!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">12</div>
                                        <div>New Tasks!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">124</div>
                                        <div>New Orders!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">13</div>
                                        <div>Support Tickets!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                 /.row -->

                <!--<div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Area Chart</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-area-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                 /.row -->

                <div class="row">
                    <!--<div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Donut Chart</h3>
                            </div>
                            <div class="panel-body">
                                <div id="morris-donut-chart"></div>
                                <div class="text-right">
                                    <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i><?php echo $userName;?>'s Bands
																<a href="registerband.php"><button type='' class='btn btn-sm btn-success'>Register a new band</button></a></h3>
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
											if (!empty($userName))
											{
												 $pdo = Database::connect();
												 $sql = "SELECT * FROM bands";
												 foreach ($pdo->query($sql) as $row) {
													 $membersArray = explode(",", $row['members']);
													 if (checkIfExists($membersArray, $userId))
													{
															echo '<tr>';
															echo '<td>'. $row['bandName'] . '</td>';
															echo '<td>'. $row['city'] . '</td>';
															echo "<td><a href='applytogig.php?bandId=". $row['bandId'] . "'><button type='' class='btn btn-primary'>Gigs</button></a></td>";
															echo "<td><a href='quitbandconfirm.php?bandId=" . $row['bandId'] . "'><button type='' class='btn btn-danger'>Quit band</button></a></td>";
															if ($row['bandLeader'] == $userId)
															{
																echo "<td><a href='updateband.php?bandId=" . $row['bandId'] . "'><button type='' class='btn btn-warning'>Update</button></a></td>";
															}
															echo '</tr>';
													}
												 }
												 Database::disconnect();
											}
										?>
										</tbody>
									</table>
                           
                        </div>
                    </div>
										<div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo $userName;?>'s Businesses
																<a href="registerbusiness.php"><button align='center' type='' class='btn btn-sm btn-success'>Register a business</button></a></h3>
                            </div>
                            <table class="table table-striped">
												<thead>
													<tr>
														<th>Business Name</th>
														<th>City</th>
													</tr>
												</thead>
												<tbody>
												<?php
													if (!empty($userName))
													{		
														 $pdo = Database::connect();
														 
														 $sql = "SELECT * from business WHERE businessOwner =" . $userId;
														 foreach ($pdo->query($sql) as $row) {
																	echo '<tr>';
																	echo '<td>'. $row['businessName'] . '</td>';
																	echo '<td>'. $row['city'] . '</td>';
																	echo "<td><a href='registergig.php?businessId=" . $row['businessId'] . "'><button type='' class='btn btn-primary'>List a Gig</button></a></td>";
																	echo "<td><a href='listedgigs.php?businessId=" . $row['businessId'] . "'><button align='center' type='' class='btn btn-info'>Listed Gigs</button></a></td>";
																	echo "<td><a href='removebusinessconfirm.php?businessId=" . $row['businessId'] . "'><button align='center' type='' class='btn btn-danger'>Remove</button></a></td>";
																	echo "<td><a href='updatebusiness.php?businessId=" . $row['businessId'] . "'><button align='center' type='' class='btn btn-warning'>Update</button></a></td>";
																	echo '</tr>';
														 }
														 Database::disconnect();
													}
												?>
												</tbody>
											</table>
						
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong> Join A Band</strong></h3>
																<form action="home.php" method="post">
																	<input type="text" name="searchString" placeholder="Band Name" value="<?php echo !empty($searchString)?$searchString:'';?>"></input>
																	<button type="submit" class="btn btn-primary">Refine Results </button>
																</form>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
																				<thead>
																					<tr>
																						<th>Band Name</th>
																						<th>City</th>

																					</tr>
																				</thead>
																				<tbody>
																				<?php
																							$pdo = Database::connect();
																							if ( !empty($_POST)) {
																								$searchString = $_POST['searchString'];
																								$sqlAllBands = "SELECT bandId, bands.bandName, bands.city, bands.members FROM bands WHERE bandName LIKE '%" . $searchString ."%';";
																								}
																							else 
																								$sqlAllBands = "SELECT bandId, bands.bandName, bands.city, bands.members FROM bands;";
																							$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
																						 foreach ($pdo->query($sqlAllBands) as $row) {
																							 $membersArray = explode(",", $row['members']);
																									echo '<tr>';
																									echo '<td>'. $row['bandName'] . '</td>';
																									echo '<td>'. $row['city'] . '</td>';
																									if(checkIfExists($membersArray, $userId))
																										echo "<td><fieldset disabled><button style='color: red;' type='' class='btn btn-default'>Member</button></fieldset></td>";
																									else
																										echo "<td><a href='joinbandconfirm.php?bandId=" . $row['bandId'] ."'><button type='' class='btn btn-primary'>Join</button></a></td>";
																									echo '</tr>';
																						 }
																						 Database::disconnect();
																				?>
																				</tbody>
																			</table>
                                </div>
                                <div class="text-right">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

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

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
