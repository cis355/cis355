<!DOCTYPE html>
<!-- ------------------------------------------------------------------------
* filename : camps.php
* author : William Bateson
* username : wtbateso
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program shows basketball camps within the state of michigan
* for users to rate and recommend. This program utilizes the CRUD application
*
* input : taken from the create and update files
* processing : The program steps are as follows.
* 1. initialize session
* 2. display tables
* 3. print array
* 4. print sum of array elements
*
* output : camps tables
*
* precondition : check for login
* postcondition: information printed to the screen,
* 
* external code used in this file: 
*			http://www.ussportscamps.com/basketball/nike/michigan/#camp-dates
*			http://camps.mgoblue.com/Summer_Camps/Boys_Basketball/Player_Development_Camp.htm
*			http://pistonsacademy.com/wp-content/uploads/2015/05/HS-Hoopfest-Details.pdf
*			http://www.sportcamps.msu.edu/
*			Used some code from cis255 projects
*			bootstraped from cis255
*			
* program structure : 
*    <body>	navbar
*			SQL tables
*			former michigan greats
*			ratings widget
*              
------------------------------------------------------------------------- -->

<?php
	session_start();
	if (empty($_SESSION['userName'])) header("Location: login.php");
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Michigan Basketball Camps</title>
	<!-- JQUERY -->
	<!-- load jquery before bootstrap -->
	<!-- from: https://code.jquery.com/ -->
	<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="http://www.jqwidgets.com/jquery-widgets-documentation/scripts/jquery-1.11.1.min.js"></script>
		
    <!-- Bootstrap Core CSS -->
    <link href="http://csis.svsu.edu/~wtbateso/cis255/wtbateso/bootstraptemp/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="http://csis.svsu.edu/~wtbateso/cis255/wtbateso/bootstraptemp/css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="http://csis.svsu.edu/~wtbateso/cis255/wtbateso/bootstraptemp/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
	<style type="text/css">
		#found { display: none; }	
		#error { color: red; display: none; }
	</style>
    <style type="text/css">
        #container {
            position: relative;
        }
        .inputField {
            left: 110px;
            top: 323px;
            position: absolute;
            background: transparent;
            border: none;
        }
        text.jqx-knob-label {
            font-size: 20px;
        }
        .inputField .jqx-input-content {
            background: transparent;
            font-size: 20px;
            color: grey;
        }
    </style>
	
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="program04.html">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="http://csis.svsu.edu/~wtbateso/cis255/wtbateso/Ceevee10/Ceevee10/index.html">About</a>
                    </li>
					<li>
                        <a href="contact.html">Contact</a>
                    </li>
					
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Header Carousel -->
    <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
			<li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
               <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('http://www.gratitudedetroit.com/img/slider/city_slide_3.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Detroit</h2>
                </div>
            </div>
			<div class="item">
                <div class="fill" style="background-image:url('https://i.ytimg.com/vi/cBlM3Sx5uFg/maxresdefault.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Lansing</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('http://jameshowephotography.com/wp-content/uploads/2010/11/DSC7428And8more-full.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Saginaw</h2>
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('http://rdcnewscdn.realtor.com/wp-content/uploads/2016/02/flint-water-plant.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Flint</h2>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </header>

    <!-- Page Content -->
    <div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Welcome to Michigan Basketball</h1>
            </div>
			
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
						<table class="table table-striped table-bordered">
						  <thead>
							<tr>
							  <th>Camp Name</th>
							  <th>Start Date</th>
							  <th>End Date</th>
							  <th>Read File</th>
							</tr>
						  </thead>
						  <tbody>
							  <?php 
								   # database.php contains connection code, including connect and disconnect funtions
								   include 'database.php';
								   # connect to database and assign object to variable
								   $pdo = Database::connect();
								   # assign select statement to variable
								   $sql = 'SELECT * FROM camps ORDER BY id DESC';
								   # iterates through every record, return by the select statement
								   foreach ($pdo->query($sql) as $row) {
											echo '<tr>';
											echo '<td>'. $row['campName'] . '</td>';
											echo '<td>'. $row['startDate'] . '</td>';
											echo '<td>'. $row['endDate'] . '</td>';
											echo '<td> <a class="btn" href="read2.php?id='. $row['id'].'">Read</a> </td>';
											echo '       ';	
											echo '</td>';
											echo '</tr>';
								   }
								   Database::disconnect();
							  ?>
						  </tbody>
						</table>
                    </div> <!-- End of panel body div -->
                </div>  <!-- End of panel panel div -->
            </div>  <!-- End of col div -->
			
			</div> <!-- End of Row -->
			
		<div class="row">
			<p>
				<a href="create6.php" class="btn btn-success">Create a camp</a>
			</p>
		</div>
			
		<div class="row">
			<div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
						<table class="table table-striped table-bordered">
						  <thead>
							<tr>
							  <th>User Name</th>
							  <th>Camp Name</th>
							  <th>Rating out of 5</th>
							  <th>Review</th>
							  <th>Read File</th>

							</tr>
						  </thead>
						  <tbody>
							  <?php 
								  
								   # assign select statement to variable
								   $sql = 'SELECT * FROM campRating ORDER BY id DESC';
								   # iterates through every record, return by the select statement
								   foreach ($pdo->query($sql) as $row) {
											echo '<tr>';
											echo '<td>'. $row['userName'] . '</td>';
											echo '<td>'. $row['campName'] . '</td>';
											echo '<td>'. $row['rating'] . '</td>';
											echo '<td>'. $row['comments'] . '</td>';
											echo '<td> <a class="btn" href="read.php?id='. $row['id'].'">Read</a> </td>';
											echo '       ';
											echo '</td>';
											echo '</tr>';
								   }
								   Database::disconnect();
							  ?>
						  </tbody>
						</table>
                    </div> <!-- End of panel body div -->
                </div>  <!-- End of panel panel div -->
            </div>  <!-- End of col div -->
		</div>	
		
		<div class="row">
				<p>
					<a href="create.php" class="btn btn-success">Create a rating</a>
				</p>
		</div>
		
       <br />
	   
	   
	   <div class="row">
			<div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
						<table class="table table-striped table-bordered">
						  <thead>
							<tr>
							  <th>User Name</th>
							  <th>User Number</th>
							</tr>
						  </thead>
						  <tbody>
							  <?php 
								  
								   # assign select statement to variable
								   $sql = 'SELECT * FROM campUser ORDER BY id DESC';
								   # iterates through every record, return by the select statement
								   foreach ($pdo->query($sql) as $row) {
											echo '<tr>';
											echo '<td>'. $row['userName'] . '</td>';
											echo '<td>'. $row['userNumber'] . '</td>';
											echo '</td>';
											echo '</tr>';
								   }
								   Database::disconnect();
							  ?>
						  </tbody>
						</table>
                    </div> <!-- End of panel body div -->
                </div>  <!-- End of panel panel div -->
            </div>  <!-- End of col div -->
		</div>	
		
		
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Michigan Fame</h2>
            </div> <!-- End of Div -->
            <div class="col-md-4 col-sm-6">
                <a href="#">
                    <img class="img-responsive img-portfolio img-hover" src="http://cache3.asset-cache.net/gc/515407590-earvin-johnson-a-freshman-for-michigan-state-gettyimages.jpg?v=1&c=IWSAsset&k=2&d=X7WJLa88Cweo9HktRLaNXvlNffp2g8fFIlBimJAvBMEcn2%2FvzeOKsForCVPhZp4dCgu7KiZ4r1FcDZSOjgoy1g%3D%3D" alt="">
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="#">
                    <img class="img-responsive img-portfolio img-hover" src="http://thumb.usatodaysportsimages.com/image/thumb/650-510nw/8409999.jpg" alt="">
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="#">
                    <img class="img-responsive img-portfolio img-hover" src="http://blogcdn.champssports.com/assets/2015/03/juwan-howard-jalen-rose-chris-webber-fab-5-michigan-600x500.jpg" alt="">
                </a>
            </div>
        </div>

        <!-- Features Section -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Michigan Basketball Camps</h2>
            </div> <!-- End of Div -->
            <div class="col-md-6">
                <p><strong>Michigan Basketball Camp Cities<strong></p>
                <ul>
                    <li>Saginaw</li>
                    <li>Flint</li>
                    <li>Detroit</li>
                    <li>Farwell</li>
                    <li>Muskegon</li>
                </ul>
                <p>A taste of Basketball from a Michiganders view!</p>
            </div> <!-- End of Class Div -->
            <div class="col-md-6">
                <img class="img-responsive" src="http://cdn.onlyinyourstate.com/wp-content/uploads/2015/11/Ice-skating-700x450.jpg" alt="">
            </div> <!-- End of Div -->
        </div> <!-- End of Row -->
        
		<br /><br /><br />
		<div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-star-half-o"></i>Rate our page</h4>
					</div>
                    <div class="panel-body">
                        <p>From 5 to 5, how 5 is our site?!</p>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $("#jqxRating").jqxRating({ width: 250, height: 35 });
                                    // bind to jqxRating 'change' event.
                                    $("#jqxRating").bind('change', function (event) {
                                        $("#rate").html('<span>' + event.value + '</span');
                                    });
                                });
                            </script>
                            <div id="jqxRating"></div>
                            <div style="margin-top: 10px;">
                                <div style="float: left;">
                                    Rating: </div>
                                <div style="float: left;" id="rate">
                                </div>
                            </div>
                    </div><!-- End of panel body div -->
                </div>  <!-- End of panel panel div -->
            </div>  <!-- End of col div -->
  	   <hr>
       <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Bateson Co. 2016</p>
                </div>
            </div>
        </footer>
		
    </div><!-- End of Container -->
    
	<br /><br /><br />
	
    <!-- jQuery Version 1.11.0 -->
    <script src="http://csis.svsu.edu/~wtbateso/cis255/wtbateso/bootstraptemp/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="http://csis.svsu.edu/~wtbateso/cis255/wtbateso/bootstraptemp/js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>
	
	<!-- Widget -->
	<script src="http://csis.svsu.edu/~gpcorser/cis255/gpcorser/Chart.js-master/dist/Chart.js"></script>
	<link rel="stylesheet" href="http://www.jqwidgets.com/jquery-widgets-documentation/jqwidgets/styles/jqx.base.css" type="text/css"/>	
	<link rel="stylesheet" href="http://www.jqwidgets.com/jquery-widgets-documentation/jqwidgets/styles/jqx.arctic.css" type="text/css"/>
	<script type="text/javascript" src="http://www.jqwidgets.com/jquery-widgets-documentation/jqwidgets/jqxcore.js"></script>
	<script type="text/javascript" src="http://www.jqwidgets.com/jquery-widgets-documentation/jqwidgets/jqxchart.core.js"></script>
	<script type="text/javascript" src="http://www.jqwidgets.com/jquery-widgets-documentation/jqwidgets/jqxdatetimeinput.js"></script>
	<script type="text/javascript" src="http://www.jqwidgets.com/jquery-widgets-documentation/jqwidgets/jqxcalendar.js"></script>
	<script type="text/javascript" src="http://www.jqwidgets.com/jquery-widgets-documentation/jqwidgets/jqxrating.js"></script>
    <script type="text/javascript" src="http://www.jqwidgets.com/jquery-widgets-documentation/jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="http://www.jqwidgets.com/jquery-widgets-documentation/jqwidgets/jqxknob.js"></script>
    <script type="text/javascript" src="http://www.jqwidgets.com/jquery-widgets-documentation/jqwidgets/jqxnumberinput.js"></script>
    <script type="text/javascript" src="http://www.jqwidgets.com/jquery-widgets-documentation/scripts/demos.js"></script>
	<script type="text/javascript" src="http://www.jqwidgets.com/jquery-widgets-documentation/jqwidgets/globalization/globalize.js"></script>
	
	
		
	<script type="text/javascript">
        $(document).ready(function () {
            // Create jqxRating
            $("#jqxRating").jqxRating({ width: 350, height: 35, theme: 'classic'});
            $("#jqxRating").on('change', function (event) {
                $("#rate").find('span').remove();
                $("#rate").append('<span>' + event.value + '</span');
            });
        });
    </script>

	
</body>
</html>
