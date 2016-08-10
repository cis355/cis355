<!-- -+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-
<!--
/* *******************************************************************
* filename : editAnime.php
* author : Gage Beckett
* username : sgbecket
* course : CIS355
* section : 11-MW
* semester : Summer 2016
*
* description : Allows direct edits to the Anime database admin only!
*
* input : info for the data feilds of the database
* output : displays table for admin
*
* precondition : valid database connection
* postcondition: none
* *******************************************************************
+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+- -->
<?php
/*******************************************
one and only class for this program
drives and connects and displays and generates the HTML.
********************************************/
class Anime{
	private static $id;
    private static $name;
    private static $type;
    private static $location;

function __construct(){
	
	echo'<!DOCTYPE html>
	<html lang="en">
	<head>
	  <title>Edit Anime List</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<h2>Edit Anime List</h2>';
}
function read(){
	$id = $_REQUEST['id'];//get id value from url
	$con=$this->connect();//call connect function to connect with database
	$sql = "SELECT * FROM anime where name = '$id'"; //variable to hold sql statement
	$q=mysqli_query($con, $sql); //query the database
	$data = mysqli_fetch_row($q);//get the data from the rom with the $ID

	//echo out the modal with the read information
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
			  <a type="button" class="close" href="editAnime.php">&times;</a>
			  <h4 class="modal-title">Anime: ';echo $data[0]; echo'</h4>
			</div>
			<div class="modal-body">
			  <div class="control-group">
				<label class="control-label">Name</label>
				';echo $data[1]; echo'
			  </div>
			  <div class="control-group">
				<label class="control-label">Genre</label>
				';echo $data[2]; echo'
			  </div>
			  <div class="control-group">
				<label class="control-label">Period</label>
				';echo $data[3]; echo'
			  </div>
			  <div class="control-group">
				<label class="control-label">Style</label>
				';echo $data[4]; echo'
			  </div>
			<div class="modal-footer">
			  <a type="button" class="btn btn-default" href="editAnime.php" >Close</a>
			</div>
		  </div>     
		</div>
	  </div>
	</div>
	</body>
	</html>';
	
} 
//remove item from the table
function remove(){
	
	$id = $_REQUEST['delete'];                  //get id value from url
	$con=$this->connect();                      //call connect function to connect with database
	$sql = "DELETE  FROM anime  WHERE name = '$id'"; //variable to hold sql statement
	if(!empty($_POST)){                         //if the user posted
		$con->query($sql);                      //query the database
		$this->redirect();
	
	}
	//display modal asking user to confirm delete
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
				  <a type="button" class="close" href="editAnime.php">&times;</a>
				  <h4 class="modal-title">Anime: ';echo $id; echo'</h4>
				</div>
				<div class="modal-body">
				  <form class="form-horizontal" action="editAnime.php?delete=';echo $id;echo'" method="post">
					<input type="hidden" name="id" value="'; echo $id; echo'"/>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn btn-default" href="editAnime.php">No</a>
					  </div>
					</form>
				<div class="modal-footer">
				  <a type="button" class="btn btn-default" href="editAnime.php" >Close</a>
				</div>
			  </div>     
			</div>
		  </div>
		</div>
		</body>
		</html>';
	}
	function redirect(){
		    sleep(1);
			echo '<script>window.location.href="editAnime.php";</script>';
	}
	//create new item in the table

/*******************************************
update the selected user information. Could not make it populate the feilds with the exister user information
however it does tell the id of the venue that is being updated. 
*/
function update(){
	if(!empty($_POST)){
		$id = null;
		if ( !empty($_GET['update'])) {
			$id = $_REQUEST['update'];
		}
		// keep track validation errors

		
		// keep track post values
		$name = $_POST['name'];
		$genre = $_POST['genre'];
		$period = $_POST['period'];
		$style = $_POST['style'];
		
		// validate input
		$valid = true;
		
		if($valid){
			$sql = "UPDATE anime  set name = '$name', genre = '$genre', period ='$period', style='$style' WHERE name = '$id'";
			$con=$this->connect();
			if ($con->query($sql) === TRUE) {
				$this->redirect();
				} else {
				echo "Error: " . $sql . "<br>" . $con->error;
			}
			$con->close();
		}
	}


	$id = $_REQUEST['update'];
		
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
				  <a period="button" class="close" href="editAnime.php">&times;</a>
				  <h4 class="modal-title">Find an Anime </h4>
				</div>
				<div class="modal-body">
			<form class="form-horizontal" action="editAnime.php?update=';echo $id; echo'" method="post">
			<div class="control-group">
			  <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"   value="">
					    </div>
					  </div>
			  <div class="control-group">
				<label class="control-label">Genre</label>
				<div class="controls">
					<select class="btn-success" name="genre">
						<option name="genre" value="Action Adventure">Action Adventure</option>
						<option value="Mystery">Mystery</option>
						<option value="Drama">Drama</option>		
						<option value="Romance">Romance</option>
						<option value="Comedy">Comedy</option>
						<option value="Horror">Horror</option>
						<option value="Fantasy">Fantasy</option>
					</select>
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label">Time Period</label>
				<div class="controls">
					<select class="btn-info input-md" name="period">
					  <option value="Medieval">Medieval</option>
					  <option value="Modern">Modern</option>
					  <option value="Future">Future</option>			  
					</select>					
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label">Artist Style</label>
				<div class="controls">
					<select class="btn-warning input-md" name="style">
						  <option value="Shonen">Shonen</option>
						  <option value="Seinen">Seinen</option>
						  <option value="Josei">Josei</option>	
						  <option value="Kodomomuke">Kodomomuke</option>
						  <option value="Shoujo">Shoujo</option>				  
					</select>
				</div>
			  </div>
			  <div class="form-actions" style="margin-top:15px;">
				  <button period="submit" class="btn btn-success">Update</button>
				  <a class="btn btn-warning" href="editAnime.php">Back</a>

				</div>
			</form>
					<div class="modal-footer">
					  <a period="button" class="btn btn-default" href="editAnime.php" >Close</a>
					</div>
				  </div>     
				</div>
			  </div>
			</div>
			</body>
			</html>';
}

/******************************************
connect to the database using mysqli, this function is called throughout the program to establish a valid connection_aborted with the database. 
*****************************************/

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
	$sql = 'SELECT * FROM anime ORDER BY id DESC';
        echo '<table class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Genre</th>
                  <th>Period</th>
                  <th>Style</th>
				  <th>Action</th>
                </tr>
              </thead>
              <tbody>';
	foreach ($con->query($sql) as $row) {
            echo '<tr>';
            echo '<td>'. $row['name'] . '</td>';
            echo '<td>'. $row['genre'] . '</td>';
            echo '<td>'. $row['period'] . '</td>';
			echo '<td>'. $row['style'] . '</td>';
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
        echo '<a class="btn btn-info" href="editAnime.php?id='. $row['name'].'">Read</a>';
    }
    function displayUpdateButton($row){
        echo '<a class="btn btn-success" href="editAnime.php?update='. $row['name'].'">Update</a>';
    }
	    function displayDeleteButton($row){
        echo '<a class="btn btn-success" href="editAnime.php?delete='. $row['name'].'">Delete</a>';
    }
}
	//create the new venue and call the funtions if the get requests are correct. 
	$anime = new Anime;
	$anime->displayRecords();
	if (!empty ($_GET['update'])){
		$anime->update();
	}
	if(!empty ($_GET['create'])){
		$anime->create();
	}
	if ( !empty($_GET['id'])) {
		$anime->read();
	}
	if (!empty($_GET['delete'])) {

		$anime->remove();
	}

?>