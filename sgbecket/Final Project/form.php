<!--
/* *******************************************************************
* filename : fomr.php
* author : Gage Beckett
* username : sgbecket
* course : CIS355
* section : 11-MW
* semester : Summer 2016
*
* description : The form that the user fills out and submits that will submit to the user submission 
* database and query the anime database for titles matching the database.
*
* input : anime style period and genre
* output : outputs to the anime database that will show the animes matching those credentials
*
* precondition : valid form feilds
* postcondition: none
* *******************************************************************-->

<?php
class Form{
	private static $genre;
	private static $period;
	private static $style;

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
		';
}
function update(){
	if(!empty($_POST)){
		$id = null;
		if ( !empty($_GET['update'])) {
			$id = $_REQUEST['update'];
		}
		// keep track validation errors

		
		// keep track post values

		$genre = $_POST['genre'];
		$period = $_POST['period'];
		$style = $_POST['style'];
		
		// validate input
		$valid = true;
		
		if($valid){
			$sql = "UPDATE `form user`  set  genre = '$genre', period ='$period', style='$style' WHERE genre = '$id'";
			$con=$this->connect();
			if ($con->query($sql) === TRUE) {

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
			<form class="form-horizontal" action="form.php?update=';echo $id; echo'" method="post">
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
				  <a class="btn btn-warning" href="form.php">Back</a>

				</div>
			</form>
					<div class="modal-footer">
					  <a period="button" class="btn btn-default" href="form.php" >Close</a>
					</div>
				  </div>     
				</div>
			  </div>
			</div>
			</body>
			</html>';
}
	function redirect($genre, $period, $style){
		sleep(1);
		echo '<script>window.location.href="anime.php?genre=' . $genre . '&period='. $period . '&style='. $style . '";</script>';
	}
	private function connect(){
		$c = mysqli_connect("localhost","sgbecket","42BeckettSG","sgbecket");
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{return $c;}
	}
	
	function create(){
		if (!empty($_POST) && $_GET['create']){
		// keep track validation errors
		$genreError = null;
		$periodError = null;
		$styleError = null;
		
		// keep track post values
		$genre = $_POST['genre'];
		$period = $_POST['period'];
		$style = $_POST['style'];
		
		// validate input
		$valid = true;
		if (empty($genre)) {
			$genreError = 'Please enter genre';
			$valid = false;
		}
		
		if (empty($period)) {
			$periodError = 'Please enter Anime period of time';
			$valid = false;
		}
		if (empty($style)) {
			$styleError = 'Please enter Anime Style';
			$valid = false;
		}
		if($valid){
			$con=$this->connect();
			$sql = "INSERT INTO `form user`  (genre, period, style) VALUES ('$genre', '$period', '$style')";
			if ($con->query($sql) === TRUE) {
					$this->redirect($genre, $period, $style);
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
				  <a period="button" class="close" href="form.php">&times;</a>
				  <h4 class="modal-title">Find an Anime </h4>
				</div>
				<div class="modal-body">
			<form class="form-horizontal" action="form.php?create=new" method="post">
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
				  <button period="submit" class="btn btn-success">Find</button>
				  <a class="btn btn-warning" href="form.php">Back</a>
				  <a class="btn btn-info" href="usersub.php">Submit new</a>
				</div>
			</form>
					<div class="modal-footer">
					  <a period="button" class="btn btn-default" href="form.php" >Close</a>
					</div>
				  </div>     
				</div>
			  </div>
			</div>
			</body>
			</html>';
	}
}
public function displayRecords(){
	$con=$this->connect();
	$sql = 'SELECT * FROM `form user`';
		echo '<a class="btn btn-success" href="form.php?create=new">Find</a>';
        echo '<table class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>Genre</th>
                  <th>Period</th>
                  <th>Style</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>';
	foreach ($con->query($sql) as $row) {
            echo '<tr>';
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
        echo '<a class="btn btn-info" href="program02.php?id='. $row['id'].'">Read</a>';
    }
    function displayUpdateButton($row){
        echo '<a class="btn btn-success" href="form.php?update='. $row['genre'].'">Update</a>';
    }
	    function displayDeleteButton($row){
        echo '<a class="btn btn-success" href="program02.php?delete='. $row['id'].'">Delete</a>';
    }
}
	$form1 = new Form;
	$form1->displayRecords();
	if(!empty ($_GET['create'])){
		$form1->create();
	}
		if (!empty ($_GET['update'])){
		$form1->update();
	}
?>