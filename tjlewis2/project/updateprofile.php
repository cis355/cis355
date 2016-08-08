<?php
/* *******************************************************************  
* filename     : updateprofile.php 
* author       : Terry Lewis  
* username     : tjlewis2  
* course       : cs355  
* section      : 1  
* semester : Summer 2016  
*  
* description  : This file is responsible for displaying the page where
*  
* input        : none  
* processing   : none
* output       : none  
*  
* precondition : user has a profile
* postcondition: none
* *******************************************************************
*/
	session_start();
	require 'database.php';
		
	if (empty($_SESSION['name'])) header("Location: login.php");
	
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 400px; min-width:1000px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 250%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }

	
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;}
    }
	
	.wrapper {
    text-align: center;
	}

	.button2 {
    position: absolute;
    top: 50%;
	}

	
  </style>
</head>
<body>

<?php include("navbar.php"); ?>  
<div class="container-fluid text-center">

  <div class="row content">
  
	<?php include("sidenav.php"); ?>
	
    <div class="col-sm-8 text-left" >
      <h1>Update Your Profile </h1>

      <h3>Choose an option</h3>
	  
		<div class="wrapper">
		
		<a href="updatepassword.php" class="btn btn-info btn-lg" style="width:500px; margin-bottom:20px">
          <span class="glyphicon glyphicon-wrench"></span> Update Password
        </a><br>
		
		<a href="updateemail.php" class="btn btn-info btn-lg" style="width:500px; margin-bottom:20px">
          <span class="glyphicon glyphicon-wrench"></span> Update Email
        </a><br><br><br>
		
		<p> if you delete your profile all listings posted by you will be deleted and you will be immediately logged out</p>
		<a href="deleteprofile.php" class="btn btn-danger btn-lg" style="width:500px; margin-bottom:20px">
          <span class="glyphicon glyphicon-wrench"></span> Delete Profile
        </a>
		
		</div>
			
    </div>
	
	<?php include("sidenav2.php"); ?>

  </div>
</div>

<footer class="container-fluid text-center">
  <p>Roommate Finder</p>
</footer>

</body>
</html>