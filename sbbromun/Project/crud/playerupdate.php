<?php 
/* *******************************************************************
* filename : playerupdate.php
* author : Samuel Bromund
* username : sbbromun
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : This file displays interface updating an existing record
* from the database table(Players) and allows adding new records.

* input : user input
*
* precondition : database with tables: Players
*	User clicked Update on the index.php page.
* postcondition: update gui made or record modified to Players table.
* *******************************************************************
*/
	require 'database.php';
	$learnerID = null;
	if ( !empty($_GET['learnerID'])) {
		$learnerID = $_REQUEST['learnerID'];
	}
	
	if ( null==$learnerID ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$rankError = null;
		$roleError = null;
		
		// keep track post values
		$playerSummonerName = $_POST['playerSummonerName'];
		$playerRank = $_POST['playerRank'];
		$rolesToLearn = $_POST['rolesToLearn'];
		
		// validate input
		$valid = true;
		if (empty($playerSummonerName)) {
			$nameError = 'Please enter Summoner Name';
			$valid = false;
		}
		
		if (empty($playerRank)) {
			$rankError = 'Please enter Player Rank';
			$valid = false;
		} 
		
		if (empty($rolesToLearn)) {
			$roleError = 'Please enter Roles';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Players  set playerSummonerName = ?, playerRank = ?, rolesToLearn =? WHERE learnerID = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($playerSummonerName,$playerRank,$rolesToLearn,$learnerID));
			Database::disconnect();
			header("Location: index.php");
		}
	} else {
		#repopulate gui with current values
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Players where learnerID = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($learnerID));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$playerSummonerName = $data['playerSummonerName'];
		$playerRank = $data['playerRank'];
		$rolesToLearn = $data['rolesToLearn'];
		Database::disconnect();
	}
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
		    			<h3>Update a Learner</h3>
		    		</div>
				<!-- text fields used for entry of data.-->
				<!-- Summoner Name section-->
				<form class="form-horizontal" action="playerupdate.php?learnerID=<?php echo $learnerID?>" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Summoner Name</label>
					    <div class="controls">
					      	<input name="playerSummonerName" type="text"  placeholder="Summoner Name" value="<?php echo !empty($playerSummonerName)?$playerSummonerName:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
				<!-- Player Rank section-->
					  <div class="control-group <?php echo !empty($rankError)?'error':'';?>">
					    <label class="control-label">Rank</label>
					    <div class="controls">
					      	<input name="playerRank" type="text" placeholder="Bronze 5" value="<?php echo !empty($playerRank)?$playerRank:'';?>">
					      	<?php if (!empty($rankError)): ?>
					      		<span class="help-inline"><?php echo $rankError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
				<!-- Roles section-->
					  <div class="control-group <?php echo !empty($roleError)?'error':'';?>">
					    <label class="control-label">Roles To Learn</label>
					    <div class="controls">
					      	<input name="rolesToLearn" type="text"  placeholder="ADC, Top, Mid" value="<?php echo !empty($rolesToLearn)?$rolesToLearn:'';?>">
					      	<?php if (!empty($roleError)): ?>
					      		<span class="help-inline"><?php echo $roleError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <!-- Submit and cancel buttons-->
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn btn-primary" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>