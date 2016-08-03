<?php
	session_start(); 
	require ("database.php"); 

	if ( !empty($_POST)) {
		if (!array_key_exists('id', $_POST)) {
			// keep track validation errors
			$jobNameError = null;
			$jobSalaryError = null;
			$companyNameError = null;
			
			$jobName = $_POST['jobName'];
			$jobSalary = $_POST['jobSalary'];
			$companyName = $_POST['companyName'];
			
			// validate input
			$valid = true;
			if (empty($jobName)) {
				$jobNameError = 'Please enter job Name';
				$valid = false;
			}
			
			if (empty($jobSalary)) {
				$jobSalaryError = 'Please enter Job Salary';
				$valid = false;
			} 
			
			if (empty($companyName)) {
				$companyNameError = 'Please enter Company Name';
				$valid = false;
			}
			
			// insert data
			if ($valid) {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO jobs (jobName,jobSalary,companyName) values(?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($jobName,$jobSalary,$companyName));
				Database::disconnect();
				header("Location: program02.php");
			}
		} else {
			// keep track post values
			$id = $_POST['id'];
			$jobName = $_POST['jobName'];
			$jobSalary = $_POST['jobSalary'];
			$companyName = $_POST['companyName'];
			
			// validate input
			$valid = true;
			if (empty($jobName)) {
				$jobNameError = 'Please enter job Name';
				$valid = false;
			}
			
			if (empty($jobSalary)) {
				$jobSalaryError = 'Please enter Job Salary';
				$valid = false;
			} 
			
			if (empty($companyName)) {
				$companyNameError = 'Please enter Company Name';
				$valid = false;
			}
			
				// update data
			if ($valid) {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "UPDATE jobs  set jobName = ?, jobSalary = ?, companyName =? WHERE id = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($jobName,$jobSalary,$companyName,$id));
				Database::disconnect();
				header("Location: program02.php");
			}
			else {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "SELECT * FROM jobs where id = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($id));
				$data = $q->fetch(PDO::FETCH_ASSOC);
				$jobName = $data['jobName'];
				$jobSalary = $data['jobSalary'];
				$companyName = $data['companyName'];
				Database::disconnect();
			}
		}
	} # end if ( !empty($_POST))
	
	class Customer { 

		// Create static fields
		private static $id; 
		private static $jobName; 
		private static $jobSalary; 
		private static $companyName; 
		
		 
		// show records in table format
		public function displayRecords () { 
			echo '<br />';
			$pdo = Database::connect(); 
			$sql = 'SELECT * FROM jobs ORDER BY id DESC'; 
			echo '<table class="table table-striped table-bordered"> 
					<thead> 
					<tr> 
					  <th>Job Name</th> 
					  <th>Job Salary</th> 
					  <th>Company Name</th> 
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
				echo '<a class="btn" href="program02.php?button=read&id='. $row['id'].'">Read</a>';
				echo '       ';
				echo '<a class="btn" href="program02.php?button=update&id='. $row['id'].'">Update</a>';		
				echo '       ';
				echo '<a class="btn" href="program02.php?button=delete&id='. $row['id'].'">Delete</a>';				
				echo '&nbsp;';  
				echo '</td>'; 
				echo '</tr>'; 
			} 
			echo '</tbody></table>'; 
			Database::disconnect(); 
		} 
		
		function displayCreateScreen(){
			echo '<div class="container"> <div class="span10 offset1"> <div class="row"> <h3>Create a Job</h3>
			</div><form class="form-horizontal" action="program02.php" method="post">
			<div class="control-group <label class="control-label">Job Name</label> <div class="controls"> 
			<input name="jobName" type="text" placeholder="Name" > </div></div><div class="control-group"> 
			<label class="control-label">Job Salary</label> <div class="controls"> 
			<input name="jobSalary" type="text" placeholder="Job Salary"/> </div></div><div class="control-group"> 
			<label class="control-label">Company Name</label> <div class="controls"> 
			<input name="companyName" type="text" placeholder="Company Name"/> </div></div><div class="form-actions"> 
			<button name="create" type="submit" class="btn btn-success">Create</button> <a class="btn" href="program02.php">Back</a></div>
			</form></div></div>';
		}
		
		function displayUpdateScreen($id){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM jobs where id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			$jobName = $data['jobName'];
			$jobSalary = $data['jobSalary'];
			$companyName = $data['companyName'];
			Database::disconnect();
			
			echo '<div class="container"> <div class="span10 offset1"> <div class="row"> <h3>Update a Job</h3>
			</div><form class="form-horizontal" action="program02.php" method="post"><input name="id" value="'.$id.'" type="hidden"> 
			<div class="control-group <label class="control-label">Job Name</label> <div class="controls"> 
			<input name="jobName" type="text" value="'.$jobName.'"></div></div><div class="control-group"> 
			<label class="control-label">Job Salary</label> <div class="controls"> 
			<input name="jobSalary" type="text" value="'.$jobSalary.'"/></div></div><div class="control-group"> 
			<label class="control-label">Company Name</label> <div class="controls"> 
			<input name="companyName" type="text" value="'.$companyName.'"/></div></div><div class="form-actions"> 
			<button name="update" type="submit" class="btn btn-success">Update</button>
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
		
		function deleteRecord($id) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "DELETE FROM jobs WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			Database::disconnect();
			header("Location: program02.php");
		}
		
		function readRecords($id) {
			echo '<br />';
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM jobs where id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			$jobName = $data['jobName'];
			$jobSalary = $data['jobSalary'];
			$companyName = $data['companyName'];
			Database::disconnect();
			
			echo '<table class="table table-striped table-bordered"> 
				<thead> 
				<tr> 
				  <th>Job Name</th> 
				  <th>Job Salary</th> 
				  <th>Company Name</th> 
				</tr> 
			  </thead> 
			  <tbody>'; 
			echo '<tr>'; 
			echo '<td>'. $jobName . '</td>'; 
			echo '<td>'. $jobSalary . '</td>'; 
			echo '<td>'. $companyName . '</td>';  
			echo '</tr>'; 
			echo '</tbody></table>'; 
			Database::disconnect(); 
		}
	}
	
	$cust1 = new Customer; 	
	$cust1->displayCreateScreen(); 
	$cust1->displayRecords(); 
	echo "<br /><br /><br />"; 
	
	if ($_GET['button'] == 'update') {
		$id = $_GET['id'];
		$cust1->displayUpdateScreen($id);
	}
	
	if ($_GET['button'] == 'delete') {
		$id = $_GET['id'];
		$cust1->deleteRecord($id);
	}
	
	if ($_GET['button'] == 'read') {
		$id = $_GET['id'];
		$cust1->readRecords($id);
	}
?>
