<?php
/* *******************************************************************
* filename : program02.php
* author : Kelsi Benson
* username : kcbenson
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program creates a 
* table of records by referencing the customers
* table in the database connected with myqli,
* allows the user to create, read, update and
* delete records.
* The purpose of this program is to demonstrate
* an object-oriented CRUD program and classes.
*
* input : records from database
* processing : The program steps are as follows.
* 1. connect to the database
* 2. display the create new record button
* output : table of records with read, update
* and delete buttons next to each record
*
* *******************************************************************
*/
class Gig {
		private static $id;
		private static $bandID;
		private static $venueID;
		private static $date;
		private static $time;

public function displayRecords () {
	$con = mysqli_connect('localhost','kcbenson','Kelsi42B','kcbenson');
	$sql = 'SELECT * FROM gigs ORDER BY id DESC';
	echo '<table class="table table-striped table-bordered">
		<thead>
		    <tr>
		        <th>Band</th>
		        <th>Venue</th>
		        <th>Date</th>
		        <th>Time</th>
		        <th>Action</th>
		    </tr>
		</thead>
		<tbody>';
		 
		 foreach ($con->query($sql) as $row) {
		  	echo '<tr>';
		   	echo '<td>'. $row['bandID'] . '</td>';
		   	echo '<td>'. $row['venueID'] . '</td>';
		   	echo '<td>'. $row['date'] . '</td>';
		   	echo '<td>'. $row['time'] . '</td>';
		   	echo '<td width="250">';
		   	echo '<a class="btn" href="program02.php?status=read">Read</a>';
		   	echo '&nbsp;';
		   	echo '<a class="btn btn-success" 
			   href="program02.php?status=update">Update</a>';
		   	echo '&nbsp;';
		    echo '<a class="btn btn-danger" 
			  href="program02.php?status=remove">Delete</a>';
		   	echo '</td>';
		    echo '</tr>';
		}
		echo '</tbody></table>';
		mysqli_close($con);
	}
	public function displayCreate() {
		echo "<a href='program02.php?status=create' class='btn btn-success'>Create New Gig</a>";
	}
	function create() {
		# if there was data passed, then insert the record, otherwise just display the HTML 
	if ( !empty($_POST)) {
		// keep track validation errors
		$bandIDError = null;
		$venueIDError = null;
		$timeError = null;
		$dateError = null;
		
		// keep track post values
		$bandID = $_POST['bandID'];
		$venueID = $_POST['venueID'];
		$time = $_POST['time'];
		$date = $_POST['date'];
		
		// validate input
		$valid = true;
		if (empty($bandID)) {
			$bandIDError = 'Please enter a band ID.';
			$valid = false;
		}
		
		if (empty($venueID)) {
			$venueIDError = 'Please enter a venue ID';
			$valid = false;
		}
		if (empty($date)) {
			$dateError = 'Please enter the gig date.';
			$valid = false;
		}
		if (empty($time)) {
			$timeError = 'Please enter the gig time.';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$status = valid;
			
		}
	} 
	function insert() {
		$con = mysqli_connect('localhost','kcbenson','Kelsi42B','kcbenson');
		&sql = "INSERT INTO gigs (bandID, venueID, date, time) values(?, ?, ?, ?)");
		$con->query($sql);
		mysqli_close($con);
		header("Location: program02.php");
	}
	//echo head of html document
	echo '<html lang="en">
		<head>
			<!-- The head section does the following: 
				1. Sets the character set
				2. includes Bootstrap
				-->
			<meta charset="utf-8">
			<link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		</head>';
	//echo body of html
	echo '<body>
		<div class="container">
    		<div class="span10 offset1">
    			<div class="row">
	    			<h3>Create a Customer</h3>
		    	</div>
    			<form class="form-horizontal" action="program02.php?status=create" method="post">
				<div class="control-group'; !empty($bandIDError)?'error':'';echo'">
					    <label class="control-label">Band ID</label>
					    <div class="controls">
					      	<input name="bandID" type="text"  placeholder="bandID" value="'; !empty($bandID)?$bandID:'';echo'">';
					      	if (!empty($bandIDError)):
					      		echo'<span class="help-inline">'; $bandIDError;echo'</span>';
							endif;
					    echo'</div>
					  </div>
					  
					  <div class="control-group'; echo !empty($venueIDError)?'error':'';echo'">
					    <label class="control-label">Venue ID</label>
					    <div class="controls">
					      	<input name="venueID" type="text" placeholder="Venue ID" value="'; echo !empty($venueID)?$venueID:'';echo'">';;
					      	if (!empty($venueIDError)):
					      		echo'<span class="help-inline">'; echo $venueIDError;echo'</span>';
					      	endif;
					   echo' </div>
					  </div>
					  
					  <div class="control-group'; echo !empty($dateError)?'error':''; echo'">
					    <label class="control-label">Date of Gig</label>
					    <div class="controls">
					      	<input name="date" type="text"  placeholder="Date" value="'; echo !empty($date)?$date:''; echo'">';
					      	if (!empty($dateError)):
					      		echo'<span class="help-inline">';echo $dateError; echo'</span>';
					      	endif;
					    echo'</div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="program02.php">Back</a>
					   </div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>';
	}
	function read() {
		$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	} else {
		$con = mysqli_connect('localhost','kcbenson','Kelsi42B','kcbenson');
		$sql = 'SELECT * FROM gigs WHERE id = ?';
		
		Database::disconnect();
	}
	}
	function update() {
		
	}
	function remove() {
		
	}

}
$gig1 = new Gig;
$gig1->displayCreate();
$gig1->displayRecords();
if ($_GET['status'] == create) $gig1->create();
if ($_GET['status'] == valid) $gig1->insert();
if ($_GET['status'] == read) $gig1->read();
if ($_GET['status'] == update) $gig1->update();
if ($_GET['status'] == remove) $gig1->remove();
?>