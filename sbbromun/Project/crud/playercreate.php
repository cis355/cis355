<?php 
/* *******************************************************************
* filename : playercreate.php
* author : Samuel Bromund
* username : sbbromun
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : This file displays interface for adding new record
* to the database table(Players) and allows adding new records.

* input : user input
*
* precondition : database with tables: Players
*	User clicked create on the index.php page.
* postcondition: creation gui made or record added to Players table.
* *******************************************************************
*/

	# include connection data and functions
	require 'database.php';
	#IF there was data passed, then insert the record.
	#otherwise do nothing(that is, just display screen.)
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
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO Players (playerSummonerName,playerRank,rolesToLearn) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($playerSummonerName,$playerRank,$rolesToLearn));
			Database::disconnect();
			header("Location: index.php");
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
		    			<h3>Create a Learner</h3>
		    		</div>
				<!-- text fields used for entry of data.-->
				<!-- Summoner Name section-->
	    			<form class="form-horizontal" action="playercreate.php" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Summoner Name</label>
					    <div class="controls">
					      	<input name="playerSummonerName" type="text"  placeholder="Summoner Name" value="<?php echo !empty($playerSummonerName)?$playerSummonerName:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
				<!-- Rank section-->
					  <div class="control-group <?php echo !empty($rankError)?'error':'';?>">
					    <label class="control-label">Rank</label>
					    <div class="controls">
					      	<input name="playerRank" type="text" placeholder="Bronze 5" value="<?php echo !empty($playerRank)?$playerRank:'';?>">
					      	<?php if (!empty($rankError)): ?>
					      		<span class="help-inline"><?php echo $rankError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <!--Roles section-->
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
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn btn-primary" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>