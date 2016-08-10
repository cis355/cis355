<?php 
/* *******************************************************************
* filename : mentorshipread.php
* author : Samuel Bromund
* username : sbbromun
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : This file displays a single record from the 
* database table(Mentorships).

* input : user input
*
* precondition : database with tables: Players, Mentors, Mentorships
*	User clicked read on the mentorshipindex.php page.
* postcondition: single record displayed from the Mentorships table.
* *******************************************************************
*/
#need for connections
	require 'database.php';
	$id = null;
	#snag request id
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	# somehow if no id now then we just go back to listing page.
	if ( null==$id ) {
		header("Location: mentorshipindex.php");
	} else {
		# or we connect and execute a sql statement to retrieve the one record and it's info. 
		#long statement due to associative table.
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = 'SELECT * FROM Mentorships INNER JOIN Teachers INNER JOIN Players WHERE Teachers.mentorID = Mentorships.teacherID AND Players.learnerID = Mentorships.playerID';
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
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
		    			<h3>Read a Mentorship</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Player Name: </label>
						     	<?php echo $data['playerSummonerName'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label"> Teacher Name: </label>
						     	<?php echo $data['teacherSummonerName'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Roles to Train: </label>
						     	<?php echo $data['roleToTrain'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn btn-primary" href="mentorshipindex.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>