<?php 
/* *******************************************************************
* filename : login.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this is the login screen for gigs
*
* purpose: this screen uses database.php to check the entered username and password 
* on this screen to see if they match what is in the users table 
*
* input : database.php
*
* processing : 
* 1. checks to see if the user is not logged in (else go home)
* 2. checks if there was a post sent back to this page
* 3. prints the html elements for a login form and if there were errors 
*  changes the elements to reflect that
* 4. sends the fomr data back through a POST
* 5.pulls data from the POST and tries to validate login info
* 6. then updates the session variables for gigsUserId and gigsUserName
*
* output :html elements for the nav, and a form for logging in with user name and password
*
* precondition : user is not logged in 
* *******************************************************************
*/
	// uses information in the database.php to link to the db
	session_start();
	require 'database.php';
	if (($_SESSION['gigsUserName'] != '') && ($_SESSION['gigsUserId'] != ''))
		header("Location: home.php");
	$userName = null;
	$passwd = null;
	
	
	if ( !empty($_POST)) {
		// keep track validation errors
		// if data was passsed insert record .. else do nothing 
		$userNameError = null;
		$passwdError = null;
		
		// keep track post values
		$userName = $_POST['userName'];
		$passwd = $_POST['passwd'];
		
		// validate input
		// checks that you filled all the fields. 
		$valid = true;
		if (empty($userName)) {
			$userNameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($passwd)) {
			$passwdError = 'Please enter Password';
			$valid = false;
		}
		
		// verify password is correct for user name
		// uses data in the form below to insert a row into the db table 
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM users WHERE userName = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($userName));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			
			if ($results['password'] == $passwd)
			{
				$_SESSION['gigsUserName'] = $userName;
				$_SESSION['gigsUserId'] = $results['userId'];
				
				header("Location: home.php");

			}
			else 
				$passwdError = 'Password and UserName do not match';		
			Database::disconnect();

		}
		else
			$passwd = null;
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

    <title>Gigs|Login</title>

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
            <!-- Top Menu Items -->
            <!--<ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong>John Smith</strong>
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
                                        <h5 class="media-heading">
                                            <strong>John Smith</strong>
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
                                        <h5 class="media-heading">
                                            <strong>John Smith</strong>
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
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-power-off"></i></a>
                        </li>
                    </ul>
                </li>
            </ul>-->
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
								<h1>Login</h1>

										<form action="login.php" method="post">

												<div class="form-group <?php echo !empty($userNameError)?'has-error':'';?>">
														<label class="control-label" for="userName">User Name</label>
														<input type="text" name="userName" class="form-control" id="userName" placeholder="Enter User Name" value="<?php echo !empty($userName)?$userName:'';?>">
														<?php if (!empty($userNameError)): ?>
															<span class="help-inline"><label class="control-label" for="userName">
															<?php echo $userNameError;?>
															</label></span>
														<?php endif; ?>
										 		</div>
												
												<div class="form-group <?php echo !empty($passwdError)?'has-error':'';?>">
														<label class="control-label" for="passwd">Password</label>
														<input type="password" name="passwd" class="form-control" id="passwd" placeholder="Enter Password" value="<?php echo !empty($passwd)?$passwd:'';?>">
														<?php if (!empty($passwdError)): ?>
															<span class="help-inline"><label class="control-label" for="passwd">
															<?php echo $passwdError;?>
															</label></span>
														<?php endif; ?>
										 		</div>
												<div class="form-actions">
													<button type="submit" class="btn btn-success">Login</button>
													<a class="btn btn-danger" href="index.php">Back</a>
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
