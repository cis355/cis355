<?php 
/* *******************************************************************
* filename : mentorshipcreate.php
* author : Samuel Bromund
* username : sbbromun
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : This file displays interface for adding new record
* to the database table(Mentorships) and allows adding new records.

* input : user input
*
* precondition : database with tables: Players, Mentors, Mentorships
*	User clicked create on the mentorshipindex.php page.
* postcondition: creation gui made or record added to Mentorships table.
* *******************************************************************
*/
	# include connection data and functions
	require 'database.php';
	#IF there was data passed, then insert the record.
	#otherwise do nothing(that is, just display screen.)
	if ( !empty($_POST)) {
		// keep track validation errors
		$playerIDError = null;
		$teacherIDError = null;
		$roleError = null;

		
		// keep track post values
		$playerID = $_POST['playerID'];
		$teacherID = $_POST['teacherID'];
		$roleToTrain = $_POST['roleToTrain'];
		
		// validate input
		$valid = true;
		if (empty($playerID)) {
			$playerIDError = 'Please Enter Player Name';
			$valid = false;
		}
		
		if (empty($teacherID)) {
			$teacherIDError = 'Please Enter Mentor name';
			$valid = false;
		} 
		
		if (empty($roleToTrain)) {
			$roleError = 'Please Enter Role to Train';
			$valid = false;
		}


		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO Mentorships (playerID,teacherID,roleToTrain) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($playerID,$teacherID,$roleToTrain));
			Database::disconnect();
			header("Location: mentorshipindex.php");
		}
	}#END if(!empty($_POST))
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following.
			1. Defines character
			2. Includes bootstrap -->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a Mentorship</h3>
		    		</div>
					<!-- Uses select box to ensure only avaialble learners chosen.-->
	    			<form class="form-horizontal" action="mentorshipcreate.php" method="post">
					    <label class="control-label">Player Name</label>
					    <div class="controls">
					    <select name="playerID">
							<?php
							$pdo = Database::connect();
							$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$sql = 'SELECT learnerID , playerSummonerName FROM Players';				
							foreach ($pdo->query($sql) as $row) {
								echo "<option value=". $row[0] .">" . $row[1] . "</option>";
							}
							Database::disconnect();
							?>
							</select>
					    </div>
					<!-- Uses select box to ensure only avaialble Mentors chosen.-->
					  <div class="control-group <?php echo !empty($teacherIDError)?'error':'';?>">
					    <label class="control-label">Teacher Name</label>
					    <div class="controls">
							<select name="teacherID">
							<?php
							$pdo = Database::connect();
							$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$sql = 'SELECT mentorID , teacherSummonerName FROM Teachers';				
							foreach ($pdo->query($sql) as $row) {
								echo "<option value=".$row[0].">" . $row[1] . "</option>";
							}
							Database::disconnect();
							?>
							</select>
					    </div>
					  </div>
					  <!-- Entry for role to train with mentor-->
					  <div class="control-group <?php echo !empty($roleError)?'error':'';?>">
					    <label class="control-label">Role To Teach</label>
					    <div class="controls">
					      	<input name="roleToTrain" type="text"  placeholder="ADC" value="<?php echo !empty($roleToTrain)?$roleToTrain:'';?>">
					      	<?php if (!empty($roleError)): ?>
					      		<span class="help-inline"><?php echo $roleError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <!-- Submit and cancel buttons-->
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn btn-primary" href="mentorshipindex.php">Back</a>
						</div>
					</form>
				</div>
				

					
    </div> <!-- /container -->
  </body>
</html>