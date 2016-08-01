<?php
	session_start(); 
	require ("database.php"); 
	
	class Customer { 

		// Create static fields
		private static $id; 
		private static $jobName; 
		private static $jobSalary; 
		private static $companyName; 
		
		 
		// insert a new row into table
		public function insertNew () { 
		 
			echo "<a href='create.php' class='btn btn-success'>Create New</a><br />";
			
			$jobName = "Janitor"; 
			$jobSalary = "24,000"; 
			$companyName = "Cleaning Inc."; 
		 
			$pdo = Database::connect(); 
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "INSERT INTO jobs (jobName,jobSalary,companyName) values(?, ?, ?)"; 
			$q = $pdo->prepare($sql); 
			$q->execute(array($jobName,$jobSalary,$companyName)); 
			Database::disconnect(); 
			// header("Location: program02.php"); 
		} 
		 
		// show records in table format
		public function displayRecords () { 
			echo '<br />';
			$pdo = Database::connect(); 
			$sql = 'SELECT * FROM jobs ORDER BY id DESC'; 
			echo '<table class="table table-striped table-bordered"> 
					<thead> 
					<tr> 
					  <th>jobName</th> 
					  <th>jobSalary</th> 
					  <th>companyName</th> 
					</tr> 
				  </thead> 
				  <tbody>'; 
			 
			foreach ($pdo->query($sql) as $row) { 
				echo '<tr>'; 
				echo '<td>'. $row['jobName'] . '</td>'; 
				echo '<td>'. $row['jobSalary'] . '</td>'; 
				echo '<td>'. $row['companyName'] . '</td>'; 
				echo '<td width=200>'; 
				echo '       ';
				echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>';
				echo '       ';
				echo '<a class="btn" href="update.php?id='. $row['id'].'">Update</a>';		
				echo '       ';
				echo '<a class="btn" href="delete.php?id='. $row['id'].'">Delete</a>';				
				echo '&nbsp;';  
				echo '</td>'; 
				echo '</tr>'; 
			} 
			echo '</tbody></table>'; 
			Database::disconnect(); 
		} 
		 
		function displayDeleteButton () { 
			echo "<a href='delete.php' class='btn btn-success'>Delete </a><br />"; 
		} 
		 
		function displayLoginButton () { 
			echo '<div class=container><div class="offset1 span10"><div class=row><h3>Login</h3></div>
			<form action=program02.php class=form-horizontal method=post><div class=control-group>
			<label class=control-label>User Name</label><div class=controls><input name=userName placeholder=userName>
			</div></div><div class=control-group><label class=control-label>Password</label><div class=controls>
			<input name=password placeholder=password type=password></div></div><div class=form-actions>
			<button class="btn btn-success"type=submit>Create</button> <a class=btn href=camps.php>Back</a></div>
			</form></div></div>'; 
		} 
		
		/function displayCreateScreen(){
			echo '<div class="container"> <div class="span10 offset1"> <div class="row"> <h3>Create a Job</h3>
			</div><form class="form-horizontal" action="program02.php" method="post"><input name="jobName" value="create" type="hidden"> 
			<div class="control-group <label class="control-label">Name</label> <div class="controls"> 
			<input name="jobName" type="text" placeholder="Name" > </div></div><div class="control-group"> 
			<label class="control-label">Job Salary</label> <div class="controls"> 
			<input name="jobSalary" type="text" placeholder="Job Salary"/> </div></div><div class="control-group"> 
			<label class="control-label">Company Name</label> <div class="controls"> 
			<input name="companyName" type="text" placeholder="Company Name"/> </div></div><div class="form-actions"> 
			<button type="submit" class="btn btn-success">Create</button> <a class="btn" href="program02.php">Back</a></div>
			</form></div></div>';
		}
		
		function createRecord($jobName, $jobSalary, $companyName) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO jobs (jobName,jobSalary,companyName,) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($jobName,$jobSalary,$companyName));
			Database::disconnect();
			header("Location: program02.php");
		}
	} 
	
	$cust1 = new Customer; 
	
	
	if(!empty($_POST['create'])) {
		$jobName = $_POST['jobName'];
		$jobSalary = $_POST['jobSalary'];
		$companyName = $_POST['companyName'];
		$cust1->displayRecords($jobName, $jobSalary, $companyName);
	}
	$cust1->displayCreateScreen(); 
	$cust1->insertNew();  
	//$cust1->displayLoginButton(); 
	$cust1->displayRecords(); 
	echo "<br /><br /><br />"; 
	

?>

<!DOCTYPE html>
<html lang="en">
