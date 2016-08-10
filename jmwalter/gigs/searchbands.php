<?php
/* *******************************************************************
* filename : searchbands.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : allows anyone to search all bands from band name or "all bands" 
*
* purpose: even if someone is not registered or logged in all bands are searchable from 
* this page by band name .. this was supposed to be here to link to 
* a bands "page" but i ran out of time. 
*
* input : database.php
*
* processing : 
* 1. prints all html nav elements 
* 2. checks for POST data sent back to this page 
* 3. if there was data sent back then refine search on band name with that data 
* 4. else prints the html table with data from the bands table
* 
* output : prints the html nav elements as well as a table 
* with band information searchable from band name  
*
* precondition : none
* *******************************************************************
*/
	session_Start();
	require 'database.php';
if ( !empty($_POST)) {
$searchOption = $_POST['searchOption'];	
$searchString = $_POST['searchString'];

	function checkIfExists($arr,$id)
	{
		foreach($arr as $entry)
		{
			if ($entry == $id)
				return true;
		}
		return false;
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

    <title>Gigs|Search Bands</title>

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
						<?php 
							if (($_SESSION['gigsUserName'] == '') || ($_SESSION['gigsUserId'] == ''))
							{
								echo "<li><a href='register.php'>Register</a></li>";
								echo "<li><a href='login.php'>Login</a></li>";
							}
							else 
							{
								//do stuff that being logged in requires...
								echo "<li><a href='home.php'>Dashboard</a></li>";
							}
							
						?>

            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"> Shows</a>
                    </li>
                    <li class="active">
                        <a href="searchbands.php"> Bands</a>
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
                        <h1 class="page-header"> Bands
												</h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard">Search here</i>
																							
															<form action="searchbands.php" method="post">
																<input type="text" name="searchString" placeholder="Band Name" value="<?php echo !empty($searchString)?$searchString:'';?>"></input>
																<button type="submit" class="btn btn-primary">Search</button>
															</form>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
								<div class="row">
								<h2>Band Information</h2>
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
																				echo '</tr>';
																	 }
																	 Database::disconnect();
															?>
															</tbody>
														</table>
												</div>
								</div>


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
