<?php
class Venues{
	private  $id;
    private static $name;
    private static $type;
    private static $location;

function read($data){
	echo '
	  <script>
		function loadModal(){
			$("#myModal").modal("show");
		}
	</script>
	</head>
	<body onload="loadModal();">
	<div class="container">

	  <!-- Modal -->
	  <div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <a type="button" class="close" href="program02.php">&times;</a>
			  <h4 class="modal-title">Venue: ';echo $data[0]; echo'</h4>
			</div>
			<div class="modal-body">
			  <div class="control-group">
				<label class="control-label">Name</label>
				';echo $data[1]; echo'
			  </div>
			  <div class="control-group">
				<label class="control-label">Venue Type</label>
				';echo $data[2]; echo'
			  </div>
			  <div class="control-group">
				<label class="control-label">Venue Location</label>
				';echo $data[3]; echo'
			  </div>
			<div class="modal-footer">
			  <a type="button" class="btn btn-default" href="program02.php" >Close</a>
			</div>
		  </div>     
		</div>
	  </div>
	</div>
	</body>
	</html>';
	
}
function delete($id){
	echo '    		
	<script>
		function loadModal(){
			$("#myModal").modal("show");
		}
	</script>
	</head>
	<body onload="loadModal();">
	<div class="container">

	  <!-- Modal -->
	  <div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <a type="button" class="close" href="program02.php">&times;</a>
			  <h4 class="modal-title">Venue: ';echo $id; echo'</h4>
			</div>
			<div class="modal-body">
			  <form class="form-horizontal" action="program02.php?delete=';echo $id;echo'" method="post">
				<input type="hidden" name="id" value="'; echo $id; echo'"/>
				  <div class="form-actions">
					  <button type="submit" class="btn btn-danger">Yes</button>
					  <a class="btn btn-default" href="program02.php">No</a>
				  </div>
				</form>
			<div class="modal-footer">
			  <a type="button" class="btn btn-default" href="program02.php" >Close</a>
			</div>
		  </div>     
		</div>
	  </div>
	</div>
	</body>
	</html>';
	}

function __construct(){
	
	echo'<!DOCTYPE html>
	<html lang="en">
	<head>
	  <title>Program 02</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<h2>Program 02</h2>';

	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
		$con=$this->connect();
		$sql = "SELECT * FROM venue where id = $id";
		$q=mysqli_query($con, $sql);
		$data = mysqli_fetch_row($q);

		$this->read($data);
	}
	if (!empty($_GET['delete'])) {
		$id = $_REQUEST['delete'];
		$con=$this->connect();
		$sql = "DELETE FROM venue  WHERE id = $id";
		$this->delete($id);
		if(!empty($_POST)){
			$con->query($sql);
			header("Location: program02.php");
		
		}
	}
	if (!empty($_POST) && $_GET['create']){
		// keep track validation errors
		$nameError = null;
		$typeError = null;
		$locationError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$type = $_POST['type'];
		$location = $_POST['location'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($type)) {
			$typeError = 'Please enter type of venue';
			$valid = false;
		}
		if (empty($location)) {
			$locationError = 'Please enter Venue Location';
			$valid = false;
		}
		if($valid){
			$sql = "INSERT INTO venue (name, type, location) VALUES ('$name', '$type', '$location')";
			$con=$this->connect();
			if ($con->query($sql) === TRUE) {
				header("Location: program02.php");
				} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
			$con->close();
		}
	}

	if (!empty($_GET['create'])){
		echo '
		  <script>
			function loadModal(){
				$("#myModal").modal("show");
			}
		</script>
		</head>
		<body onload="loadModal();">
		<div class="container">

		  <!-- Modal -->
		  <div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <a type="button" class="close" href="program02.php">&times;</a>
				  <h4 class="modal-title">New Venue </h4>
				</div>
				<div class="modal-body">
			<form class="form-horizontal" action="program02.php?create=new" method="post">
			  <div class="control-group ';  echo !empty($nameError)?'error':'';echo'">
				<label class="control-label">Name</label>
				<div class="controls">
					<input name="name" type="text"   value="';  echo !empty($name)?$name:'';echo'">
					';  if (!empty($nameError)): echo'
						<span class="help-inline">';  echo $nameError;echo'</span>
					';  endif; echo'
				</div>
			  </div>
			  <div class="control-group ';  echo !empty($typeError)?'error':'';echo'">
				<label class="control-label">Venue Type</label>
				<div class="controls">
					<input name="type" type="text" placeholder="Venue Type" value="';  echo !empty($type)?$type:'';echo'">
					';  if (!empty($typeError)): echo'
						<span class="help-inline">';  echo $typeError;echo'</span>
					';  endif;echo'
				</div>
			  </div>
			  <div class="control-group ';  echo !empty($locationError)?'error':'';echo'">
				<label class="control-label">Venue Location</label>
				<div class="controls">
					<input name="location" type="text"  placeholder="Venue Location" value="';  echo !empty($location)?$location:'';echo'">
					';  if (!empty($locationError)): echo'
						<span class="help-inline">';  echo $locationError;echo'</span>
					';  endif;echo'
				</div>
			  </div>
			  <div class="form-actions">
				  <button type="submit" class="btn btn-success">Create</button>
				  <a class="btn" href="program02.php">Back</a>
				</div>
			</form>
					<div class="modal-footer">
					  <a type="button" class="btn btn-default" href="program02.php" >Close</a>
					</div>
				  </div>     
				</div>
			  </div>
			</div>
			</body>
			</html>';
	}
	if (!empty($_POST) && $_GET['update']){
		$id = null;
		if ( !empty($_GET['update'])) {
			$id = $_REQUEST['update'];
		}
		// keep track validation errors
		$nameError = null;
		$typeError = null;
		$locationError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$type = $_POST['type'];
		$location = $_POST['location'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($type)) {
			$typeError = 'Please enter Venue Type';
			$valid = false;
		} 
		
		if (empty($location)) {
			$locationError = 'Please enter Venue Location';
			$valid = false;
		}
		if($valid){
			$sql = "UPDATE venue  set name = '$name', type = '$type', location ='$location' WHERE id = '$id'";
			$con=$this->connect();
			if ($con->query($sql) === TRUE) {
				header("Location: program02.php");
				} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
			$con->close();
		}
	}

if (!empty($_GET['update'])){
	if ( !empty($_GET['update'])) {
			$id = $_REQUEST['update'];
		}
	echo '
	  <script>
		function loadModal(){
			$("#myModal").modal("show");
		}
		</script>
		</head>
		<body onload="loadModal();">
		<div class="container">

		  <!-- Modal -->
		  <div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <a type="button" class="close" href="program02.php">&times;</a>
				  <h4 class="modal-title">Update Venue: ';echo $id;echo' </h4>
				</div>
				<div class="modal-body">
			<form class="form-horizontal" action="program02.php?update=';echo $id; echo'" method="post">
		  <div class="control-group ';  echo !empty($nameError)?'error':'';echo'">
			<label class="control-label">Name</label>
			<div class="controls">
				<input name="name" type="text"   value="';  echo !empty($name)?$name:'';echo'">
				';  if (!empty($nameError)): echo'
					<span class="help-inline">';  echo $nameError;echo'</span>
				';  endif; echo'
			</div>
		  </div>
		  <div class="control-group ';  echo !empty($typeError)?'error':'';echo'">
			<label class="control-label">Venue Type</label>
			<div class="controls">
				<input name="type" type="text" placeholder="Venue Type" value="';  echo !empty($type)?$type:'';echo'">
				';  if (!empty($typeError)): echo'
					<span class="help-inline">';  echo $typeError;echo'</span>
				';  endif;echo'
			</div>
		  </div>
		  <div class="control-group ';  echo !empty($locationError)?'error':'';echo'">
			<label class="control-label">Venue Location</label>
			<div class="controls">
				<input name="location" type="text"  placeholder="Venue Location" value="';  echo !empty($location)?$location:'';echo'">
				';  if (!empty($locationError)): echo'
					<span class="help-inline">';  echo $locationError;echo'</span>
				';  endif;echo'
			</div>
		  </div>
		  <div class="form-actions">
			  <button type="submit" class="btn btn-success">Update</button>
			  <a class="btn" href="program02.php">Back</a>
			</div>
		</form>
				<div class="modal-footer">
				  <a type="button" class="btn btn-default" href="program02.php" >Close</a>
				</div>
			  </div>     
			</div>
		  </div>
		</div>
		</body>
		</html>';
	}
}

private function connect(){
	$c = mysqli_connect("localhost","sgbecket","42BeckettSG","sgbecket");
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	else{return $c;}
}	
public function displayRecords(){
	$con = $this->connect();
	$sql = 'SELECT * FROM venue ORDER BY id DESC';
		echo '<a class="btn btn-success" href="program02.php?create=new">Create</a>';
        echo '<table class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Venue Type</th>
                  <th>Venue Location</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>';
	foreach ($con->query($sql) as $row) {
            echo '<tr>';
            echo '<td>'. $row['name'] . '</td>';
            echo '<td>'. $row['type'] . '</td>';
            echo '<td>'. $row['location'] . '</td>';
            echo '<td width=250>';
			$this->displayReadButton($row);
            echo '&nbsp;';
			$this->displayUpdateButton($row);
            echo '&nbsp;';
			$this->displayDeleteButton($row);
			echo'</td>';
			echo'</tr>';
	}
	echo '</tbody></table>';
	mysqli_close($con);
}
    function displayReadButton($row){
        echo '<a class="btn btn-info" href="program02.php?id='. $row['id'].'">Read</a>';
    }
    function displayUpdateButton($row){
        echo '<a class="btn btn-success" href="program02.php?update='. $row['id'].'">Update</a>';
    }
	    function displayDeleteButton($row){
        echo '<a class="btn btn-success" href="program02.php?delete='. $row['id'].'">Delete</a>';
    }
}
	$venue1 = new Venues;
	$venue1->displayRecords();
?>