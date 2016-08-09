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
	echo '<table class="table table-striped table-bordered records">
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
		   	echo '<a class="btn" href="program02.php?status=read&id=' . $row['id'] . '">Read</a>';
		   	echo '&nbsp;';
		   	echo '<a class="btn btn-success" 
			   href="program02.php?status=update&id=' . $row['id'] . '">Update</a>';
		   	echo '&nbsp;';
		    echo '<a class="btn btn-danger" 
			  href="program02.php?status=remove&id=' . $row['id'] . '">Delete</a>';
		   	echo '</td>';
		    echo '</tr>';
		}
		echo '</tbody></table>';
		mysqli_close($con);
	}
	
	function displayCreateButton() {
		echo '<a href="program02.php?status=create" class="btn btn-success create">Create New Record</a>';
	}
	
	function displayCreateScreen () { 
		echo ' <div class="container"><div class="span10 offset1"><div class="row"><h3>Create a Gig</h3></div><form class="form-horizontal" action="program02.php" method="post"> <input name="create" value="create" type="hidden"><div class="control-group <label class=" control-label ">Band ID</label><div class="controls "> <input name="bandID" type="text " placeholder="Band ID " ></div></div><div class="control-group "> <label class="control-label ">Venue ID</label><div class="controls "> <input name="venueID" type="text " placeholder="Venue ID "/></div></div><div class="control-group "> <label class="control-label ">Date</label><div class="controls "> <input name="date" type="date " placeholder="Date"/></div></div><div class="control-group <label class=" control-label ">Time</label><div class="controls "> <input name="time" type="time " placeholder="Time" ></div></div><div class="form-actions "> <button type="submit " class="btn btn-success ">Create</button> </div></form></div></div>';
		$bandID= $_POST['bandID'];
		$venueID = $_POST['venueID'];
		$date = $_POST['date'];
		$time = $_POST['time'];
	} 

	function createRecord($bandID, $venueID, $date, $time) {
		$con = mysqli_connect('localhost','kcbenson','Kelsi42B','kcbenson');
		$sql = "INSERT INTO  gigs (bandID,venueID,date,time) values($bandID, $venueID, '$date', '$time')";
		$con->query($sql);
		mysqli_close($con);
		header("Location: program02.php");
	}
	function read() {
		$id = $_GET['id'];
		$con = mysqli_connect('localhost','kcbenson','Kelsi42B','kcbenson');
		$sql = "SELECT * FROM gigs WHERE id = $id";
		$q = $con->query($sql);
		$row = $q->fetch_assoc();
		
		echo '<div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Read a Gig</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Band ID</label>
						     	' . $row['bandID']. '
					  </div>
					  <div class="control-group">
					    <label class="control-label">Venue ID</label>
						     	' . $row['venueID']. '
					  </div>
					  <div class="control-group">
					    <label class="control-label">Date</label>
						     	' . $row['date']. '
					  </div>
					  <div class="control-group">
					    <label class="control-label">Time</label>
						     	' . $row['time']. '
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="program02.php">Back</a>
					   </div>

					</div>
				</div>
				
		</div>';
		mysqli_close($con);
	}
	function displayUpdateScreen() {
		$id = $_GET['id'];
		$con = mysqli_connect('localhost','kcbenson','Kelsi42B','kcbenson');
		$sql = "SELECT * FROM gigs WHERE id = $id";
		$q = $con->query($sql);
		$data = $q->fetch_assoc();
		$bandID = $data['bandID'];
		$venueID = $data['venueID'];
		$date = $data['date'];
		$time = $data['time'];
		mysqli_close($con);
		echo '<div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update a Gig</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="program02.php?id=' . $id . '" method="post">
					<input name="update" value="update" type="hidden">
					  <div class="control-group">
					    <label class="control-label">Band ID</label>
					    <div class="controls">
					      	<input name="bandID" type="text"  placeholder="Band ID" value="' . $bandID . '">
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Venue ID</label>
					    <div class="controls">
					      	<input name="venueID" type="text" placeholder="Venue ID" value="' . $venueID . '">
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Date</label>
					    <div class="controls">
					      	<input name="date" type="date"  placeholder="Date" value="' . $date . '">
					    </div>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Time</label>
					    <div class="controls">
					      	<input name="time" type="time"  placeholder="Time" value="' . $time . '">
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="program02.php">Back</a>
						</div>
					</form>
				</div>
			</div>';
	}
	function update($bandID, $venueID, $date, $time) {
		$id = $_GET['id'];
		$con = mysqli_connect('localhost','kcbenson','Kelsi42B','kcbenson');
		$sql = "UPDATE gigs SET bandID = $bandID, venueID = $venueID, date = '$date', time = '$time' WHERE id = $id";
		$con->query($sql);
		mysqli_close($con);
		header("Location: program02.php");
	}
	function displayRemoveScreen(){
		$id = $_GET['id'];
		echo'<div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Delete a Gig</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="program02.php?id=' . $id . '" method="post">
					<input name="remove" value="remove" type="hidden">
	    			  <input type="hidden" name="id" value="' . $id . '"/>
					  <p class="alert alert-error">Are you sure to remove this gig?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn" href="program02.php">No</a>
						</div>
					</form>
				</div>
				
		</div>';
	}	

	function hideRecords() {
		echo '<style>
			.records {
				display: none;
			}
			</style>';
	}
	function hideCreate() {
		echo '<style>
			.create {
				display: none;
			}
			</style>';
	}
}
$gig1 = new Gig;
if(!empty($_POST['create'])) {
	$bandID = $_POST['bandID'];
	$venueID = $_POST['venueID'];
	$date = $_POST['date'];
	$time = $_POST['time'];
	$gig1->createRecord($bandID, $venueID, $date, $time);
}
if(!empty($_POST['update'])) {
	$bandID = $_POST['bandID'];
	$venueID = $_POST['venueID'];
	$date = $_POST['date'];
	$time = $_POST['time'];
	$gig1->update($bandID, $venueID, $date, $time);
}
if(!empty($_POST['remove'])) {
	$id = $_GET['id'];
		// delete data
		$con = mysqli_connect('localhost','kcbenson','Kelsi42B','kcbenson');
		$sql = "DELETE FROM gigs  WHERE id = $id";
		$con->query($sql);
		mysqli_close($con);
		header("Location: program02.php");
}
$gig1->displayCreateButton();
$gig1->displayRecords();
if ($_GET['status'] == create) $gig1->displayCreateScreen();
if ($_GET['status'] == read) {$gig1->hideRecords(); $gig1->hideCreate(); $gig1->read();}
if ($_GET['status'] == update) {$gig1->hideCreate(); $gig1->hideRecords(); $gig1->displayUpdateScreen(); }
if ($_GET['status'] == remove) {$gig1->hideCreate(); $gig1->hideRecords(); $gig1->displayRemoveScreen();}
echo '<br /><br />';
echo '<a href = "https://www.draw.io/?chrome=0&lightbox=1&edit=https%3A%2F%2Fwww.draw.io%2F%23DProgram02.html&nav=1#DProgram02.html">UML diagram</a>';
echo '<br /><br />';
show_source(__FILE__);
?>