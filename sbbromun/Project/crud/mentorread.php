<?php 
/* *******************************************************************
* filename : mentorread.php
* author : Samuel Bromund
* username : sbbromun
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : This file displays a single record from the 
* database table(Mentors).

* input : user input
*
* precondition : database with tables: Mentors
*	User clicked read on the mentorindex.php page.
* postcondition: single record displayed from the Mentors table.
* *******************************************************************
*/
#need for connections
	require 'database.php';
	$mentorID = null;
	#snag request id
	if ( !empty($_GET['mentorID'])) {
		$mentorID = $_REQUEST['mentorID'];
	}
	# somehow if no id now then we just go back to listing page.
	if ( null==$mentorID ) {
		header("Location: mentorindex.php");
	} else {
		# or we connect and execute a sql statement to retrieve the one record and it's info. 		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Teachers where mentorID = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($mentorID));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Read a Mentor</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Summoner Name: </label>
						     	<?php echo $data['teacherSummonerName'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label"> Rank: </label>
						     	<?php echo $data['teacherRank'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Roles Taught: </label>
						     	<?php echo $data['taughtRoles'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn btn-primary" href="mentorindex.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>